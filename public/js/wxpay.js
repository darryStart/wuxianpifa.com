	//改变金额
    confirmTotalNum();
	function confirmTotalNum(){
		var str='';
		$('.commodity').each(function(){
			if(str==''){
				str=$(this).attr('id');
			}else{
				str=str+','+$(this).attr('id');
			}
		});
		$('#totalcartnumb').val(str);
	}

    //微信调起
    $('#pay').on('click', function(){

        //地址判断
        var addr_status = $('input[name=addr_status]').val();
        if(addr_status != '1'){
            layer.open({
                content: '请填写选择地址'
                ,skin: 'msg'
                ,time: 2
            });
            return false;
        }

        //金额验证
        var total = parseFloat($('input[name=total]').val());
        if(total == '0' || total == ''){
            layer.open({
                content: '不正确金额,无效订单'
                ,skin: 'msg'
                ,time: 2
            });
            return false;
        }


        var id = $(this).data('id');
        var _token = $('input[name=_token]').val();

        //请求参数
        $.ajax({
            url:'/pay',
            type:'post',
            data:{'id':id, 'total':total,'_token':_token},
            success:function(data){
                var obj = $.parseJSON(data);
                if(obj.code == '200'){//请求成功
                    var config = obj.data;
                    GetUrlParms();
                    var onBridgeReady =function (config) {
                        var params = {
                            "appId":config.appId,
                            "timeStamp":config.timestamp,
                            "nonceStr":config.nonceStr,
                            "package":config.package,
                            "signType":config.signType,
                            "paySign":config.paySign
                        };
                        WeixinJSBridge.invoke(
                            'getBrandWCPayRequest',params,
                            function(res){
                                switch(res.err_msg) {
                                    case 'get_brand_wcpay_request:cancel':
                                        layer.open({
                                            content: '用户取消支付！'
                                            ,skin: 'msg'
                                            ,time: 2
                                        });
                                        break;
                                    case 'get_brand_wcpay_request:fail':
                                        alert(res.err_desc);
                                        layer.open({
                                            content: '支付失败l！'
                                            ,skin: 'msg'
                                            ,time: 2
                                        });
                                        break;
                                    case 'get_brand_wcpay_request:ok':
                                        layer.open({
                                            content: '支付成功！',
                                            btn: '继续购物',
                                            shadeClose: false,
                                            style: 'background-color:#09C1FF; color:#fff; border:none;', //自定风格
                                            yes: function(){
                                                location.href = '/';
                                            }
                                        });
                                        break;
                                    default:
                                        alert(JSON.stringify(res));
                                        break;
                                }

                                
                            }
                        )
                    }

                    if (typeof WeixinJSBridge == "undefined"){
                        if( document.addEventListener ){
                            document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
                        }else if (document.attachEvent){
                            document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                            document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
                        }
                    }else{
                        onBridgeReady(config);
                    }

                    showLoading();

                }else{//请求失败
                    layer.open({
                        content: '请求失败'
                        ,skin: 'msg'
                        ,time: 2
                    });
                    return false;
                }


            },
            error:function(){
                layer.open({
                    content: '请求出错啦！'
                    ,skin: 'msg'
                    ,time: 2
                });
                return false;
            }
        });

    });




    /**
     *显示加载页面
     *msgContent 加载页面显示的内容，如果不传，默认为"加载中..."
     */
    function showLoading(msgContent) {
        //传入的信息为空
        var loading_simple_div = gel("#loading_simple_div");
        loading_simple_div.style.display = "block";
        gel("#overlayImage").style.display = "block";
        gel("#loading_text").innerHTML = msgContent ? msgContent : "正在努力加载中..";
        //让加载中剧中对齐
        loading_simple_div.style.left = (loading_simple_div.parentNode.offsetWidth - loading_simple_div.offsetWidth) / 2 + "px";
    }

    /**
     *隐藏加载页面
     */
    function hideLoading() {
        gel("#overlayImage").style.display = "none";
        gel("#loading_simple_div").style.display = "none";
    }

    function gel(selector) {
        return document.querySelector(selector);
    }
    var _args;
    function GetUrlParms() {
        var args = new Object();
        var query = (location.search.substring(1)); //获取查询串
        var pairs = query.split("&"); //在&号处断开
        for (var i = 0; i < pairs.length; i++) {
            var pos = pairs[i].indexOf('='); //查找name=value
            if (pos == -1) continue; //如果没有找到就跳过
            var argname = pairs[i].substring(0, pos); //提取name
            var value = pairs[i].substring(pos + 1); //提取value
            args[argname] = decodeURI(value); //存为属性
        }

        _args=args;
    }
