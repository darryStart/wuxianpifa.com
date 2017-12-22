@extends('admin.master')

@section('content')
    <div class="pd-20">
    	<span class="l mb-10">
    		<a href="javascript:;" onclick="product('添加产品','{{url('/admin/goods_add')}}')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加产品</a>
    	</span>
      	<div class="mt-20">
          	<table class="table table-border table-bordered table-hover table-bg table-sort">
          		<thead>
          			<tr class="text-c">
          				<th width="">ID</th>
          				<th width="">名称</th>
          				<th width="30%">摘要</th>
          				<th width="">拼单批发价格</th>
                  <th width="">拼单批发总量</th>
                  <th width="">已拼单批发量</th>
                  <th>拼单到期时间</th>
                  <th>状态</th>
          				<th width="">操作</th>
          			</tr>
          		</thead>
          		<tbody>
          			@foreach($goods as $v)
          				<tr class="text-c">
          					<td>{{$v->id}}</td>
          					<td>{{$v->name}}</td>
          					<td>{{$v->summary}}</td>
          					<td>{{$v->wholesale_price}}</td>
                    <td>{{$v->wholesale_total}}</td>
                    <td>{{$v->wholesale_num}}</td>
                    <td>{{date('Y-m-d H:i:s',$v->end_time)}}</td>
                    <td>
                      @if($v->end_time > time() && $v->status == '1')                        
                        <font color="#00b83f">在线</font>
                        @else
                        <font color="red">下线</font>
                      @endif
                    </td>
          					<td class="td-manage">
                                <a title="详情" href="javascript:;" onclick="product('产品详情','{{url('/admin/goods_info')}}?id={{$v->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe695;</i></a>
          						<a title="编辑" href="javascript:;" onclick="product('编辑产品','{{url('/admin/goods_edit')}}?id={{$v->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
          						<a title="删除" href="javascript:;" onclick='product_del("{{$v->name}}", "{{$v->id}}")' class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
          					</td>
          				</tr>
          			@endforeach
          		</tbody>
          	</table>
            <div class="pages" >
                {!! $goods->render() !!}
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
      $.ajax({
        type: 'post', 
        url: '{{url('/admin/service/goods/del')}}',
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
