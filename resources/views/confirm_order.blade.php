<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>支付订单</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="{{asset('/css/mm_css/public.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/mm_css/main_style.css')}}">
	<link rel="stylesheet" href="{{asset('/layui/css/layui.css')}}">
	<link rel="stylesheet" href="{{asset('/css/master.css')}}"/>


</head>

<body class="bg-gray-f0">
	<!-- 顶部 -->
	@if($area)
	<ul class="address bg-white mb10">
		<li class="icon vertical_middle pl20 pr20"><i class="iconfont f48">&#xe602;</i></li>
		<li class="vertical_middle f20">
			<div>收件人：<span class="mr100">{{$area->user_name}}</span>电话：{{$area->mobile}}<span></span>
			</div>
			<div>收货地址：{{$area->s_province}} {{$area->s_city}} {{$area->s_county}} {{$area->address}}</div>
		</li>
		<li class="more txt-right vertical_middle pr20"><a class="iconfont f26" href="/address/{{$order_no}}">&#xe60f;</a></li>
	</ul>
	@else
	<a href="/address/{{$order_no}}">
		
	<ul class="address bg-white mb10">
		<li class="icon vertical_middle pl20 pr20"><i class="iconfont f48">&#xe602;</i></li>
		<li class="vertical_middle f21 ml20">
			请添加收货地址
		</li>
		<li class="more txt-right vertical_middle pr20"><font class="iconfont f26">&#xe60f;</font></li>
	</ul>
	</a>


	@endif

	@foreach($data as $v)
		<dl class="commodity bg-white mb10 pt20 pb20" >
			<dt class="full_img pl20 pr20"><a href="#"><img src="{{$v->img_url}}"></a></dt>
			<dd class="vertical_middle pr20">
				<h4 class="normal f21"><a href="#" class="txt-nowrap">{{$v->goods_summary}}</a></h4>
				<p class="f20 gray_90 mt5">类型：
					<span>
						@if($v->shop_type == '1')
							单独批发
						@elseif($v->shop_type == '2')
							合伙批发
						@else
							普通购买
						@endif
					</span>
				</p>
				<div class="f30 mt10"><span class="red">￥<span class="price">{{$v->goods_price}}</span></span><span class="fr">x{{$v->goods_num}}</span></div>
			</dd>
		</dl>
	@endforeach

	<div class="txt-center f30 bg-white pt10 pb10 total_price">总价：<span class="red">￥{{$total}}</span></div>
	<a class="btn_pay m20 f30 white txt-center dis_block pt5 pb5" id="pay" data-id={{$order_no}} >微信支付</a>
	<input type="hidden" id="totalcartnumb"/>
	<input type="hidden" name="total" value="{{$total}}">
	{{csrf_field()}}
	<input type="hidden" name="addr_status"  @if($area) value="1" @else value="0" @endif>
</body>
</html>
<script type="text/javascript" src="{{asset('/js/jquery-1.11.2.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/mm_js/fontsize.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/mm_js/jquery.flexslider-min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/mm_js/publics.js')}}"></script>
<script type="text/javascript" src="{{asset('/layer_mobile/layer.js')}}"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>  
<script type="text/javascript" src="{{asset('/js/wxpay.js')}}"></script>
