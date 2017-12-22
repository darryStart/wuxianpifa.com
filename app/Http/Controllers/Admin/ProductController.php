<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\PdtContent;
use App\Entity\PdtImages;
use Illuminate\Http\Request;
use App\Models\M3Result;
use DB;
use Config;

class ProductController extends Controller
{


    /**
     * 商品列表
     * @return [type] [description]
     */
    public function toProduct()
    {
        $products = DB::table('product')
            ->leftJoin('category', 'product.category_id', '=', 'category.id')
            ->select('product.*', 'category.name as category_name')
            ->orderBy('product.id','desc')
            ->paginate(15);
        return view('admin.product')->with('products', $products);
    }

    /**
     * 批发商品列表
     * @return [type] [description]
     */
    public function toGoods(){
        $goods = DB::table('goods')->orderBy('id','desc')->paginate(15);
        return view('admin.goods')->with('goods',$goods);
    }





    /**
     * 展示普通商品信息
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function toProductInfo(Request $request) {
        $id = $request->input('id', '');

        $product = Product::find($id);

        $product->trade_price = unserialize($product->trade_price);
        
        $product->category = Category::find($product->category_id);

        $pdt_images = PdtImages::where('product_id', $id)->get();

        return view('admin.product_info')->with(
            ['product' => $product, 'pdt_images' => $pdt_images]
        );
    }

    /**
     * 展示批发商品信息
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function toGoodsInfo(Request $request) {
        $id = $request->input('id', 0);

        $goods = DB::table('goods')->find($id);

        $gds_images = DB::table('gds_images')->where('goods_id', $id)->get();

        return view('admin.goods_info')->with(
            ['goods' => $goods, 'gds_images' => $gds_images]
        );
    }



    /**
    * 商品添加页面
    * @return [type] [description]
    */
    public function toProductAdd() {
        $categories = Category::whereNotNull('parent_id')->get();
        return view('admin.product_add')->with('categories', $categories);
    }

    /**
     * 添加批发商品页面
     * @return [type] [description]
     */
    public function toGoodsAdd(){
        return view('admin.goods_add');
    }




    /**
     * 添加商品
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function productAdd(Request $request)
    {
        list($product,$preview) = $this->_product($request);
        $product['created_at']  = date('Y-m-h H:i:s');

        DB::beginTransaction();  
        try {  
            $p_id = Product::insertGetId($product); 

            if(array_filter($preview)){
                foreach(array_filter($preview) as $k => $v) {
                    $data[$k]['product_id'] = $p_id;
                    $data[$k]['image_path'] = trim($v);
                }
                DB::table('pdt_images')->insert($data);
            }

            DB::commit();  
        } catch (Exception $e) {
            DB::rollBack();  
        } 

        $m3_result = new M3Result;
        $m3_result->status = 0;
        $m3_result->message = '添加成功';

        return $m3_result->toJson();
    }



    /**
     * 添加批发商品
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function goodsAdd(Request $request)
    {
        list($goods,$preview) = $this->_goods($request);
        $goods['created_at']  = date('Y-m-h H:i:s');

        DB::beginTransaction();  
        try {  
            $g_id = DB::table('goods')->insertGetId($goods); 

            if(array_filter($preview)){
                foreach(array_filter($preview) as $k => $v) {
                    $data[$k]['goods_id'] = $g_id;
                    $data[$k]['image_path'] = trim($v);
                }
                DB::table('gds_images')->insert($data);
            }

            DB::commit();  
        } catch (Exception $e) {
            DB::rollBack();  
        } 

        $m3_result = new M3Result;
        $m3_result->status = 0;
        $m3_result->message = '添加成功';

        return $m3_result->toJson();
    }




    /**
    * 编辑商品页面
    * @param  Request $request [description]
    * @return [type]           [description]
    */
    public function toProductEdit(Request $request)
    {
        $id = $request->input('id', '');

        $product = Product::find($id);

        $product->trade_price = unserialize($product->trade_price);

        $pdt_images = DB::table('pdt_images')->where('product_id', $id)->get();

        $categories = Category::whereNotNull('parent_id')->get();

        return view('admin.product_edit')->with(
            ['product' => $product, 'pdt_images' => $pdt_images,'categories' => $categories]
        );
    }

    /**
    * 编辑批发商品页面
    * @param  Request $request [description]
    * @return [type]           [description]
    */
    public function toGoodsEdit(Request $request)
    {
        $id = $request->input('id', '');

        $goods = DB::table('goods')->find($id);

        $gds_images = DB::table('gds_images')->where('goods_id', $id)->get();

        return view('admin.goods_edit')->with(
            ['goods' => $goods, 'gds_images' => $gds_images]
        );
    }

    /**
     * 商品编辑
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function productEdit(Request $request){

        list($product,$preview) = $this->_product($request);

        $m3_result = new M3Result;

        DB::beginTransaction();  
        try {  
            $status = Product::where('id',$request->input('pid'))->update($product); 

            DB::table('pdt_images')->where('product_id',$request->input('pid'))->delete();

            if(!empty(array_filter($preview))){
                $data = array();
                foreach(array_filter($preview) as $k => $v) {
                    if(!strpos($v,'/admin/images/icon-add.png')){
                        $data[$k]['product_id'] = $request->input('pid');
                        $data[$k]['image_path'] = trim($v);
                    }
                }
                $data && DB::table('pdt_images')->insert($data);
            }

            DB::commit();
            $m3_result->status = 0;
            $m3_result->message = '编辑成功';
        } catch (Exception $e) {
            DB::rollBack();  

            $m3_result->status = 400;
            $m3_result->message = '编辑失败';
        } 
        return $m3_result->toJson();
    }



    /**
     * 批发商品编辑
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function goodsEdit(Request $request){

        list($goods,$preview) = $this->_goods($request);

        $m3_result = new M3Result;

        DB::beginTransaction();  
        try {  
            $status = DB::table('goods')->where('id',$request->input('gid'))->update($goods); 

            DB::table('gds_images')->where('goods_id',$request->input('gid'))->delete();

            if(!empty(array_filter($preview))){
                $data = array();
                foreach(array_filter($preview) as $k => $v) {
                    if(!strpos($v,'/admin/images/icon-add.png')){
                        $data[$k]['goods_id'] = $request->input('gid');
                        $data[$k]['image_path'] = trim($v);
                    }
                }
                $data && DB::table('gds_images')->insert($data);
            }

            DB::commit();
            $m3_result->status = 0;
            $m3_result->message = '编辑成功';
        } catch (Exception $e) {
            DB::rollBack();  

            $m3_result->status = 400;
            $m3_result->message = '编辑失败';
        } 
        return $m3_result->toJson();
    }

    /**
     * 删除普通商品
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function productDel(Request $request){
        $id = $request->input('id', '');
        $status = DB::table('product')->where('id',$id)->delete();
        DB::table('pdt_images')->where('product_id',$id)->delete();
        return $this->_return($status);
    }

    /**
     * 删除批量商品
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function goodsDel(Request $request){
        $id = $request->input('id', '');
        $status = DB::table('goods')->where('id',$id)->delete();
        DB::table('gds_images')->where('goods_id',$id)->delete();
        return $this->_return($status);
    }

    /**
     * 删除公共返回
     * @param  [type] $status [description]
     * @return [type]         [description]
     */
    private function _return($status){
        $m3_result = new M3Result;
        if($status){
            $m3_result->status = 0;
            $m3_result->message = '删除成功';
        }else{
            $m3_result->status = 400;
            $m3_result->message = '删除失败';
        }
        return $m3_result->toJson();
    }

    /**
     * 普通商品数据处理
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    private function _product($request){

        $product['name']        = $request->input('name');
        $product['summary']     = $request->input('summary');
        $product['price']       = $request->input('price', 0);
        $product['category_id'] = $request->input('category_id');
        $product['preview']     = $request->input('preview');
        $product['content']     = $request->input('content');
        $product['trade_price'] = serialize($request->input('trade'));
        $product['sales_num']   = $request->input('sales_num',0);

        $product['preview'] == '' && $product['preview'] = Config::get('web.preview_default');
        return array($product,$this->_imgs($request));
    }

    /**
     * 批发商品数据处理
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    private function _goods($request){
        $goods['name']        = $request->input('name');
        $goods['summary']     = $request->input('summary');
        $goods['wholesale_price']       = $request->input('wholesale_price', 0);
        $goods['wholesale_total']       = $request->input('wholesale_total', 0);
        $goods['preview']     = $request->input('preview');
        $goods['content']     = $request->input('content');
        $goods['end_time']    = strtotime($request->input('end_time',time()));
        $goods['wholesale_num'] = $request->input('wholesale_num',0);

        $goods['preview'] == '' && $goods['preview'] = Config::get('web.preview_default');

        return array($goods,$this->_imgs($request));
    }

    /**
     * 图片处理
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    private function _imgs($request){
        $preview[] = $request->input('preview1');
        $preview[] = $request->input('preview2');
        $preview[] = $request->input('preview3');
        $preview[] = $request->input('preview4');
        $preview[] = $request->input('preview5');
        return $preview;
    }
}
