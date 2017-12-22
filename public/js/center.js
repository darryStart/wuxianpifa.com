$(function(){
	$('.submit').on('click',function(){
		var wholesaler_name = $('input[name=wholesaler_name]').val();
		var apply_name = $('input[name=apply_name]').val();
		var wholesaler_tel = $('input[name=wholesaler_tel]').val();
		var wholesaler_info = $('textarea[name=wholesaler_info]').val();
		var _id = $('input[name=id]').val(); 
		var _token = $('input[name=_token]').val();
		if(wholesaler_name == ''){
			layer.open({
                content: '请填写批发商名称'
                ,skin: 'msg'
                ,time: 2
            });
            return false;
		}

		if(apply_name == ''){
			layer.open({
                content: '请填写申请人称呼'
                ,skin: 'msg'
                ,time: 2
            });
            return false;
		}

		if(!(/^1[34578]\d{9}$/.test(wholesaler_tel))){
			layer.open({
                content: '请正确申请人电话'
                ,skin: 'msg'
                ,time: 2
            });
            return false;
		}

		if(wholesaler_info == ''){
			layer.open({
                content: '请填写申请详情信息'
                ,skin: 'msg'
                ,time: 2
            });
            return false;
		}
		
		$.ajax({
			url:'/do_apply',
			type:'post',
			data:{
				'wholesaler_name':wholesaler_name,
				'apply_name':apply_name,
				'wholesaler_tel':wholesaler_tel,
				'wholesaler_info':wholesaler_info,
				'_token':_token,
				'id':_id
			},
			success:function(obj){
				if(obj == '200'){
					layer.open({
		                content: '申请成功'
		                ,skin: 'msg'
		                ,time: 3
		            });
		            location.reload();
				}else{
					layer.open({
		                content: '申请失败'
		                ,skin: 'msg'
		                ,time: 3
		            });	
				}
			},
			error:function(){
				layer.open({
		            content: '申请错误'
		            ,skin: 'msg'
		            ,time: 3
		        });	
			}

		});
	});
});