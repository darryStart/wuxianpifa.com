@extends('admin.master')

@section('content')
<form action="" method="post" class="form form-horizontal" id="form-data">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{$data->user_id}}">
    <div class="row cl">
        <label class="form-label col-2">批发商名称：</label>
        <div class="formControls col-5">
            <span>{{$data->wholesaler_name}}</span>
        </div>
        <div class="col-4"> </div>
    </div>
    
    <div class="row cl">
        <label class="form-label col-2">申请人名称：</label>
        <div class="formControls col-5">
            <span>{{$data->apply_name}}</span>
        </div>
        <div class="col-4"> </div>
    </div>
    
    <div class="row cl">
        <label class="form-label col-2">申请人电话：</label>
        <div class="formControls col-5">
            <span>{{$data->apply_name}}</span>
        </div>
        <div class="col-4"> </div>
    </div>


    <div class="row cl">
        <label class="form-label col-2">申请人信息：</label>
        <div class="formControls col-5">
            <span>{{$data->wholesaler_info}}</span>
        </div>
        <div class="col-4"> </div>
    </div>
    
    <div class="row cl">
        <label class="form-label col-2">申请结果：</label>
        <div class="formControls col-5">
            <input type="radio" name="status" @if($data->status == '0') checked="checked"  @endif value="0"/> 待审核&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="status" @if($data->status == '1') checked="checked"  @endif value="1"/> 通过 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="status" @if($data->status == '2') checked="checked"  @endif value="2"/> 不通过
        </div>
        <div class="col-4"> </div>
    </div>

    
    <div class="row cl">
        <label class="form-label col-2">申请反馈：</label>
        <div class="formControls col-5">
            <textarea name="result" cols="60" style="padding: 5px;"  rows="5">{{$data->result}}</textarea>
        </div>
        <div class="col-4"> </div>
    </div>

    <div class="row cl">
        <div class="col-8 col-offset-2">
            <input style="margin: 20px 0; width: 200px;" class="btn btn-primary radius" type="button" value="&nbsp;&nbsp;保存&nbsp;&nbsp;">
        </div>
    </div>
</form>
@endsection

@section('my-js')

<script type="text/javascript">
  $('.btn-primary').click(function(){
        var _id = $('input[name=id]').val();
        var _token = $('input[name=_token]').val();
        var _status = $("input[type='radio']:checked").val();
        var _result = $('textarea[name=result]').val();
        $.ajax({
            url:'/admin/to_do_apply',
            type:'post',
            data:{'status':_status, '_token':_token, 'id':_id, 'result':_result},
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
