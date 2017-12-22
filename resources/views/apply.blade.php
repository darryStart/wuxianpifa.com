<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>申请成为批发商</title>
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-touch-fullscreen" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<meta name="format-detection" content="address=no">
		<link rel="stylesheet" type="text/css" href="{{asset('/css/m_css/common.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('/css/m_css/index.css')}}">
		<link rel="stylesheet" href="{{asset('/css/m_css/reset.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('/layui/css/layui.css')}}">
		<link rel="stylesheet" href="{{asset('/css/master.css')}}"/>
</head>
<body>
	<div>
		{{csrf_field()}}		
		<div id="main">
		    <div class="warp warpthree clearfloat">
		    	<div class="apply clearfloat">
		    		<div class="bottom clearfloat">
		    			<ul>
		    				<li>
		    					<div class="box-s clearfloat">
		    						<p>批发商名称：</p>
		    						<input type="text" placeholder="公司名、店铺名、淘宝名等" name="wholesaler_name" value="{{$data->wholesaler_name or ''}}" />
		    					</div>	    					
		    				</li>
		    				<li>
		    					<div class="box-s clearfloat">
		    						<p>申请人称呼：</p>
		    						<input type="text" name="apply_name" placeholder="称呼" value="{{$data->apply_name or ''}}" />
		    					</div>	    					
		    				</li>
		    				<li>
		    					<div class="box-s clearfloat">
		    						<p>申请人电话：</p>
		    						<input type="text" name="wholesaler_tel" placeholder="联系电话" value="{{$data->wholesaler_tel or ''}}" />
		    					</div>	    					
		    				</li>
		    				<li>
		    					<div class="box-s clearfloat">
		    						<p>详情信息：</p>
		    						<textarea name="wholesaler_info" cols="10" placeholder="可以填写公司、店铺、淘宝等相关经营情况。" rows="10">{{$data->wholesaler_info or ''}}</textarea>
		    					</div>	    					
		    				</li>
		    			</ul>
		    		</div>
		    		<input type="hidden" value="{{$data->user_id or ''}}" name="id">
		    		<div style="font-size: 16px;">
		    			@if(isset($data->status))
				    		@if($data->status == '0')
				    			<div style="text-align: center; margin-bottom: 20px;">
				    				<span style="color: #fd7400">等待审核中...</span>
				    			</div>
				    		@elseif($data->status == '1')
				    			<div style="text-align: center; margin-bottom: 20px;">
				    				<span style="color: #2fbdaa">恭喜您，您已是批发商！</span>
				    			</div>
				    		@elseif($data->status == '2')
				    			<div style="text-align: left;padding: 10px;color: red;">
				    				审核未通过:&nbsp;&nbsp;<span>{{$data->result}}</span>
				    			</div>
					    		<a class="center-btn db ra3 submit">重新提交</a>
				    		@endif
				    	@else
				    		<a class="center-btn db ra3 submit">提交</a>
			    		@endif
		    		</div>
		    	</div>
		    	<div class="recharge clearfloat">
		    		<div class="guize clearfloat box-s ra3">
		    			<h3>申请规则</h3>
		    			<div class="content clearfloat">
	    				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.在收到申请后，我们将在一个工作日内完成审批，期间请保持联系方式畅通。
	    				    <br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.请在详细信息内填入实体商铺、淘宝商铺、公司等相关的经营信息。
							<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.申请成为无限批发商城后，可以在无限批发商城中批发优质数码3C配件产品，并获得最优质的售后保障。
							<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.无限批发商城提供市面最优质的3C数码配件产品。  
		    			</div>
		    		</div>
	    		</div>  	
		    </div>
		</div>
	</div>
</body>
</html>
<script type="text/javascript" src="{{asset('/js/jquery-1.11.2.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/layer_mobile/layer.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/center.js')}}"></script>