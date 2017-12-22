<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>收货地址</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


	<link rel="stylesheet" type="text/css" href="{{asset('/css/mm_css/base.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('/css/mm_css/public.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/mm_css/main_style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/layui/css/layui.css')}}">
    <link rel="stylesheet" href="{{asset('/css/master.css')}}"/>

    <script type="text/javascript" src="{{asset('/js/jquery-1.11.2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/mm_js/fontsize.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/mm_js/jquery.flexslider-min.js')}}"></script>
</head>
<body class="bg-gray-f6">

<form action="/confirm_address" method="post">
{{csrf_field()}}

@foreach($data as $v)
	<ul class="address f22 bg-white mt10 pt20 pb20">
		<li class="icon vertical_middle pl20">
			<i class="iconfont radio" data-id={{$v->id}}>
			@if($v->id == $add_id)
			√
			@endif
			</i>
		</li>
		<li class="vertical_middle">
			<div>收件人：<span class="mr100">{{$v->user_name}}</span>电话：<span>{{$v->mobile}}</span>
			</div>
			<div>收货地址：{{$v->s_province}}{{$v->s_city}}{{$v->s_county}}{{$v->address}}</div>
		</li>
		<li class="more txt-right vertical_middle pr20">
			<a class="iconfont" href="/edit_address/{{$v->id}}">
				<img class="hw17" src="{{asset('/img/edit.png')}}" alt="">
			</a>
		</li>
	</ul>	
@endforeach

<div class="add_address f26 p20 bg-white mt10">新增收货地址<a class="fr add iconfont mt9 f26" href="/add_address">+</a></div>
@if($order_no)
	<div class="f26 p20 bg-white mt10">
		<input type="submit" value="确认" class="btn_pay_input f30 white mt20">
	</div>
@endif
<input type="hidden" name="add_id" value="{{$add_id}}">
</form>
<script type="text/javascript">
	$(function(){
		$('.address .radio').bind('click',function(){
			$(this).html('√');
			var id = $(this).attr('data-id');
			$('input[name=add_id]').val(id);
			$(this).parent().parent().siblings('.address').find('.radio').html('');
		});
	});
</script>
</body>
</html>