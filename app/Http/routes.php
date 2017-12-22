<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::group(['middleware' => 'check.weixin'], function () {//验证微信登录

    Route::get('/','View\GoodsController@goodsList');//单买商品

    Route::get('/cate/{cate}','View\GoodsController@goodsList');//分类商品
    Route::post('/ajax_goods_list','View\GoodsController@ajaxGoodsList');//请求商品
    Route::get('/details/{id}','View\GoodsController@details');//商品详情

    Route::get('/goods_join','View\GoodsController@goodsJoin');//批发拼单
    Route::get('/goods_join_list/{page}','View\GoodsController@goodsJoinList');//拼单分页
    Route::get('/goods_details/{id}','View\GoodsController@goodsDetails');//商品详情

    Route::post('/carts_add','View\GoodsController@toCartsAdd');//购物车
    Route::get('/carts','View\GoodsController@goodsCarts');//购物车
    Route::post('/carts_del','View\GoodsController@toCartsDel');//删除购物车

    Route::post('/order_add','View\GoodsController@toOrderAdd');//添加订单
    Route::get('/confirm_order/{order_no}/{address_id?}','View\GoodsController@confirmOrder')->name('confirm_order');//确认订单
    Route::get('/order_list','View\CenterController@orderList');//订单列表
    Route::get('/order_del/{oid}','View\CenterController@orderDel');//伪删除订单

    Route::get('/center', 'View\CenterController@center');//个人中心
    Route::get('/address/{order_no?}','View\CenterController@address');//地址管理
    Route::get('/add_address', 'View\CenterController@addAddress');//添加地址页面
    Route::post('/to_add_address', 'View\CenterController@toAddAddress');//添加地址
    Route::get('/edit_address/{id}', 'View\CenterController@editAddress');//编辑地址
    Route::post('/to_edit_address', 'View\CenterController@toEditAddress');//编辑地址
    Route::post('/confirm_address', 'View\CenterController@toConfirmAddress');//订单确定地址
    Route::get('/apply','View\CenterController@apply');//申请批发商
    Route::post('/do_apply','View\CenterController@toApply');//执行申请


    Route::any('/pay','View\PayController@wx_pay');//获取配置

    Route::get('/msg/{status}','View/MsgController@msg');//消息提醒

    Route::get('/contact',function(){//联系方式
        return view('contact');
    });


    Route::get('/guarante',function(){//售后保障
        return view('guarante');
    });
});

    Route::any('/notify_url','View\PayController@wx_notify_url');//微信回调
    Route::get('/refund','View\PayController@refund');





Route::group(['prefix' => 'service'], function () {
    Route::get('validate_code/create', 'Service\ValidateController@create');
    Route::post('upload/{type}', 'Service\UploadController@uploadFile');
});




/***********************************后台相关***********************************/

Route::group(['prefix' => 'admin'], function () {

    Route::get('login', 'Admin\IndexController@toLogin');//登录
    Route::get('exit', 'Admin\IndexController@toExit');//退出
    Route::post('service/login', 'Admin\IndexController@login');//执行登录

    Route::group(['middleware' => 'check.admin.login'], function () {
        Route::group(['prefix' => 'service'], function () {

            //普通商品分类操作
            Route::post('category/add', 'Admin\CategoryController@categoryAdd');
            Route::post('category/del', 'Admin\CategoryController@categoryDel');
            Route::post('category/edit', 'Admin\CategoryController@categoryEdit');

            //普通商品页面
            Route::post('product/add', 'Admin\ProductController@productAdd');
            Route::post('product/del', 'Admin\ProductController@productDel');
            Route::post('product/edit', 'Admin\ProductController@productEdit');

            //批发商品页面
            Route::post('goods/add', 'Admin\ProductController@goodsAdd');
            Route::post('goods/del', 'Admin\ProductController@goodsDel');
            Route::post('goods/edit', 'Admin\ProductController@goodsEdit');


            Route::post('member/edit', 'Admin\MemberController@memberEdit');
            Route::post('order/edit', 'Admin\OrderController@orderEdit');
        });

        Route::get('index', 'Admin\IndexController@toIndex');//后台首页
        Route::get('welcome', 'Admin\IndexController@welcome');//后台欢迎页

        //普通商品分类显示
        Route::get('category', 'Admin\CategoryController@toCategory');
        Route::get('category_add', 'Admin\CategoryController@toCategoryAdd');
        Route::get('category_edit', 'Admin\CategoryController@toCategoryEdit');

        //普通商品
        Route::get('product', 'Admin\ProductController@toProduct');
        Route::get('product_info', 'Admin\ProductController@toProductInfo');
        Route::get('product_add', 'Admin\ProductController@toProductAdd');
        Route::get('product_edit', 'Admin\ProductController@toProductEdit');

        //批发商品
        Route::get('goods', 'Admin\ProductController@toGoods');
        Route::get('goods_info', 'Admin\ProductController@toGoodsInfo');
        Route::get('goods_add', 'Admin\ProductController@toGoodsAdd');
        Route::get('goods_edit', 'Admin\ProductController@toGoodsEdit');

        //会员管理
        Route::get('member', 'Admin\MemberController@toMember');
        Route::get('member_edit', 'Admin\MemberController@toMemberEdit');
        Route::get('apply','Admin\MemberController@apply');
        Route::get('do_apply/{id}','Admin\MemberController@doApply');
        Route::post('to_do_apply','Admin\MemberController@toDoApply');

        Route::get('order', 'Admin\OrderController@toOrder');//订单列表
        Route::get('order_info/{order_no}','Admin\OrderController@toOrderInfo');//订单商品信息
        Route::get('order_express/{order_no}','Admin\OrderController@toOrderExpress');//订单发货信息
        Route::post('do_order_express','Admin\OrderController@doOrderExpress');//保存订单地址

        Route::get('order_edit', 'Admin\OrderController@toOrderEdit');//暂留
    });
});

//生成sql日志
Event::listen('illuminate.query', function($sql,$param) {
    file_put_contents(storage_path().'/logs/sql.log',$sql.'['.print_r($param, 1).']'."\r\n",8);
});