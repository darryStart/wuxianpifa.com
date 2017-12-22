@extends('admin.master')

@section('content')
<link href="{{URL::asset('/layui/css/layui.css')}}" rel="stylesheet" type="text/css" />
<form action="" method="post" class="form form-horizontal" id="form-product-add">
    {{ csrf_field() }}
    <div class="row cl">
        <label class="form-label col-2"><span class="c-red">*</span>名称：</label>
        <div class="formControls col-5">
            <input type="text" class="input-text" value="" placeholder="" name="name" datatype="*" nullmsg="名称不能为空">
        </div>
        <div class="col-4"> </div>
    </div>
    <div class="row cl">
        <label class="form-label col-2"><span class="c-red">*</span>简介：</label>
        <div class="formControls col-5">
            <input type="text" class="input-text" value="" placeholder="" name="summary"  datatype="*" nullmsg="简介不能为空">
        </div>
        <div class="col-4"> </div>
    </div>

    <div class="row cl">
        <label class="form-label col-2"><span class="c-red">*</span>到期时间：</label>
        <div class="formControls col-5 ">
          <input type="text" class="input-text" value="{{date('Y-m-d H:i:s')}}"  class="layui-input" id="test5" placeholder="" name="end_time"  datatype="*" nullmsg="到期时间不能为空">
        </div>
        <div class="col-4"> </div>
    </div>

    <div class="row cl">
        <label class="form-label col-2"><span class="c-red">*</span>销售量：</label>
        <div class="formControls col-5">
            <input type="text" class="input-text" value="0" placeholder="" name="wholesale_num"  datatype="*" nullmsg="销售量不能为空">
        </div>
        <div class="col-4"> </div>
    </div>
    <div class="row cl">
        <label class="form-label col-2"><span class="c-red">*</span>拼单批发总件：</label>
            <div class="formControls col-5">
                <input type="number" class="input-text" value="999" placeholder="" name="wholesale_total"  datatype="*" nullmsg="批发件不能为空">&nbsp;&nbsp;(件)
            </div>
        <div class="col-4"> </div>
    </div>

    <div class="row cl">
        <label class="form-label col-2"><span class="c-red">*</span>拼单批发价：</label>
        <div class="formControls col-5">
            <input type="text" class="input-text" style="width: 80px" value="999" placeholder="" name="wholesale_price"  datatype="*" nullmsg="价格不能为空">&nbsp;&nbsp;(元)
        </div>
    <div class="col-4"> </div>
    </div>

    <div class="row cl">
        <label class="form-label col-2">预览图：</label>
        <div class="formControls col-5">
          <img id="preview_id" src="{{URL::asset('/admin/images/icon-add.png')}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id').click()" />
          <input type="file" name="file" id="input_id" style="display: none;" onchange="return uploadImageToServer('input_id','images', 'preview_id');" />
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-2">详细内容：</label>
        <div class="formControls col-8">
            <script id="editor" type="text/plain" style="width:100%; height:400px;"></script>
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-2">产品图片：</label>
        <div class="formControls col-8">
            <img id="preview_id1" src="{{URL::asset('/admin/images/icon-add.png')}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id1').click()" />
            <input type="file" name="file" id="input_id1" style="display: none;" onchange="return uploadImageToServer('input_id1','images', 'preview_id1');" />
            <img id="preview_id2" src="{{URL::asset('/admin/images/icon-add.png')}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id2').click()" />
            <input type="file" name="file" id="input_id2" style="display: none;" onchange="return uploadImageToServer('input_id2','images', 'preview_id2');" />
            <img id="preview_id3" src="{{URL::asset('/admin/images/icon-add.png')}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id3').click()" />
            <input type="file" name="file" id="input_id3" style="display: none;" onchange="return uploadImageToServer('input_id3','images', 'preview_id3');" />
            <img id="preview_id4" src="{{URL::asset('/admin/images/icon-add.png')}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id4').click()" />
            <input type="file" name="file" id="input_id4" style="display: none;" onchange="return uploadImageToServer('input_id4','images', 'preview_id4');" />
            <img id="preview_id5" src="{{URL::asset('/admin/images/icon-add.png')}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id5').click()" />
            <input type="file" name="file" id="input_id5" style="display: none;" onchange="return uploadImageToServer('input_id5','images', 'preview_id5');" />
        </div>
    </div>
    <div class="row cl">
        <div class="col-8 col-offset-2">
            <input style="margin: 20px 0; width: 200px;" class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
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

  var ue = UE.getEditor('editor');
  ue.execCommand( "getlocaldata" );

  $("#form-product-add").Validform({
    tiptype:2,
    callback:function(form){
        $('#form-product-add').ajaxSubmit({
            type: 'post', // 提交方式 get/post
            url: '{{url('/admin/service/goods/add')}}', // 需要提交的 url
            dataType: 'json',
            data: {
                name: $('input[name=name]').val(),
                summary: $('input[name=summary]').val(),
                wholesale_price: $('input[name=wholesale_price]').val(),
                wholesale_total: $('input[name=wholesale_total]').val(),
                preview: ($('#preview_id').attr('src')!='{{URL::asset('/admin/images/icon-add.png')}}'?$('#preview_id').attr('src'):''),
                wholesale_num:$('input[name=wholesale_num]').val(),
                content: ue.getContent(),
                preview1: ($('#preview_id1').attr('src')!='{{URL::asset('/admin/images/icon-add.png')}}'?$('#preview_id1').attr('src'):''),
                preview2: ($('#preview_id2').attr('src')!='{{URL::asset('/admin/images/icon-add.png')}}'?$('#preview_id2').attr('src'):''),
                preview3: ($('#preview_id3').attr('src')!='{{URL::asset('/admin/images/icon-add.png')}}'?$('#preview_id3').attr('src'):''),
                preview4: ($('#preview_id4').attr('src')!='{{URL::asset('/admin/images/icon-add.png')}}'?$('#preview_id4').attr('src'):''),
                preview5: ($('#preview_id5').attr('src')!='{{URL::asset('/admin/images/icon-add.png')}}'?$('#preview_id5').attr('src'):''),
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
<script>
    layui.use('laydate', function(){
        var laydate = layui.laydate;
        //时间选择器
        laydate.render({
            elem: '#test5'
            ,type: 'datetime'
        });
    });
</script>
@endsection
