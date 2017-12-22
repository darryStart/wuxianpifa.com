<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>限时批发</title>
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="format-detection" content="telephone=no">
        <meta name="format-detection" content="address=no">
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" >  
        

        <link rel="stylesheet" type="text/css" href="{{asset('/css/m_css/common.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('/css/m_css/index.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('/css/m_css/mui.min.css')}}"/>
        <link rel="stylesheet" href="{{asset('/css/m_css/reset.css')}}">
        <link rel="stylesheet" href="{{asset('/layui/css/layui.css')}}"  media="all">
        <link rel="stylesheet" href="{{asset('/css/master.css')}}"/>


        <script src="{{asset('/js/m_js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
        <script src="{{asset('/js/m_js/hmt.js')}}" type="text/javascript"></script>
        
    </head>
    <body style="background-color: #ecf0f3;">
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
        @include('footer')
    </body>
</html>
<script src="{{asset('/layui/layui.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/goods_join.js')}}" type="text/javascript"></script>