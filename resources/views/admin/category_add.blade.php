@extends('admin.master')

@section('content')
    <link href="{{URL::asset('/layui/css/layui.css')}}" rel="stylesheet" type="text/css" />
    <form action="" method="post" class="form form-horizontal" id="form-category-add">
        {{ csrf_field() }}
        <div class="row cl">
            <label class="form-label col-3"><span class="c-red">*</span>名称：</label>
            <div class="formControls col-5">
                <input type="text" class="input-text" value="" placeholder="" name="name" datatype="*" nullmsg="名称不能为空">
            </div>
            <div class="col-4"> </div>
        </div>
        <div class="row cl">
            <label class="form-label col-3"><span class="c-red">*</span>序号：</label>
            <div class="formControls col-5">
                <input type="number" class="input-text" value="0" placeholder="" name="category_no"  datatype="*" nullmsg="序号不能为空">
            </div>
            <div class="col-4"> </div>
        </div>
        <div class="row cl">
            <label class="form-label col-3">父类别：</label>
            <div class="formControls col-5"> <span class="select-box" style="width:150px;">
                <select class="select" name="parent_id" size="1">
                    <option value="0">无</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
              </span>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-3">预览图：</label>
            <div class="formControls col-5">
              <img id="preview_id" src="{{URL::asset('/admin/images/icon-add.png')}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id').click()" />
              <input type="file" name="file" id="input_id" style="display: none;" onchange="return uploadImageToServer('input_id','images', 'preview_id');" />
            </div>
        </div>

        <div class="row cl">
            <div class="col-9 col-offset-3">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>
@endsection

@section('my-js')
<script type="text/javascript">

  //定义全局变量
  var GV = {
    'loading' : "{{URL::asset('/admin/images/loading_072.gif')}}",
    'upload'  : "{{url('/service/upload')}}",
    '_token'  : "{{csrf_token()}}"
  };

$("#form-category-add").Validform({
    tiptype:2,
    callback:function(form){
        $('#form-category-add').ajaxSubmit({
            type: 'post',
            url: '{{url('/admin/service/category/add')}}', // 需要提交的 url
            dataType: 'json',
            data: {
                name: $('input[name=name]').val(),
                category_no: $('input[name=category_no]').val(),
                parent_id: $('select[name=parent_id] option:selected').val(),
                img_url: ($('#preview_id').attr('src')!='{{URL::asset('/admin/images/icon-add.png')}}'?$('#preview_id').attr('src'):'/img/b8.png'),
                _token: "{{csrf_token()}}"
            },
            success: function(data) {
                if(data == null) {
                    layer.msg('服务端错误', {icon:2, time:2000});
                    return;
                }
                if(data.status != 0) {
                    layer.msg(data.message, {icon:2, time:2000});
                    return;
                }

                layer.msg(data.message, {icon:1, time:2000});
                parent.location.reload();
            },
            error: function(xhr, status, error) {
                layer.msg('ajax error', {icon:2, time:2000});
            },
            beforeSend: function(xhr){
                layer.load(0, {shade: false});
            },
        });
        return false;
    }
  });
</script>
<script type="text/javascript" src="{{asset('/layui/layui.js')}}"></script>
@endsection
