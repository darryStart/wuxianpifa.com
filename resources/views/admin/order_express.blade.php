@extends('admin.master')

@section('content')
<form action="" method="post" class="form form-horizontal" id="form-data">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{$data->oid}}">
    <div class="row cl">
        <label class="form-label col-2">收货人：</label>
        <div class="formControls col-5">
            <span>{{$data->user_name}}</span>
        </div>
        <div class="col-4"> </div>
    </div>
    
    <div class="row cl">
        <label class="form-label col-2">收货人电话：</label>
        <div class="formControls col-5">
            <span>{{$data->mobile}}</span>
        </div>
        <div class="col-4"> </div>
    </div>

    <div class="row cl">
        <label class="form-label col-2">收货地址：</label>
        <div class="formControls col-5">
            <span>{{$data->s_province}}</span>
            <span>{{$data->s_city}}</span>
            <span>{{$data->s_county}}</span>
        </div>
        <div class="col-4"> </div>
    </div>

    <div class="row cl">
        <label class="form-label col-2">收货详情：</label>
        <div class="formControls col-5">
            <span>{{$data->address}}</span>
        </div>
        <div class="col-4"> </div>
    </div>
    @if($data->status > '1')
    <div class="row cl">
        <label class="form-label col-2"><span class="c-red">*</span>快递公司：</label>
        <div class="formControls col-5">
            <select name="express_name" class="input-text" >
                <option value="">-</option>
                <option @if($data->express_name == '顺丰快递') selected="selected" @endif value="顺丰快递">顺丰快递</option>
                <option @if($data->express_name == '申通快递') selected="selected" @endif value="申通快递">申通快递</option>
                <option @if($data->express_name == '圆通快递') selected="selected" @endif value="圆通快递">圆通快递</option>
                <option @if($data->express_name == '韵达快递') selected="selected" @endif value="韵达快递">韵达快递</option>
                <option @if($data->express_name == '天天快递') selected="selected" @endif value="天天快递">天天快递</option>
                <option @if($data->express_name == '中通快递') selected="selected" @endif value="中通快递">中通快递</option>
                <option @if($data->express_name == '百世汇通') selected="selected" @endif value="百世汇通">百世汇通</option>
                <option @if($data->express_name == '邮政EMS') selected="selected" @endif value="邮政EMS">邮政EMS</option>
                <option @if($data->express_name == '汇通快递') selected="selected" @endif value="汇通快递">汇通快递</option>
                <option @if($data->express_name == '优速快递') selected="selected" @endif value="优速快递">优速快递</option>
                <option @if($data->express_name == '跨越速运') selected="selected" @endif value="跨越速运">跨越速运</option>
                <option @if($data->express_name == '宅急送') selected="selected" @endif value="宅急送">宅急送</option>
                <option @if($data->express_name == '国通快递') selected="selected" @endif value="国通快递">国通快递</option>
            </select>
        </div>
        <div class="col-4"> </div>
    </div>
    <div class="row cl">
        <label class="form-label col-2"><span class="c-red">*</span>快递单号：</label>
        <div class="formControls col-5">
          <input type="text" class="input-text" value="{{$data->express_no}}" placeholder="" name="express_no" datatype="*" nullmsg="快递单号">
        </div>
        <div class="col-4"> </div>
    </div>
    <div class="row cl">
        <div class="col-8 col-offset-2">
            <input style="margin: 20px 0; width: 200px;" class="btn btn-primary radius" type="button" value="&nbsp;&nbsp;保存&nbsp;&nbsp;">
        </div>
    </div>
    @else
        <div class="row cl">
            <label class="form-label col-3" style="color: red;">暂未付款,不能添加快递信息</label>
        </div>
        
    @endif
</form>
@endsection

@section('my-js')

<script type="text/javascript">
  $('.btn-primary').click(function(){
        var _express_name  = $('select[name=express_name]').val();
        var _id = $('input[name=id]').val();
        var _token = $('input[name=_token]').val();
        var _express_no = $('input[name=express_no]').val();
        $.ajax({
            url:'/admin/do_order_express',
            type:'post',
            data:{'express_name':_express_name, '_token':_token, 'id':_id, 'express_no':_express_no},
            success:function(data){

                if(data == null) {
                  layer.msg('服务端错误', {icon:2, time:2000});
                  return;
                }
                if(data != 200) {
                  layer.msg('保存错误', {icon:2, time:2000});
                  return;
                }

                layer.msg('保存成功', {icon:1, time:2000});
                parent.location.reload();
            },
            error:function(){
                layer.msg('ajax error', {icon:2, time:2000});
            },
            beforeSend: function(xhr){
                layer.load(0, {shade: false});
            },
        });
  });

</script>
  <script type="text/javascript" src="{{asset('/layui/layui.js')}}"></script>
@endsection
