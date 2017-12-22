<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>个人中心</title>
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-touch-fullscreen" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<meta name="format-detection" content="address=no">
		<link rel="stylesheet" type="text/css" href="{{asset('/css/m_css/common.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('/css/m_css/index.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('/css/m_css/mui.min.css')}}"/>
		<link rel="stylesheet" href="{{asset('/css/m_css/reset.css')}}">
		<link rel="stylesheet" href="{{asset('/css/master.css')}}"/>
		
		<script type="text/javascript" src="{{asset('/js/m_js/jquery.min.js')}}"></script>
		<script src="{{asset('/js/m_js/hmt.js')}}" type="text/javascript"></script>
	</head>
<!--/************************************************************
 *																*
 * 						      代码库							*
 *                        www.dmaku.com							*
 *       		  努力创建完善、持续更新插件以及模板			*
 * 																*
**************************************************************-->
	<body>
	    <div id="container">		
			<div id="main">
			    <div class="warp clearfloat">
			    	<div class="h-top clearfloat box-s">
			    		<div class="tu clearfloat fl">
			    			<img  src="{{asset($user['header_img'])}}">
			    		</div>
			    		<div class="content clearfloat fl">
			    			<p class="hname">{{$user['nickname'] or ''}}</p>
			    			<p class="htel" style="font-size: 17px;">
			    				@if($user['active'] == '1')
			    					批发商
			    				@else
			    					游客
			    				@endif
			    			</p>
			    		</div>
			    	</div>

			    	<div class="cashlist clearfloat mt10">
			    		<ul>
			    			<li class="box-s">
			    				<a href="/order_list">
			    					<p class="fl">我的订单</p>
		    						<font class="fr iconfont white"> &#xe60f;</font>
			    				</a>
			    			</li>
			    			<li class="box-s">
			    				<a href="/address/0">
			    					<p class="fl">我的地址</p>
			    					<font class="fr iconfont white"> &#xe60f;</font>
			    				</a>
			    			</li>
			    			<li class="box-s">
			    				<a href="/apply">
			    					<p class="fl">申请批发商</p>
			    					<font class="fr iconfont white"> &#xe60f;</font>
			    				</a>
			    			</li>
			    			<li class="box-s">
			    				<a href="/contact">
			    					<p class="fl">联系方式</p>
			    					<font class="fr iconfont white"> &#xe60f;</font>
			    				</a>
			    			</li>
			    			<li class="box-s">
			    				<a href="/guarante">
			    					<p class="fl">售后保障</p>
			    					<font class="fr iconfont white"> &#xe60f;</font>
			    				</a>
			    			</li>
			    		</ul>
			    	</div>			    	
			    </div>
			</div>
		</div>
		@include('footer');
	</body>
</html>