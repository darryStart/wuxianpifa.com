layui.use('element', function(){
    var $ = layui.jquery
    ,element = layui.element;

    //输入框    
    $('.num').change(function(){
        chg(element)
    }); 
      
    //点击加减 
    $('.btn-pro').on('click', function(){
        chg(element)
    });
});

function chg(element,type){
    var type = $('#goods_price').data('price');
    if(type != ''){
            var num = $('.num').val();

            var max_num = parseInt($('.max_num').text().split('下单量')[0]);
            var med_num = parseInt($('.med_num').text());
            var min_num = parseInt($('.min_num').text());

            var max_price = $('.max_num').data('price');
            var med_price = $('.med_num').data('price');
            var min_price = $('.min_num').data('price');

            //价格变动
            var _goods_price = $("#goods_price");
            if(num >= min_num && num < med_num){
                _goods_price.text('￥'+ min_price);
                _goods_price.attr('data-price',min_price);
                $('.total_price').text((min_price * num).toFixed(2));
            }
            if(num >= med_num && num < max_num){
                _goods_price.text('￥'+ med_price);
                _goods_price.attr('data-price',med_price);
                $('.total_price').text((med_price * num).toFixed(2));
            }
            if(num >= max_num){
                _goods_price.text('￥'+ max_price);
                _goods_price.attr('data-price',max_price);
                $('.total_price').text((max_price * num).toFixed(2));
            }

            //进度条显示
            var shop_num = $('.num').val();
            var  progs = Math.round(shop_num/max_num*100);
            progs = (progs >= 100)?100:progs;
            element.progress('progress', progs+'%')
        }
}

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

    //数量加
    $('.btn_plus').bind('click', function() {
        $('.point').css('margin-left','40%');

        numPlus($(this), '.num', '.btn_less');
    });

    //数量减
    $('.btn_less').bind('click', function() {
        numLess($(this), '.num');
    });


    //单独批发购物车
    $(".join_carts").bind('click',function(){

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
