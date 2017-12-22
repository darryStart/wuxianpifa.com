/****************************************************************
 *																*		
 * 						      代码库							*
 *                        www.dmaku.com							*
 *       		  努力创建完善、持续更新插件以及模板			*
 * 																*
****************************************************************/
/*
sumObj====".select_all" 总计
subObj====".carts"      购物车
obj   ====".check"      复选框
*/
function fnSelect(sumObj,subObj,obj){
	sum(sumObj,subObj,obj ,'.count');//计算金额
	$(sumObj+' '+obj).click(function(){
		if ($(this).hasClass('checked')) { //全不选
			$(this).removeClass('checked').html('');
			$(subObj).find(obj).removeClass('checked').html('');
		}else{ //全选
			$(this).addClass('checked').html('&#xe610;');
			$(subObj).find(obj).addClass('checked').html('&#xe610;');
		}
		sum(sumObj,subObj,obj ,'.count');//计算金额
	});

	$(subObj).each(function(){
		var _this=$(this);

		//商品
		_this.find(obj).on('click',function(){
			var $this=$(this);
			$this.toggleClass('checked');

			if($this.hasClass('checked')){
				$this.addClass('checked').html('&#xe610;');

				var s=true;
				$this.parentsUntil(subObj).parent().find(obj).each(function() {
					if (!$(this).hasClass('checked')) {
						s=false;
						return false;
					}
				});
				if(s){
					$(sumObj+' '+obj).addClass('checked').html('&#xe610;');
				}
			}else{
				$this.removeClass('checked').html('');
				$(sumObj+' '+obj).removeClass('checked').html(''); //取消整体全选
			}

			sum(sumObj,subObj,obj ,'.count');//计算金额
		});

	});

}


//计算金额
function sum(sumObj,subObj,obj, countObj){
	var sum=0;//总金额
	var n=0; //总数

	$(subObj).find(obj).each(function(){
		if($(this).hasClass('checked')){
			var price=parseFloat($(this).parent().parent().find(".price").eq(0).text());
			var num=parseInt($(this).parent().parent().find(".num").eq(0).text());
			sum+=price*num;
			n++;
		}
	});

	$(sumObj).find(".total").text(sum.toFixed(2));
	$(sumObj).find('.sum_num').text(n);
	$(countObj).find('.sum_num').text(n);
	$(countObj).find('.total').text(sum.toFixed(2));
}


function fnSelect_collect(sumObj,subObj,obj){
	$(sumObj+' '+obj).click(function(){
		if ($(this).hasClass('checked')) { //全不选
			$(this).removeClass('checked').html('');
			$(subObj).find(obj).removeClass('checked').html('');
		}else{ //全选
			$(this).addClass('checked').html('&#xe610;');
			$(subObj).find(obj).addClass('checked').html('&#xe610;');
		}
	});

	$(subObj).each(function(){
		var _this=$(this);

		//商品
		_this.find(obj).on('click',function(){
			var $this=$(this);
			$this.toggleClass('checked');

			if($this.hasClass('checked')){
				$this.addClass('checked').html('&#xe610;');

				var s=true;
				$this.parentsUntil(subObj).parent().find(obj).each(function() {
					if (!$(this).hasClass('checked')) {
						s=false;
						return false;
					}
				});
				if(s){
					$(sumObj+' '+obj).addClass('checked').html('&#xe610;');
				}
			}else{
				$this.removeClass('checked').html('');
				$(sumObj+' '+obj).removeClass('checked').html(''); //取消整体全选
			}
		});

	});

}

function cartsTotalNum(){
	var str='';
	$('.carts .carts_check i').each(function(){
		if($(this).hasClass('checked')){
			if(str==''){
				str=$(this).attr('id') + '-' + $(this).attr('goods-num');
			}else{
				str=str+','+$(this).attr('id') + '-' + $(this).attr('goods-num');
			}
		}
	});
	$('#totalcartnumb').val(str);
}

$(function(){
	fnSelect(".select_all", ".carts", ".check");

	$(".carts ul").each(function(){
		var _this=$(this);

		_this.find('.btn_plus').on('click', function() {
			numPlus($(this), '.num', '.btn_less');
			sum(".select_all", ".carts", ".check",'.count');//计算金额
			
			cartsTotalNum();
		});

		//判断当前“减”按钮是否可用
		_this.find('.num_box .num').each(function() {
			var $this=$(this);
			if(parseInt($this.text())==1){
				$this.siblings('.btn_less').addClass('failed');
			}
		});

		_this.find('.btn_less').on('click', function() {
			numLess($(this), '.num');
			sum(".select_all", ".carts", ".check",'.count');//计算金额
			cartsTotalNum();
		});

	});
	
	//删除商品
	$('.carts .btn-del').on('click',function(){

		var $this = $(this);
		$this.parentsUntil('ul').parent().remove();//移除
		sum(".select_all", ".carts", ".check",'.count');//计算金额

		var _id = $this.attr('data-id');
		var _token = $('input[name=_token]').val();

		$.ajax({
	        'type':'post',
	        'url':'/carts_del',
	        'data':{'id':_id,'_token':_token},
	        'success':function (msg) {
	            if(msg == '400'){
	            	layer.msg('删除失败！');
	            }
	        },
	        'error':function () {
	            layer.msg('请求失败！');
	        }
	    });
	});


	//添加订单
	//
});

//方法一：
$(function(){

	cartsTotalNum();

	$('.carts .carts_check i').on('click',function(){
		cartsTotalNum();
	});

	$('.confirm_order').on('click', function() {
		if($(this).hasClass('unable')){
			return false;
		}else{
			if($('.carts .carts_check i.checked').length==0){
				layer.open({
	                content: '请选择一件商品'
	                ,skin: 'msg'
	                ,time: 2
	            });
			}else{
				var _data = $('input[name=data]').val();
				var _token = $('input[name=_token]').val();
				var _total_price = $('.total').text();
				$.ajax({
					'url':'/order_add',
					'type':'post',
					'data':{'goods_info':_data, 'total_price':_total_price, '_token':_token},
					'success':function(data){
						var data = $.parseJSON(data);
						if(data.code == '200'){
							window.location.href = "/confirm_order/"+data.data;
						}else{
							layer.open({
				                content: '订单添加失败'
				                ,skin: 'msg'
				                ,time: 2
				            });
						}
					},
					'error':function(){
						layer.open({
			                content: '提交错误'
			                ,skin: 'msg'
			                ,time: 2
			            });
					}
				});
			}
		}
	});	

	if($('.carts ul').length==0){
		$('.confirm_order').addClass('unable');
	}

	$('.select_all .check').click(function(){
		cartsTotalNum();
	});

});

String.prototype.queryString= function(name) {
    var reg=new RegExp("[\?\&]" + name+ "=([^\&]+)","i"),r = this.match(reg);
    return r!==null?unescape(r[1]):null;
};
window.onload=function(){
    var last=location.href.queryString("_v");
    if(location.href.indexOf("?")==-1){
        location.href=location.href+"?_v="+(new Date().getTime());
    }else{
        var now=new Date().getTime();
        if(!last){
            location.href=location.href+"&_v="+(new Date().getTime());
        }else if(parseInt(last)<(now-1000)){
            location.href=location.href.replace("_v="+last,"_v="+(new Date().getTime()));
        }
    }
};
