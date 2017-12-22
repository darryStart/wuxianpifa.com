<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\Order;
use App\Models\M3Result;
use DB;
class OrderController extends Controller
{
    /**
    * 订单列表
    * @param  Request $request [description]
    * @return [type]           [description]
    */
    public function toOrder(Request $request)
    {

        $orders = DB::table('order')
            ->leftJoin('user','user.id','=','order.user_id')
            ->select(['nickname','order_no','status','total_price','order.created_at'])
            ->orderBy('order.id','desc')
            ->paginate('11');
        return view('admin.order')->with('orders', $orders);
    }

    /**
     * 订单商品详情
     * @param  string $order_no [description]
     * @return [type]           [description]
     */
    public function toOrderInfo($order_no = ''){
        if($order_no){
            $data = DB::table('carts')->where('order_no', $order_no)->orderBy('id','desc')->get();
            return view('admin.order_info',['data' => $data]);
        }
    }

    /**
     * 订单地址和快递信息
     * @param  string $order_no [description]
     * @return [type]           [description]
     */
    public function toOrderExpress($order_no = ''){
        if($order_no){
            $data = DB::table('order')
                ->leftJoin('user_area','order.area_id','=','user_area.id')
                ->where('order_no',$order_no)
                ->first(['order.express_name','order.status','order.id as oid','order.express_no','user_area.*']);
            return view('admin.order_express',['data' => $data]);
        }
    }

    /**
     * 编辑订单地址信息
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function doOrderExpress(Request $request){
        if($request->method() == 'POST' && ($input = $request->except('_token'))){
            $data = array(
                'express_name' => $input['express_name'],
                'express_no' => $input['express_no'],
                'status' => 3
                );
            $status = DB::table('order')->where('id',$input['id'])->update($data);
            return $status?'200':'400';
        }
    }

    public function toOrderEdit(Request $request)
    {
        $order = Order::find($request->input('id', ''));
        return view('admin.order_edit')->with('order', $order);
    }

    public function orderEdit(Request $request)
    {
        $order = Order::find($request->input('id', ''));
        $order->status = $request->input('status', 1);
        $order->save();

        $m3_result = new M3Result;
        $m3_result->status = 0;
        $m3_result->message = '添加成功';

        return $m3_result->toJson();
    }
}
