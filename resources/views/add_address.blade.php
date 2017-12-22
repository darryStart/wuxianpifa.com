<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>新增地址</title>
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
<body>
<!-- 顶部 -->
<form name="add_address" action="/to_add_address" method="post" target="_self" onSubmit="return docheck()" class="p20 f22 add_address">
  {{csrf_field()}}
	<div class="pb10">
		<span class="tit vertical_middle">&nbsp;收&nbsp;货&nbsp;人:</span>
		<input type="text" name="user_name" value="" class="text" placeholder="收货人姓名">
	</div>
	<div class="line_gray pt20 pb10">
		<span class="tit vertical_middle">联系方式:</span>
		<input type="text" name="mobile" value="" class="text" placeholder='手机号'>
	</div>
	<div class="line_gray pt20 pb10">
		<span class="tit vertical_middle">省/市/区:</span>
		<select id="s_province" name="s_province" class="select"></select>
		<select id="s_city" name="s_city" class="select"></select>
		<select id="s_county" name="s_county" class="select"></select>
	</div>
	<div class="line_gray pt20 pb10">
		<span class="tit vertical_middle">详细地址:</span>
		<input type="text" name="address" value="" class="text" placeholder="详细地址、门牌号">
	</div>
	<div class="f20 pb25 line_gray pt20"><input type="checkbox" style="color: red;" name="status" value="1">设为默认地址</div>
	<a class="mt20 f30 white txt-center dis_block pt5 pb5 btn_pay_input" >提&nbsp;&nbsp;交</a>
</form>
<script type="text/javascript" src="{{asset('/js/mm_js/area.js')}}"></script>
<script type="text/javascript">
	_init_area(["-- 选择 --","-- 选择 --","-- 选择 --"]);//三级联动地址

</script>
</body>
</html>