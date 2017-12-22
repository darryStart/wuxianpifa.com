@extends('admin.master')

@section('content')

  <style>
    .row.cl {
      margin: 20px 0;
    }
  </style>

<form class="form form-horizontal" action="" method="post">
    <div class="row cl">
        <label class="form-label col-3"><span class="c-red"></span>名称：</label>
        <div class="formControls col-5">
          {{$product->name}}
        </div>
        <div class="col-4"> </div>
    </div>
    <div class="row cl">
        <label class="form-label col-3"><span class="c-red"></span>简介：</label>
        <div class="formControls col-5">
          {{$product->summary}}
        </div>
        <div class="col-4"> </div>
    </div>
    <div class="row cl">
        <label class="form-label col-3"><span class="c-red"></span>原价格：</label>
        <div class="formControls col-5">
          {{$product->price}}
        </div>
        <div class="col-4"> </div>
    </div>

    <div class="row cl">
        <label class="form-label col-3"><span class="c-red"></span>销售量：</label>
        <div class="formControls col-5">
          {{$product->sales_num}}
        </div>
        <div class="col-4"> </div>
    </div>

    <div class="row cl">
        <label class="form-label col-3"><span class="c-red">*</span>到期时间：</label>
        <div class="formControls col-5 ">
            {{date('Y-m-d H:i:s',$product->end_time)}}
        </div>
        <div class="col-4"> </div>
    </div>

    <div class="row cl">
        <label class="form-label col-3"><span class="c-red">*</span>批发件：</label>
        <div class="formControls col-5">
            <input type="number" class="input-text" value="{{$product->trade_price['num'][0]}}" placeholder="" name="trade[num][]" disabled="disabled"  datatype="*" nullmsg="批发件不能为空">
            <input type="number" class="input-text" value="{{$product->trade_price['num'][1]}}" placeholder="" name="trade[num][]" disabled="disabled"  datatype="*" nullmsg="批发件不能为空">
            <input type="number" class="input-text" value="{{$product->trade_price['num'][2]}}" placeholder="" name="trade[num][]" disabled="disabled"  datatype="*" nullmsg="批发件不能为空"> &nbsp;&nbsp;(件)
        </div>
        <div class="col-4"> </div>
    </div>
    <div class="row cl">
        <label class="form-label col-3"><span class="c-red">*</span>批发价：</label>
        <div class="formControls col-5">
            <input type="text" class="input-text" style="width: 80px" value="{{$product->trade_price['price'][0]}}" placeholder="" disabled="disabled"  name="trade['price'][]"  datatype="*" nullmsg="价格不能为空">
            <input type="text" class="input-text" style="width: 80px" value="{{$product->trade_price['price'][1]}}" placeholder="" disabled="disabled"  name="trade['price'][]"  datatype="*" nullmsg="价格不能为空">
            <input type="text" class="input-text" style="width: 80px" value="{{$product->trade_price['price'][2]}}" placeholder="" disabled="disabled"  name="trade['price'][]"  datatype="*" nullmsg="价格不能为空">&nbsp;&nbsp;(元)
        </div>
    </div>
    <div class="col-4"> </div>

    <div class="row cl">
        <label class="form-label col-3"><span class="c-red"></span>类别：</label>
        <div class="formControls col-5">
          {{$product->category->name}}
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-3">预览图：</label>
        <div class="formControls col-5">
          @if($product->preview != null)
            <img id="preview_id" src="{{URL::asset($product->preview)}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;"/>
          @endif
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-3">详细内容：</label>
        <div class="formControls col-8">
          {!! $product->content !!}
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-3">产品图片：</label>
        <div class="formControls col-8">
          @foreach($pdt_images as $pdt_image)
            <img src="{{URL::asset($pdt_image->image_path)}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" />
          @endforeach
        </div>
    </div>
</div>
@endsection
