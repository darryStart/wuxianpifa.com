$(function () {
    //轮播图
    $('.banner_prod').flexslider({
        animation : 'slide',
        controlNav : true,
        directionNav : false,
        animationLoop : true,
        slideshow : true,
        useCSS : false
    });

    //获取价格
    var goods_price = $("#goods_price").attr('data-price');

    //数量加
    $('.btn_plus').on('click', function() {
        numPlus($(this), '.num', '.btn_less');
        var num = $(this).parent().find('.num').eq(0).val();
        $('.total_price').text((goods_price * num).toFixed(2));
    });

    //数量减
    $('.btn_less').on('click', function() {
        numLess($(this), '.num');
        var num = $(this).parent().find('.num').eq(0).val();
        $('.total_price').text((goods_price * num).toFixed(2));
    });



    //选项卡
    fnTab('.tab_details');


    //时间进度
    timer(intDiff);


    //单独批发购物车
    $(".join_carts").on('click',function(){


        var goods_price = $("#goods_price").attr('data-price');

        //批发商判断
        if(goods_price == ''){
            layer.open({
                content: '只有申请为无限批发商城的批发商客户,才能进行此操作。'
                ,btn: ['申请批发商', '关闭']
                ,yes: function(index){
                    window.location='/apply';
                    layer.close(index);
                }
            });
            return;
        }



        //到时判断
        var _time = $('.time-item').data('time');
        if(_time<1){
            layer.open({
                content: '限时抢购已经结束！'
                ,skin: 'msg'
                ,time: 2
            });
            return; 
        }

        //数量判断
        var shop_num = $('input[name=shop_num]').val();
        if(shop_num < 1){
            layer.open({
                content: '购买量至少为1'
                ,skin: 'msg'
                ,time: 2
            });
            return;  
        }





        var type = $(this).attr('data-type');
        var goods_img = $("#shop_ul").attr('data-img');
        var goods_id = $("#shop_ul").attr('data-id');
        var goods_type = 1;
        var _token = $('input[name=_token]').val();
        var goods_summary = $('.normal').text();

        $.ajax({
            type:'post',
            url:'/carts_add',
            data:{
                    'goods_id':goods_id, 
                    'goods_num':shop_num ,
                    'goods_price' :goods_price, 
                    '_token':_token,
                    'shop_type': type,
                    'img_url' : goods_img,
                    'goods_summary' : goods_summary
                },
            success:function(data){
                layer.open({
                    content: data
                    ,skin: 'msg'
                    ,time: 2
                });
                return;
            },
            error:function(){
                return;
            }
        });
    });
});


//注意进度条依赖 element 模块，否则无法进行正常渲染和功能性操作
layui.use('element');


//倒计时总秒数量
var intDiff = parseInt($('.time-item').data('time'));
function timer(intDiff){
    window.setInterval(function(){
    var day=0,
        hour=0,
        minute=0,
        second=0;//时间默认值        
    if(intDiff > 0){
        day = Math.floor(intDiff / (60 * 60 * 24));
        hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
        minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
        second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
    }
    if (minute <= 9) minute = '0' + minute;
    if (second <= 9) second = '0' + second;
    $('#day_show').html(day+"天");
    $('#hour_show').html('<s id="h"></s>'+hour+'时');
    $('#minute_show').html('<s></s>'+minute+'分');
    $('#second_show').html('<s></s>'+second+'秒');
    intDiff--;
    }, 1000);
} 

function change(){
    var goods_price = $("#goods_price").attr('data-price');
    var num = $('.num').val();
    var total_price = Number(num)?goods_price * num:0;
    $('.total_price').text(total_price.toFixed(2));
}