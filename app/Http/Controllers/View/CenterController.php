<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entity\Order;
use Session;

use DB;

class CenterController extends Controller
{

    /**
     * 订单列表
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function orderList(Request $request){
        $uid = $request->session()->get('user.id');
        $data = Order::where('user_id', $uid)->whereIn('status',['1','2','3'])->with('carts')->orderBy('id','desc')->get();
        return view('order_list',['data' => $data]);
    }

    /**
     * 伪删除订单
     * @param  Request $request [description]
     * @param  string  $oid     [description]
     * @return [type]           [description]
     */
    public function orderDel(Request $request, $oid = ''){
        if($oid){
            $order = DB::table('order')->where('id',$oid)->first(['order_no']);
            DB::beginTransaction();
            try{
                //删除订单
                DB::table('order')->where('id',$oid)->delete();

                //删除购物车
                DB::table('carts')->where('order_no',$order->order_no)->delete();
              
                DB::commit();
            }catch (Exception $e){
                DB::rollBack();
            }
        }
    }

    /**
     * 个人中心
     * @return [type] [description]
     */
    public function center(Request $request){
        $user = $request->session()->get('user');
        return view('center',['user' => $user]);
    }

    /**
     * 收货地址
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function address(Request $request, $order_no = ''){
        $uid = $request->session()->get('user.id');
        $data = DB::table('user_area')->where(['user_id' => $uid])->orderBy('id','desc')->get(
            ['id','user_id','mobile','user_name','s_province','s_city','s_county','address']
        );

        $order_no != '' && $request->session()->put('order_no',$order_no);
        return view('address', ['data' => $data, 'order_no' => $request->session()->get('order_no'), 'add_id' => $request->session()->get('user.add_id')]);
    }

    /**
     * 添加收货地址
     */
    public function addAddress(){
        return view('add_address');
    }

    /**
     * 编辑页面
     * @param  string $id [description]
     * @return [type]     [description]
     */
    public function editAddress(Request $request, $id = ''){
        if($id){
            $data = DB::table('user_area')->find($id);
            return view('edit_address', ['data' => $data , 'add_id' => $request->session()->get('user.add_id')]);
        }
    }


    /**
     * 执行编辑
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function toEditAddress(Request $request){
        if($input = $request->except('_token')){
            $id = $input['id'];
            $state = $request->input('status',0);
            unset($input['status']);

            //判断是否要更新默认地址
            if($request->session()->get('user.add_id') == $id){//默认地址编辑
                 DB::table('user_area')->where('id', $id)->update($input);
            }else{//非默认地址
                $uid = $request->session()->get('user.id');
                if($state == 1){
                    $status = DB::table('user')->where('id', $uid)->update(['add_id' => $id]);
                    $status && $request->session()->set('user.add_id',$id);
                }
                DB::table('user_area')->where('id', $id)->update($input);
            }
            return redirect('/address');
        }
    }

    /**
     * 执行添加地址
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function toAddAddress(Request $request){

        if($input = $request->except('_token')){
            $input['user_id'] = $request->session()->get('user.id');

            DB::beginTransaction();  
            try { 
                $add_status = $request->input('status',0);
                if($add_status){
                    unset($input['status']);
                }
                $add_id = DB::table('user_area')->insertGetId($input);
                if(!$add_id){
                    throw new \Exception("添加地址失败");
                }

                if(($request->session()->get('user.add_id') == 0) || ($add_status == 1)){
                    $status = DB::table('user')->where('id',$input['user_id'])->update(['add_id' => $add_id]);
                    if(!$status){
                        throw new \Exception("更新默认地址失败".$input['user_id']);
                    }
                    $request->session()->set('user.add_id',$add_id);
                }
                DB::commit();  
                $state = true;
            } catch (Exception $e) {
                DB::rollBack();  
                $state = fales;
            } 
  
            return redirect($state?'/address':'/add_address');
        }
    }

    /**
     * 确认地址
     * @param  request $request [description]
     * @return [type]           [description]
     */
    public function toConfirmAddress(request $request){
        if($id = $request->input('add_id')){
            $order_no = $request->session()->get('order_no');
            DB::table('order')->where('order_no',$order_no)->update(['area_id' => $id]);
            // return redirect('/confirm_order/'. $order_no .'/'.$id);
            $request->session()->put('user.add_id',$id);
            return redirect()->route('confirm_order',['order_no' =>$order_no]);
        }
    }

    /**
     * 申请批发商
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function apply(Request $request){
        $uid = $request->session()->get('user.id');
        $data = DB::table('apply')->where('user_id',$uid)->first();
        return view('apply',['data' => $data]);
    }

    /**
     * 执行申请批发商
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function toApply(Request $request){
        if($input = $request->except('_token')){
            $uid =  $request->session()->get('user.id');
            $input['time'] = time();
            if($input['id']){
                unset($input['id']);
                $input['status'] = 0;
                $status = DB::table('apply')->where('user_id', $uid)->update($input);
            }else{
                $input['user_id'] = $uid;
                $status = DB::table('apply')->insert($input);
            }
            return $status?'200':'400';
        }
    }
}
