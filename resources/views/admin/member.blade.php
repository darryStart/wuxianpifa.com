@extends('admin.master')

@section('content')
<div class="pd-20">
	<div class="mt-20">
		<table class="table table-border table-bordered table-hover table-bg table-sort">
			<thead>
				<tr class="text-c">
					<th width="80">ID</th>
					<th width="100">昵称</th>
					<th width="40">创建时间</th>
					<th width="50">是否批发商</th>
					<th width="100">操作</th>
				</tr>
			</thead>
			<tbody>
				@foreach($members as $v)
					<tr class="text-c">
						<td>{{$v->id}}</td>
						<td>{{$v->nickname}}</td>
						<td>{{$v->created_at}}</td>
						<td class="td-status">
				            @if($v->active == 1)
								<span class="label label-success radius">批发商</span>
				            @else
				            	<span class="label label-danger radius">普通用户</span>
				        	@endif
				      	</td>
						<td class="td-manage">
							<a title="编辑" href="javascript:;" onclick="member_edit('编辑类别','{{url('/admin/member_edit')}}?id={{$v->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
							{{-- <a title="删除" href="javascript:;" onclick='category_del("{{$v->nickname}}", "{{$v->id}}")' class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a> --}}
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div class="pages" >
	        {!! $members->render() !!}
	    </div>
	</div>
</div>
@endsection

@section('my-js')
<script type="text/javascript">
	function member_edit(title, url) {
		var index = layer.open({
			type: 2,
			title: title,
			content: url
		});
		layer.full(index);
	}
</script>
@endsection
