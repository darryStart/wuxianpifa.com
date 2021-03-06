@extends('admin.master')

@section('content')
  <div class="pd-20">
	<span class="l mb-10">
		<a href="javascript:;" onclick="product('添加产品','{{url('/admin/product_add')}}')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加产品</a>
	</span>
  	<div class="mt-20">
  	<table class="table table-border table-bordered table-hover table-bg table-sort">
  		<thead>
  			<tr class="text-c">
  				<th width="80">ID</th>
  				<th width="100">名称</th>
  				<th width="40">简介</th>
  				<th width="90">价格</th>
                <th width="90">类别</th>
  				<th width="100">操作</th>
  			</tr>
  		</thead>
  		<tbody>
  			@foreach($products as $product)
  				<tr class="text-c">
  					<td>{{$product->id}}</td>
  					<td>{{$product->name}}</td>
  					<td>{{$product->summary}}</td>
  					<td>{{$product->price}}</td>
  					<td>{{$product->category_name}}</td>
  					<td class="td-manage">
                        <a title="详情" href="javascript:;" onclick="product('产品详情','{{url('/admin/product_info')}}?id={{$product->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe695;</i></a>
  						<a title="编辑" href="javascript:;" onclick="product('编辑产品','{{url('/admin/product_edit')}}?id={{$product->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
  						<a title="删除" href="javascript:;" onclick='product_del("{{$product->name}}", "{{$product->id}}")' class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
  					</td>
  				</tr>
  			@endforeach
  		</tbody>
  	</table>
    <div class="pages" >
        {!! $products->render() !!}
    </div>
  	</div>
  </div>
@endsection

@section('my-js')
<script type="text/javascript">
    function product(title, url) {
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }

    function product_del(name, id) {
        layer.confirm('确认要删除【' + name +'】吗？',function(index){
            //此处请求后台程序，下方是成功后的前台处理……
            $.ajax({
                type: 'post', // 提交方式 get/post
                url: '{{url('/admin/service/product/del')}}', // 需要提交的 url
                dataType: 'json',
                data: {
                    id: id,
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
                    location.replace(location.href);
                },
                error: function(xhr, status, error) {
                    layer.msg('ajax error', {icon:2, time:2000});
                },
                beforeSend: function(xhr){
                    layer.load(0, {shade: false});
                }
            });
        });
    }
</script>
@endsection
