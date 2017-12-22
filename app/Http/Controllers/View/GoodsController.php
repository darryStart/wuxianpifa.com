<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Entity\Category;
use App\Entity\Product;
use App\Models\M3Result;
use DB;
use Cache;
use Session;

class GoodsController extends Controller
{

    /**
     * 普通商品
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function goodsList(Request $request, $cate = 0){

        if($cate > 0){
            //分类处理
            $category = DB::table('category')->find($cate,['name']);

            return view('goods',['title' => $category->name, 'cate' => $cate]);
        }else{//首页
            $category = DB::table('category')->orderBy('category_no','desc')->get(['id','name','img_url']);
            $cates = array();
            $num = ceil(count($category)/8);
            for($i = 0; $i < $num; $i++)  
            {  
                $cates[] = array_slice($category, $i * 8 ,8);  
            }  
            return view('goods',['cates' => $cates, 'cate' => $cate]);        
        }
    }

    /**
     * 普通商品请求数据
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function ajaxGoodsList(Request $request){
        if($request->method() == 'POST'){
            $page = $request->input('page');
            $cate = $request->input('cate');

            $page_num = 6;
            if($cate){
                $data = DB::table('product')->where('category_id',$cate)->orderBy('id','desc')->forPage($page,$page_num)->get();
            $count = DB::table('product')->where('category_id',$cate)->count('id');
            }else{
                $data = DB::table('product')->where('category_id','>',$cate)->orderBy('id','desc')->forPage($page,$page_num)->get();
                $count = DB::table('product')->where('category_id','>',$cate)->count('id');
            }
            
            $pages = ceil($count/$page_num);

            $user = DB::table('user')->where('id',$request->session()->get('user.id'))->first(['active']);
            if($user->active != '1'){
                foreach ($data as &$v) {
                    $v->price = '';
                }
            }

            $data = array('data' => $data, 'pages' => $pages);

            return $data; 
        }

    }

    /**
     * 拼单页面
     * @return [type] [description]
     */
    public function goodsJoin()
    {
        return view('goods_join');
    }

    /**
     * 拼单数据
     * @return [type] [description]
     */
    public function goodsJoinList(Request $request, $page = 1){
        $page_num = 6;
        $time = time();
        $data = DB::table('goods')->where('end_time','>',$time)->orderBy('id','desc')->forPage($page,$page_num)->get();
        $count = DB::table('goods')->where('end_time','>',$time)->count('id');
        $pages = ceil($count/$page_num);
        $user = DB::table('user')->where('id',$request->session()->get('user.id'))->first(['active']);
        if($user->active != '1'){
            foreach ($data as &$v) {
                $v->wholesale_price = '';
            }
        }
        $data = array('data' => $data, 'pages' => $pages);
    	return $data; 
    }

    /**
     * 拼单详情页
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function goodsDetails(Request $request, $id = 0){
        $time = time();
        $data = DB::table('goods')->where('end_time','>',$time)->find($id,['id','preview','name','summary','wholesale_price','wholesale_total','wholesale_num','content','end_time']);
        if($data){
            $data_imgs = DB::table('gds_images')->where('goods_id',$id)->limit(5)->get(['image_path']);

            $time = $data->end_time - time();
            $progress = ceil($data->wholesale_num / $data->wholesale_total*100);
            $user = DB::table('user')->where('id',$request->session()->get('user.id'))->first(['active']);
            $data->wholesale_price = ($user->active != '1')?'':$data->wholesale_price;

    	    return view('goods_details')->with(['goods' => $data, 'time' => $time ,'gds_images' => $data_imgs, 'progress' => $progress]);
        }else{
            return  redirect('/goods_join');
        }
    }

    /**
     * 普通商品详情页
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function details(Request $request, $id = 0){
        $data = DB::table('product')->find($id,['id','preview','name','summary','price','trade_price','content','sales_num']);
        $data_imgs = DB::table('pdt_images')->where('product_id',$id)->limit(5)->get(['image_path']);
        $data->trade_price = unserialize($data->trade_price);

        $user = DB::table('user')->where('id',$request->session()->get('user.id'))->first(['active']);
        $data->price = ($user->active != '1')?'':$data->price;
        return view('details')->with(['goods' => $data, 'gds_images' => $data_imgs]);
    }


    /**
     * 购物车
     */
    public function GoodsCarts(Request $request){
        $uid = $request->session()->get('user.id');
        $data = DB::table('carts')->where(['user_id' => $uid, 'goods_status' => 0])->get();
    	return view('carts',['data' => $data]);
    }

    /**
     * 添加购物车
     * @return [type] [description]
     */
    public function toCartsAdd(Request $request){
        if($request->getMethod() == 'POST' && ($input = $request->except('_token'))){

            $uid = $request->session()->get('user.id');

            //查询是否已经添加
            $count = DB::table('carts')->where(['goods_id' => $input['goods_id'], 'shop_type' => $input['shop_type'] , 'user_id' => $uid, 'goods_status' => 0])->count('id');
            if($count){
                return '已添加至购物车';
            }

            //添加至购物车
            $input['user_id'] = $uid;
            $status = DB::table('carts')->insert($input);
            return $status?'添加购物车成功':'添加购物车失败';
        }
    }

    /**
     * 删除购物车
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function toCartsDel(Request $request){
        $status = '';
        if($request->getMethod() == 'POST' && ($id = $request->input('id'))){
            $uid = $request->session()->get('user.id');
            $status = DB::table('carts')->where(['id' => $id , 'user_id' => $uid])->delete();
        }
        return $status?'200':'400';
    }

    /**
     * 添加订单
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function toOrderAdd(Request $request){
        if($input = $request->except('_token')){

            $order_no = date('YmdHis').mt_rand(1000,9999);

            $goods_info = explode(',', $input['goods_info']);
            foreach ($goods_info as $k => $v) {
                $temp = explode('-', $v);
                $data[$k]['id'] = $temp[0];
                $data[$k]['goods_num'] = $temp[1];
                $data[$k]['goods_status'] = 1;
                $data[$k]['order_no'] = $order_no;
                $data[$k]['update_at'] = date('Y-m-d H:i:s');
            }

            $order_data = array(
                'user_id' => $request->session()->get('user.id'),
                'order_no' => $order_no,
                'total_price' => $input['total_price'],
                'created_at' => date('Y-m-d H:i:s'),
                'area_id' => $request->session()->get('user.add_id')
            );

            DB::beginTransaction();
            try{
                $carts_status = $this->updateBatch(env('DB_PREFIX').'carts', $data); 
                if (!$carts_status) {
                    throw new \Exception("购物车操作失败");
                }

                $order_status = DB::table('order')->insert($order_data);
                if (!$order_status) {
                    throw new \Exception("订单添加失败");
                } 

                DB::commit();
                return json_encode(array('code' => 200, 'data' => $order_no , 'msg' => ''));
            } catch (Exception $e){
                DB::rollBack();//事务回滚
                return json_encode(array('code' => 400, 'data' => '' , 'msg' => $e->getMessage()));
            }
        }
    }


    /**
     * 确认订单
     * @param  string $order_no   [description]
     * @param  string $address_id [description]
     * @return [type]             [description]
     */
    public function confirmOrder(Request $request, $order_no = '', $address_id = ''){
        if($order_no){
            $data = DB::table('carts')->where(['order_no' => $order_no])->get();
            $total = DB::table('order')->where(['order_no' => $order_no])->first(['total_price']);
            $where = $address_id ? array('id' => $address_id) : array('id' => $request->session()->get('user.add_id'));
            
            $area = DB::table('user_area')->where($where)->first();
            return view('confirm_order',['data' => $data, 'total' => $total->total_price, 'order_no' => $order_no, 'area' => $area]);
        }
    }

    /**
     * [updateBatch description]
     * @param  string $tableName    [description]
     * @param  array  $multipleData [description]
     * @return [type]               [description]
     */
    private function updateBatch($tableName = "", $multipleData = array()){

        if( $tableName && !empty($multipleData) ) {

            // column or fields to update
            $updateColumn = array_keys($multipleData[0]);
            $referenceColumn = $updateColumn[0]; //e.g id
            unset($updateColumn[0]);
            $whereIn = "";

            $q = "UPDATE ".$tableName." SET "; 
            foreach ( $updateColumn as $uColumn ) {
                $q .=  $uColumn." = CASE ";

                foreach( $multipleData as $data ) {
                    $q .= "WHEN ".$referenceColumn." = ".$data[$referenceColumn]." THEN '".$data[$uColumn]."' ";
                }
                $q .= "ELSE ".$uColumn." END, ";
            }
            foreach( $multipleData as $data ) {
                $whereIn .= "'".$data[$referenceColumn]."', ";
            }
            $q = rtrim($q, ", ")." WHERE ".$referenceColumn." IN (".  rtrim($whereIn, ', ').")";

            // Update  
            return DB::update(DB::raw($q));

        } else {
            return false;
        }
    }
}
