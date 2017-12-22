@extends('admin.master')

@section('content')
<div class="pd-20">
	<div class="mt-20">
		<table class="table table-border table-bordered table-hover table-bg table-sort">
			<thead>
				<tr class="text-c">
					<th width="80">ID</th>
					<th width="100">批发商名称</th>
					<th width="50">申请人</th>
					<th width="50">申请人电话</th>
					<th width="100">申请时间</th>
					<th width="50">申请结果</th>
					<th width="20">操作</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data as $v)
					<tr class="text-c">
						<td>{{$v->id}}</td>
						<td>{{$v->wholesaler_name}}</td>
						<td>{{$v->apply_name}}</td>
						<td>{{$v->wholesaler_tel}}</td>
						<td>{{date('Y-m-d H:i:s',$v->time)}}</td>
						<td>
							@if($v->status == '0')
								<span style="color:#0000ff">等待处理</span>
							@elseif($v->status == '1')
								<span style="color: green">申请通过</span>
							@else
								<span style="color: red">申请未通过</span>	
							@endif
						</td>
						<td class="td-manage">
							<a title="审批" href="javascript:;" onclick="apply_edit('审批','{{url('/admin/do_apply')}}/{{$v->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
							{{-- <a title="删除" href="javascript:;" onclick='category_del("{{$v->id}}", "{{$v->id}}")' class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a> --}}
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div class="pages" >
	        {!! $data->render() !!}
	    </div>
	</div>
</div>
@endsection

@section('my-js')
<script type="text/javascript">
	function apply_edit(title, url) {
		var index = layer.open({
			type: 2,
			title: title,
			content: url
		});
		layer.full(index);
	}
</script>
@endsection
