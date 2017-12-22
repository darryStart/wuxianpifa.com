<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>我的订单</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="{{asset('/css/mm_css/public.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('/css/mm_css/main_style.css')}}">
        <link rel="stylesheet" href="{{asset('/css/master.css')}}"/>

        <script type="text/javascript" src="{{asset('/js/m_js/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/mm_js/fontsize.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/mm_js/public.js')}}"></script>
    </head>
    <body class="pb100 bg-gray-f6">
        <!-- 订单 -->
        <div class="tab_order">
            <ul class="tab_order_hd clearfix txt-center f22">
                <li class="cur"><span>全部订单</span></li>
                <li><span>待付款</span></li>
                <li><span>已付款</span></li>
                <li><span>已发货</span></li>
            </ul>
            <!-- 全部订单 -->
            <div class="tab_order_bd mt10 dis_none" style="display: block;">
                @foreach($data as $value)
                    <div class="commod_box bg-white mb10">
                        @foreach($value->carts as $v)
                        <dl class="commodity pt20 pb20 border_bot_e1">
                        <dt class="full_img pl20 pr20"><a><img src="{{asset($v->img_url)}}"></a></dt>
                            <dd class="vertical_middle pr20">
                                <h4 class="normal f20 title">
                                    <a>{{$v->goods_summary}}</a>
                                </h4>
                                <p class="f18 gray_90 mt5">类型：
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
                                <div class="f22">
                                    <span class="red">￥<span class="price">{{$v->goods_price}}</span></span>
                                    <span class="fr">x{{$v->goods_num}}</span>
                                </div>
                            </dd>
                        </dl>
                        @endforeach

                        <div class="txt-right f20 pr20 pt15">
                            合计：<span class="red">￥{{$value->total_price}}</span>
                        </div>
                        <div class="txt-right pr20 border_bot_e1 f20 mt10 pb20">
                            @if($value->status == '1')
                                <a href="javascript:;" data-id="{{$value->id}}"  class="btn_ope btn_del ml10">删除订单</a>
                                <a href="/confirm_order/{{$value->order_no}}" class="btn_ope btn_red ml10">去支付</a>
                            @elseif($value->status == '3')
                                <a class=" ml10">{{$value->express_name}}:</a>
                                <a class=" ml5">{{$value->express_no}}</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- 待付款 -->
            <div class="tab_order_bd mt10 dis_none">
                @foreach($data as $value)
                    @if($value->status == '1')
                    <div class="commod_box bg-white mb10">
                        @foreach($value->carts as $v)
                            <dl class="commodity pt20 pb20 border_bot_e1">
                                <dt class="full_img pl20 pr20"><a><img src="{{asset($v->img_url)}}"></a></dt>
                                <dd class="vertical_middle pr20">
                                    <h4 class="normal f20 title"><a>{{$v->goods_summary}}</a></h4>
                                    <p class="f18 gray_90 mt5">类型：
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
                                    <div class="f22"><span class="red">￥<span class="price">{{$v->goods_price}}</span></span><span class="fr">x{{$v->goods_num}}</span></div>
                                </dd>
                            </dl>
                        @endforeach
                        <div class="txt-right f20 pr20 pt15">合计：
                            <span class="red">￥{{$value->total_price}}</span>
                        </div>
                        <div class="txt-right pr20 border_bot_e1 f20 mt10 pb20">
                            <a href="javascript:;" data-id="{{$value->id}}" class="btn_ope btn_del ml10">删除订单</a>
                            <a href="/confirm_order/{{$value->order_no}}" class="btn_ope btn_red ml10">去支付</a>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>

            <!-- 已付款 -->
            <div class="tab_order_bd mt10 dis_none">
                @foreach($data as $value)
                    @if($value->status == '2')
                    <div class="commod_box bg-white mb10">
                        @foreach($value->carts as $v)
                            <dl class="commodity pt20 pb20 border_bot_e1">
                                <dt class="full_img pl20 pr20"><a><img src="{{asset($v->img_url)}}"></a></dt>
                                <dd class="vertical_middle pr20">
                                    <h4 class="normal f20 title"><a>{{$v->goods_summary}}</a></h4>
                                    <p class="f18 gray_90 mt5">类型：
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
                                    <div class="f22"><span class="red">￥<span class="price">{{$v->goods_price}}</span></span><span class="fr">x{{$v->goods_num}}</span></div>
                                </dd>
                            </dl>
                        @endforeach
                        <div class="txt-right f20 pr20 pt15 pb20">合计：
                            <span class="red">￥{{$value->total_price}}</span>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>

            <!-- 已发货 -->
            <div class="tab_order_bd mt10 dis_none">
                @foreach($data as $value)
                    @if($value->status == '3')
                    <div class="commod_box bg-white mb10">
                        @foreach($value->carts as $v)
                            <dl class="commodity pt20 pb20 border_bot_e1">
                                <dt class="full_img pl20 pr20"><a><img src="{{asset($v->img_url)}}"></a></dt>
                                <dd class="vertical_middle pr20">
                                    <h4 class="normal f20 title"><a>{{$v->goods_summary}}</a></h4>
                                    <p class="f18 gray_90 mt5">类型：
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
                                    <div class="f22"><span class="red">￥<span class="price">{{$v->goods_price}}</span></span><span class="fr">x{{$v->goods_num}}</span></div>
                                </dd>
                            </dl>
                        @endforeach
                        <div class="txt-right f20 pr20 pt15">合计：<span class="red">￥{{$value->total_price}}</span></div>
                        <div class="txt-right pr20 border_bot_e1 f20 mt10 pb20">
                            <a class=" ml10">{{$value->express_name}}:</a>
                            <a class=" ml5">{{$value->express_no}}</a>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
    </body>
</html>
<script type="text/javascript">
  fnTab('.tab_order');  //选项卡
  delOrder('.btn_del','.commod_box'); //删除订单
</script>