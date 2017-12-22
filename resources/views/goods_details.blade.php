<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>商品详情</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="target-densitydpi=device-dpi, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="stylesheet" href="{{asset('/layui/css/layui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/mm_css/public.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/mm_css/main_style.css')}}">
    <link rel="stylesheet" href="{{asset('/css/master.css')}}"/>

    <script type="text/javascript" src="{{asset('/js/jquery-1.11.2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/mm_js/fontsize.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/mm_js/jquery.flexslider-min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/mm_js/public.js')}}"></script>
    <script type="text/javascript" src="{{asset('/layui/layui.js')}}"></script>
    <script type="text/javascript" src="{{asset('/layer_mobile/layer.js')}}"></script>
</head>
<body class="pb100">
<!-- 轮播图 -->
<div class="flexslider pos_rel banner_prod">
    <ul class="slides pos_rel">
        @foreach($gds_images as $v)
            <li>
                <div class="slide"> <img src="{{asset($v->image_path)}}" alt="" /></div>
            </li>
        @endforeach
    </ul>
</div>

<div class="p10 pro_info_box">
    {!! csrf_field() !!}
    <h4 class="normal f28 pt10 mb10">{{$goods->summary}}</h4>

    <div class="price mb10">
        <span class="new f30 red mr10" id="goods_price" data-price="{{$goods->wholesale_price}}">
            @if($goods->wholesale_price == '')
                <button class="layui-btn layui-btn-normal" style="width: 90%;margin-left: 5%;" onclick="window.location='/apply'">申请批发商</button>
            @else
                ￥{{$goods->wholesale_price}}
            @endif
        </span>
    </div>

    <div class="layui-progress mt50" lay-showPercent="yes">
        <div class="layui-progress-bar layui-bg-red" lay-percent="{{isset($progress) ? $progress : '0' }}%"></div>
    </div>
    <div style="float:left;">0</div>
    <div style="float:right">{{$goods->wholesale_total}}(下单量)</div>

    <div class="f20 mt55">
        <div class="time-item" data-time="{{$time}}">
            剩余发货时间:
            <strong id="day_show">0天</strong>
            <strong id="hour_show">0时</strong>
            <strong id="minute_show">0分</strong>
            <strong id="second_show">0秒</strong>
        </div>
    </div>
  
</div>


<div class="tab_details">
<!-- 商品详情 -->
    <div class="tab_details_bd mt10" style="display: block;">
        <div class="full_img pro_details pt20">
            {!! $goods->content !!}
        </div>
    </div>
</div>
<!-- 页脚导航 -->


<div class="foot bg-white p0">
    <ul class="bot_shop_btn txt-center clearfix" id="shop_ul" data-id="{{$goods->id}}" data-img="{{$goods->preview}}">
        <li class="pro_number">  
            <a href="javascript:;" class="btn_less failed btn-pro">━</a>
            <input type="text" class="num" name="shop_num" oninput="change()" value="0">
            <a href="javascript:;" class="btn_plus btn-pro" data-type="setPercent">╋</a>
        </li>
        <li>
            <span class="red f24">￥<i class="total_price">0</i></span>
        </li>
        <li  style="float:right;margin-right: 2px;">
            <a data-type='2' class="btn white buy f26 join_carts" >加入购物车</a>
        </li>
        <li style="float:right;margin-right:10%;">
            <a  href="tel:{{env('TEL')}}">
                <img  class="btn white f26" style="height: 30px; width: 30px;"  src="{{asset('/img/tel.png')}}" alt="">
            </a>
        </li>
    </ul>
</div>

</body>
</html>
<script type="text/javascript" src="{{asset('/js/goods_details.js')}}"></script>