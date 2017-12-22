<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-touch-fullscreen" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<meta name="format-detection" content="address=no">
		<title>{{$title or '首页'}}</title>
		<meta name="keywords" content="" />
		<meta name="description" content="" />

		<link rel="stylesheet" type="text/css" href="{{asset('/css/m_css/common.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('/css/m_css/index.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('/css/m_css/mui.min.css')}}"/>
		<link rel="stylesheet" href="{{asset('/css/m_css/reset.css')}}">
        <link rel="stylesheet" href="{{asset('/layui/css/layui.css')}}"  media="all">
        <link rel="stylesheet" href="{{asset('/css/master.css')}}"/>



		<script type="text/javascript" src="{{asset('/js/m_js/jquery.min.js')}}"></script>
		<script type="text/javascript" src="{{asset('/js/m_js/iscroll.js')}}"></script>
		<script type="text/javascript" src="{{asset('/js/m_js/jquery.flexslider-min.js')}}"></script>
		<script src="{{asset('/js/m_js/hmt.js')}}" type="text/javascript"></script>
		<script type="text/javascript" src="{{asset('/js/m_js/index.js')}}"></script>
		<script src="{{asset('/js/m_js/swiper.min.js')}}" type="text/javascript" ></script>
	</head>

	<body>

		<div id="container">		
			<div id="main">
				@if(isset($cates))
					<div id="scroller">
							<section class="slider">
								<div class="swiper-container swiper-container2">
									<div class="swiper-wrapper tuangouwidth">
										@foreach($cates as $v)
											<div class="swiper-slide">
												<ul class="icon-list">
													@foreach($v as $vv)
														<li class="icon">
															<a href="/cate/{{$vv->id}}">
																<span class="icon-circle">
																	<img src="{{asset($vv->img_url)}}">
																</span>
																<span class="icon-desc">{{$vv->name}}</span>
															</a>
														</li>
													@endforeach
												</ul>
											</div>
										@endforeach
									</div>
									<div class="swiper-pagination swiper-pagination2">
									</div>
								</div>
							</section>
					</div>
				@endif
				<div id="container"  >        
		            <div id="main">
		                <div class=" rush-box">
		                    <div id="index">
		                        <div class="limit_buy">
		                            <ul class="list_box" id="content_rl">
		                            </ul>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
							
				<div id="index" class="page-center-box">
				</div>
			</div>
		</div>
		<input type="hidden" name="cate" value="{{$cate}}"/>
		{{csrf_field()}}
		@include('footer')
	</body>
</html>

<script src="{{asset('/layui/layui.js')}}" type="text/javascript"></script>
<script>
    layui.use('flow', function(){
        var flow = layui.flow;
        layui.use('flow', function(){
            var $ = layui.jquery; 
            var flow = layui.flow;
            var cate = $('input[name=cate]').val();
            var _token = $('input[name=_token]').val();
            flow.load({
                elem: '#content_rl' 
                ,done: function(page, next){
                    var lis = [];
                    $.post('/ajax_goods_list',{'page':page, 'cate':cate, '_token':_token}, function(res){
                        //假设你的列表返回在data集合中
                            layui.each(res.data, function(index, item){
                                var str = '';
                                str += '<li>';
                                str +=     '<a href="/details/' + item.id + '">';
                                str +=         '<div class="">';
                                str +=             '<div class="img"><img src="' + item.preview + '"></div>';
                                str +=             '<p class="bt overflow_clear">' + item.name + '</p>';
                                str +=             '<p>';
                                str +=                  item.summary;
                                str +=             '</p>';
                                str +=             '<p><span class="price">';
                                if(item.price){ 
                                    str += '￥'; 
                                }  
                                str += '<b>' + item.price + '</b></span><span class="sell_num">已售: ' + item.sales_num + ' 件</span></p>';
                                str +=         '</div>';
                                str +=     '</a>';
                                str += '</li>';
                                lis.push(str);
                            }); 
                        next(lis.join(''), page < res.pages);    
                    });
                }
            });
        });
    });
</script>