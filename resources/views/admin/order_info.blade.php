@extends('admin.master')

@section('content')
    <div style="margin: 20px;">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
                <tr class="text-c">
                    <th>商品图</th>
                    <th>商品摘要</th>
                    <th>订单单价</th>
                    <th>订单数量</th>
                    <th>订单类型</th>
                    <th>订单添加时间</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $v)
                    <tr class="text-c" >
                        <td>
                            <img src="{{URL::asset($v->img_url)}}" style="border: 1px solid #B8B9B9; width: 70px; height: 70px;"/>
                        </td>
                        <td>{{$v->goods_summary}}</td>
                        <td>
                            {{$v->goods_price}}
                        </td>
                        <td>
                            {{$v->goods_num}}
                        </td>
                        <td>
                            @if($v->shop_type == '1')
                                单独批发
                            @elseif($v->shop_type == '2')
                                合伙批发
                            @else
                                普通购买
                            @endif
                        </td>
                        <td>{{$v->create_at}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
