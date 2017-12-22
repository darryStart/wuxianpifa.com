@extends('admin.master')

@section('content')
    <link href="{{asset('/layui/css/layui.css')}}" rel="stylesheet" type="text/css" />
    <form action="" method="post" class="form form-horizontal" id="form-product-add">
        {{ csrf_field() }}
        <input type="hidden" name="pid" value="{{$product->id}}"/>
        <div class="row cl">
            <label class="form-label col-2"><span class="c-red">*</span>名称：</label>
            <div class="formControls col-5">
                <input type="text" class="input-text" value="{{$product->name}}" placeholder="" name="name" datatype="*" nullmsg="名称不能为空">
            </div>
            <div class="col-4"> </div>
        </div>
        <div class="row cl">
            <label class="form-label col-2"><span class="c-red">*</span>简介：</label>
                <div class="formControls col-5">
                    <input type="text" class="input-text" value="{{$product->summary}}" placeholder="" name="summary"  datatype="*" nullmsg="简介不能为空">
                </div>
            <div class="col-4"> </div>
        </div>

        <div class="row cl">
            <label class="form-label col-2"><span class="c-red">*</span>原价格：</label>
            <div class="formControls col-5">
                <input type="text" class="input-text" style="width: 93%;" value="{{$product->price}}" placeholder="" name="price"  datatype="*" nullmsg="价格不能为空">&nbsp;&nbsp;(元)
            </div>
            </div>
            <div class="col-4"> </div>
        </div>

        <div class="row cl">
            <label class="form-label col-2"><span class="c-red">*</span>销售量：</label>
            <div class="formControls col-5 ">
                <input type="text" class="input-text" value="{{$product->sales_num or 0}}"  class="layui-input"  placeholder="" name="sales_num"  datatype="*" nullmsg="销售量不能为空">
            </div>
            <div class="col-4"> </div>
        </div>

      <div class="row cl">
        <label class="form-label col-2"><span class="c-red">*</span>批发件：</label>
        <div class="formControls col-5">
            <input type="number" class="input-text" value="{{$product->trade_price['num'][0]}}" placeholder="" name="trade[num][]"  datatype="*" nullmsg="批发件不能为空">
            <input type="number" class="input-text" value="{{$product->trade_price['num'][1]}}" placeholder="" name="trade[num][]"  datatype="*" nullmsg="批发件不能为空">
            <input type="number" class="input-text" value="{{$product->trade_price['num'][2]}}" placeholder="" name="trade[num][]"  datatype="*" nullmsg="批发件不能为空"> &nbsp;&nbsp;(件)
        </div>
        <div class="col-4"> </div>
      </div>

        <div class="row cl">
            <label class="form-label col-2"><span class="c-red">*</span>批发价：</label>
            <div class="formControls col-5">
              <input type="text" class="input-text" style="width: 80px" value="{{$product->trade_price['price'][0]}}" placeholder="" name="trade[price][]"  datatype="*" nullmsg="价格不能为空">
              <input type="text" class="input-text" style="width: 80px" value="{{$product->trade_price['price'][1]}}" placeholder="" name="trade[price][]"  datatype="*" nullmsg="价格不能为空">
              <input type="text" class="input-text" style="width: 80px" value="{{$product->trade_price['price'][2]}}" placeholder="" name="trade[price][]"  datatype="*" nullmsg="价格不能为空">&nbsp;&nbsp;(元)
        </div>
            <div class="col-4"> </div>
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-2">类别：</label>
            <div class="formControls col-5"> <span class="select-box" style="width:150px;">
              <select class="select" name="category_id" size="1">
                @foreach($categories as $category)
                  <option @if($category->id == $product->category_id) selected="selected" @endif value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
              </select>
              </span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-2">预览图：</label>
            <div class="formControls col-5">
              <img id="preview_id" src="{{asset($product->preview)}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id').click()" />
              <input type="file" name="file" id="input_id" style="display: none;" onchange="return uploadImageToServer('input_id','images', 'preview_id');" />
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-2">详细内容：</label>
            <div class="formControls col-8">
                <script id="editor" type="text/plain" style="width:100%; height:400px;">{!! $product->content !!}</script>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-2">产品图片：</label>
            <div class="formControls col-8">
                <img id="preview_id1" src="@if(isset($pdt_images[0]->image_path)) {{$pdt_images[0]->image_path}} @else {{'/admin/images/icon-add.png'}} @endif" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id1').click()" />
                <input type="file" name="file" id="input_id1" style="display: none;" onchange="return uploadImageToServer('input_id1','images', 'preview_id1');" />

                <img id="preview_id2" src="@if(isset($pdt_images[1]->image_path)) {{$pdt_images[1]->image_path}} @else {{'/admin/images/icon-add.png'}} @endif" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id2').click()" />
                <input type="file" name="file" id="input_id2" style="display: none;" onchange="return uploadImageToServer('input_id2','images', 'preview_id2');" />

                <img id="preview_id3" src="@if(isset($pdt_images[2]->image_path)) {{$pdt_images[2]->image_path}} @else {{'/admin/images/icon-add.png'}} @endif" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id3').click()" />
                <input type="file" name="file" id="input_id3" style="display: none;" onchange="return uploadImageToServer('input_id3','images', 'preview_id3');" />

                <img id="preview_id4" src="@if(isset($pdt_images[3]->image_path)) {{$pdt_images[3]->image_path}} @else {{'/admin/images/icon-add.png'}} @endif" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id4').click()" />
                <input type="file" name="file" id="input_id4" style="display: none;" onchange="return uploadImageToServer('input_id4','images', 'preview_id4');" />

                <img id="preview_id5" src="@if(isset($pdt_images[4]->image_path)) {{$pdt_images[4]->image_path}} @else {{'/admin/images/icon-add.png'}} @endif" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id5').click()" />
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
    'loading' : "{{asset('/admin/images/loading_072.gif')}}",
    'upload'  : "{{url('/service/upload')}}",
    '_token'  : "{{csrf_token()}}"
    };

    var ue = UE.getEditor('editor');
    ue.execCommand( "getlocaldata" );

    $("#form-product-add").Validform({
        tiptype:2,
        callback:function(form){
            $('#form-product-add').ajaxSubmit({
                type: 'post', 
                url: '{{url('/admin/service/product/edit')}}',
                dataType: 'json',
                data: {
                    pid: $('input[name=pid]').val(),
                    name: $('input[name=name]').val(),
                    summary: $('input[name=summary]').val(),
                    price: $('input[name=price]').val(),
                    category_id: $('select[name=category_id] option:selected').val(),
                    preview: ($('#preview_id').attr('src')!='{{asset('/admin/images/icon-add.png')}}'?$('#preview_id').attr('src'):''),
                    sales_num:$('input[name=sales_num]').val(),
                    content: ue.getContent(),
                    preview1: ($('#preview_id1').attr('src')!='{{asset('/admin/images/icon-add.png')}}'?$('#preview_id1').attr('src'):''),
                    preview2: ($('#preview_id2').attr('src')!='{{asset('/admin/images/icon-add.png')}}'?$('#preview_id2').attr('src'):''),
                    preview3: ($('#preview_id3').attr('src')!='{{asset('/admin/images/icon-add.png')}}'?$('#preview_id3').attr('src'):''),
                    preview4: ($('#preview_id4').attr('src')!='{{asset('/admin/images/icon-add.png')}}'?$('#preview_id4').attr('src'):''),
                    preview5: ($('#preview_id5').attr('src')!='{{asset('/admin/images/icon-add.png')}}'?$('#preview_id5').attr('src'):''),
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
<script src="/layui/layui.js" charset="utf-8"></script>
<script>
    layui.use('laydate', function(){
        var laydate = layui.laydate;
        //时间选择器
        laydate.render({
            elem: '#test5',
            type: 'datetime'
        });
    });
</script>
@endsection
