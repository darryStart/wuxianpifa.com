<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order;
use DB;
use Log;

class PayController extends Controller
{

    /**
     * 调起支付
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function wx_pay(Request $request){
        if($input = $request->except('_token')){

            //创建订单
            $product = [  
                'trade_type'       => 'JSAPI',
                'body'             => '商品批发',  
                'detail'           => date('Y-m-d H:i:s',time()).'支付订单:'.$input['id'],  
                'out_trade_no'     => $input['id'].'-'.rand(1000,9999),  
                'total_fee'        => $input['total']*100, //单位只能是分。  
                'notify_url'       => 'http://zhijie.pro/notify_url', 
                'openid'           => $request->session()->get('user.openid'),  
            ];  
            $order = new Order($product);  

            Log::info('WXORDER:', ['order' => $order]);

            //获取配置
            $app = new Application(config('wechat'));  
            $payment = $app->payment;  
            $result = $payment->prepare($order);   
            $prepayId = null;  
            if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){  
                $prepayId = $result->prepay_id;   
                $config = $payment->configForJSSDKPayment($prepayId);
                return json_encode(['code' => 200 ,'data' => $config]);
            } else {
                return json_encode(['code' => 401 , 'msg' => '出错了请稍后再试!' ]);
            }  
        }else{
            return json_encode(['code' => 400, 'msg' => '请求出错！']);
        }
    }

    /**
     * 支付回调
     * @return [type] [description]
     */
    public function wx_notify_url(){
        $app = new Application(config('wechat'));  
        $response = $app->payment->handleNotify(function($notify, $successful){

            $out_trade_no = substr($notify->out_trade_no, 0,18);

            //写入日志
            Log::info('WXPAY:', ['notify' => $notify , 'successful' => $successful]);

            //查询订单
            $order = DB::table('order')->where('order_no',$out_trade_no)->first();

            // 如果订单不存在
            if (!$order) { 
                return 'Order not exist.';
                Log::info('这是微信支付后返回的信息订单：（' . $out_trade_no.'）不存在！');
            }

            // 检查订单是否已经更新过支付状态
            if ($order->status == '2') { 
                return true; // 已经支付成功了就不再更新了
            }

            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态
                $data['updated_at'] = date('Y-m-d H:i:s'); // 更新支付时间为当前时间
                $data['status'] = 2; // 更新支付时间为当前时间
                $data['pay_order_no'] = $notify->out_trade_no;

                //更新商品表
                $carts = DB::table('carts')->where('order_no', $out_trade_no)->get(['goods_id','goods_num','shop_type']);
                foreach ($carts as $v) {//批发购买
                    if($v->shop_type == '2'){ 
                        $table_name = 'goods'; 
                        $var = 'wholesale_num';
                    }

                    if($v->shop_type == '3'){ //普通购买
                        $table_name = 'product'; 
                        $var = 'sales_num';
                    }
                    DB::table($table_name)->where('id',$v->goods_id)->increment($var,$v->goods_num);
                }
                

            } else { // 用户支付失败
                $data['status'] = 4;
                Log::info('这是微信支付后返回的信息订单：（' . $out_trade_no.'）失败！');
            }
            DB::table('order')->where('order_no',$out_trade_no)->update($data); // 保存订单
            return true; // 返回处理完成
        });
        return $response;
    }

    /**
     * 退款
     * @return [type] [description]
     */
    public function refund(){
        $app = new Application(config('wechat'));

        //查询到期商品
        $time = time();
        $goods = DB::select('select id from '.env('DB_PREFIX').'goods where wholesale_total > wholesale_num and status != ? and end_time < ?',['3', $time]);


        if(!$goods){ return;}
        foreach ($goods as $k => $v) {

            //通过到期商品查询多个订单信息
            $data = DB::table('carts')
                ->LeftJoin('order','order.order_no', '=', 'carts.order_no')
                ->where(['goods_id' => $v->id, 'shop_type' => 2,'carts_status' => 0, 'order.status' => 2])
                ->select(['order.pay_order_no','order.order_no','carts.goods_num','carts.goods_price','order.refund_code','order.total_price'])
                ->get();

            $data = array_filter($data);

            if(empty($data)){
               DB::table('goods')->where('id',$v->id)->update(['status' => 3]);
            }else{//商品下架
                
                foreach ($data as $vv) {
                    if(!empty($vv)){
                        //整理退款数据
                        $result = [];
                        $refund_code = $vv->refund_code == '' ? date('YmdHis').time(1000,9999) : $vv->refund_code;
                        $total_price = $vv->total_price * 100;
                        $refund_price = $vv->goods_price * $vv->goods_num * 100;

                        //执行退款
                        $result = $app->payment->refund($vv->pay_order_no, $refund_code, $total_price, $refund_price);

                        //退款成功操作
                        if(($result->return_code == 'SUCCESS') && ($result->return_msg == 'OK') && ($result->result_code == 'SUCCESS')){

                            DB::beginTransaction();
                            try{

                                //更新下架退款
                                DB::table('goods')->where('id',$v->id)->update(['status' => 3]);

                                //更新订单
                                $or_status = DB::table('order')->where('pay_order_no',$vv->pay_order_no)->update(['refund_code' => $refund_code]);
                                if(!$or_status) {
                                    throw new Exception('订单更新失败，请稍后');
                                }

                                //更新购物车
                                $cart_status = DB::table('carts')->where('order_no', $vv->order_no)->update(['carts_status' => 1]);
                                if(!$cart_status) {
                                    throw new Exception('购物车更新失败,请稍后');
                                }
                              
                                DB::commit();
                            }catch (Exception $e){
                                DB::rollBack();
                                Log::info('RefundPayDbError:',['refund' => $result]);//更新数据失败日志
                            }
                        }else{
                            Log::info('RefundPayError:',['refund' => $result]);//更新退款失败日志
                        }
                       
                        Log::info('RefundPaySuccess:',['refund' => $result]);//更新退款成功日志
                    }

                }
            }

        }
        return;
    }
}