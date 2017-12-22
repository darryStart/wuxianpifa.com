<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>批发车</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/mm_css/public.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/mm_css/main_style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/layui/css/layui.css')}}">
    <link rel="stylesheet" href="{{asset('/css/master.css')}}"/>

    <script type="text/javascript" src="{{asset('/js/jquery-1.11.2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/mm_js/fontsize.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/mm_js/jquery.flexslider-min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/mm_js/publics.js')}}"></script>
    <script type="text/javascript" src="{{asset('/layer_mobile/layer.js')}}"></script>

</head>

<body class="pb100">
<!-- 批发车 -->
<div class="carts">
	{{ csrf_field() }}
	@foreach($data as $v)
		<ul class="carts-ul bg-white mb10 pt20 pb20">
			<li class="carts_check">
				<i class="iconfont check checked" id="{{$v->id}}" goods-num="{{$v->goods_num}}">&#xe610;</i>
			</li>
			<li class="carts_img full_img">
				<a><img src="{{$v->img_url}}"></a>
			</li>
			<li class="carts_info pl20 pr20">
				<h5 class="normal f22"><a class="txt-nowrap">{{$v->goods_summary}}</a></h5>
				<p class="f22 gray_90">
					@if($v->shop_type == '1')
						单独批发
					@elseif($v->shop_type == '2')
						合伙批发
					@else
						普通购买
					@endif
				</p>
				<div class="red f22">￥<span class="price">{{$v->goods_price}}</span></div>
				<div class="num_box f22">

					<a href="javascript:;" class="btn_less mr-5">━</a>
					<span class="num">{{$v->goods_num}}</span>
					<a href="javascript:;" class="btn_plus ml-5" >╋</a>
					<img class="fr btn-del" data-id="{{$v->id}}" src="{{asset('/img/delete.png')}}" alt="">
				</div>
			</li>
		</ul>
	@endforeach
</div>

<input type="hidden" id="totalcartnumb" name="data" value="" />
<!-- 页脚导航 -->
<div class="foot bg-white select_all">
	<div class="p10 ml10 mr10 clearfix f26">
		<div class="fl"><i class="iconfont check checked vertical_middle">&#xe610;</i><span class="vertical_middle ml10">全选</span></div>
		<div class="txt-right fr">总计：<span class="red mr40">￥<i class="total"></i></span><a class="white btn_billing confirm_order" id="add_order">去结算(<i class="sum_num"></i>)</a></div>
	</div>
</div>

<script type="text/javascript" src="{{asset('/js/mm_js/carts.js')}}"></script>
</body>
</html>