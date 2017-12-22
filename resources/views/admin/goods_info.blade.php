@extends('admin.master')

@section('content')
    <style>
    .row.cl {
      margin: 20px 0;
    }
    </style>

    <form class="form form-horizontal" action="" method="">
        <div class="row cl">
            <label class="form-label col-3"><span class="c-red"></span>名称：</label>
            <div class="formControls col-5">
              {{$goods->name}}
            </div>
            <div class="col-4"> </div>
        </div>
        <div class="row cl">
            <label class="form-label col-3"><span class="c-red"></span>简介：</label>
            <div class="formControls col-5">
              {{$goods->summary}}
            </div>
            <div class="col-4"> </div>
        </div>

        <div class="row cl">
            <label class="form-label col-3"><span class="c-red">*</span>到期时间：</label>
            <div class="formControls col-5 ">
                {{date('Y-m-d H:i:s',$goods->end_time)}}
            </div>
            <div class="col-4"> </div>
        </div>

        <div class="row cl">
            <label class="form-label col-3"><span class="c-red">*</span>销售量：</label>
            <div class="formControls col-5 ">
               {{$goods->wholesale_num}}
            </div>
            <div class="col-4"> </div>
        </div>

        <div class="row cl">
            <label class="form-label col-3"><span class="c-red">*</span>总批发件：</label>
            <div class="formControls col-5">
                <input type="number" class="input-text" value="{{$goods->wholesale_total}}" placeholder="" name="trade[num][]" disabled="disabled"  datatype="*" nullmsg="批发件不能为空">&nbsp;&nbsp;(件)
            </div>
            <div class="col-4"> </div>
        </div>
        <div class="row cl">
            <label class="form-label col-3"><span class="c-red">*</span>批发价：</label>
            <div class="formControls col-5">
                <input type="text" class="input-text" style="width: 80px" value="{{$goods->wholesale_price}}" placeholder="" disabled="disabled"  name="trade['price'][]"  datatype="*" nullmsg="价格不能为空">&nbsp;&nbsp;(元)
            </div>
        </div>
        <div class="col-4"> </div>

        <div class="row cl">
            <label class="form-label col-3">预览图：</label>
            <div class="formControls col-5">
              @if($goods->preview != null)
                <img id="preview_id" src="{{URL::asset($goods->preview)}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;"/>
              @endif
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-3">详细内容：</label>
            <div class="formControls col-8">
              {!! $goods->content !!}
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-3">产品图片：</label>
            <div class="formControls col-8">
              @foreach($gds_images as $v)
                <img src="{{URL::asset($v->image_path)}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" />
              @endforeach
            </div>
        </div>
    </form>
@endsection
