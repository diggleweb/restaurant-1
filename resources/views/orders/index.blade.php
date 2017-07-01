@extends('layouts.admin')
@section('title', 'Order')
@section('breadcrumbs')
	{!! Breadcrumbs::render('Order') !!}
@stop

@section('style-top')
<style type="text/css">
	tr.new{
		background-color: #FF92AA;
		transition: all;
		-webkit-transition-duration: 250ms;
		transition-duration: 250ms;
	}
</style>
@stop

@section('script-bottom')
	<script>
		$(function(){
			var checkNewULR = "{!! route('admin.orders.check_new',['id'=>null]) !!}";
			setInterval(checkNew, 180000);
			function checkNew(){
				var last_id = $("#last_id").val();
				$.ajax({
					url: checkNewULR + '/'+ last_id,
					success: function(res){
						console.log(res);
						if (res.length > 0) {
							generateHTML(res);
						};
					},
					error: function(error){
						console.log(error);
					}
				});
			}
			function generateHTML(orders){
				if (orders.length == 0) {
					return;
				}
				var html = '';
				for (var i = 0; i < orders.length; i++) {
					order = orders[i];
					var order_status_class = {'PENDING':'warning','DELIVERED':'success','PROCESSING':'info','CANCELED':'danger'};
					html += '<tr class="new">'+
						'<td>'+order.order_ref_id+'</td>'+
						'<td>'+order.customer.name+"(ph:"+order.customer.phone_no+")"+'</td>'+
						'<td>'+order.tax+'</td>'+
						'<td>'+order.vat+'</td>'+
						'<td>'+order.total_price+'</td>'+
						'<td>'+order.deliver_at+'</td>'+
						'<td>'+
							'<label class="label label-'+order_status_class[order.order_status]+'">'+
								order.order_status+
							'</label>'+
						'</td>'+
						'<td>'+
							'<a href="/admin/orders/'+order.id+'/edit"><i class="glyphicon glyphicon-edit"></i></a>'+
							'<a href="/admin/orders/'+order.id+'/delete" onclick="return confirm(\'Are you sure wants to delete this Order?\')"><i class="glyphicon glyphicon-remove"></i></a>'+
						'</td>'+
					'</tr>';
					console.log(html);
				}
				$("#order-list-container tr").eq(0).after(html);
				$("#last_id").val(orders[i-1].id);
				setTimeout(function() {
					$("#order-list-container tr.new").removeClass('new');
				}, 7000);
			}
		});
	</script>
@stop
@section('content')
<?php if (!empty($orders[0]['id'])) {?>
	<input type="hidden" id="last_id" value="{{ $orders[0]['id'] }}"/>
<?php }else{?>
	<input type="hidden" id="last_id" value="0"/>
<?php }?>
		<div class="row">
			@if($orders->isEmpty())
				<div class="well text-center">No Orders found.</div>
			@else
				<table class="table table-hover">
					<thead>
						<th>Order Ref Id</th>
						<th>Customer</th>
						<th>Tax</th>
						<th>Vat</th>
						<th>Total Price</th>
						<th>Deliver At</th>
						<th>Order Status</th>
						<th width="50px">Action</th>
					</thead>
					<tbody id="order-list-container">
					 <tr>
						{!! Form::open(['route' => 'admin.orders.index', 'method' => 'get', 'class' => "form-inline", 'id' => "search_form"]) !!}
						<td colspan=3>
							{!! Form::text('order_ref_id', null, ['class' => 'form-control','placeholder'=>'search by order ref id']) !!}
						</td>
						<td colspan=4>
							<div class="btn-group btn-radio btn-group-md" data-toggle="buttons">
								<label class="btn btn-warning">
									{!! Form::radio('order_status','PENDING', null, ['class' => 'form-control']) !!}
								PENDING
								</label>
								<label class="btn btn-success">
									{!! Form::radio('order_status','DELIVERED', null, ['class' => 'form-control']) !!}
								DELIVERED
								</label>
								<label class="btn btn-info">
									{!! Form::radio('order_status','PROCESSING', null, ['class' => 'form-control']) !!}
								PROCESSING
								</label>
								<label class="btn btn-danger">
									{!! Form::radio('order_status','CANCELED', null, ['class' => 'form-control']) !!}
								CANCELED
								</label>
							</div>
						</td>
						<td>
							<button onclick="return $('#search_form').submit()" class="btn btn-primary">
								<i class="glyphicon glyphicon-search"></i>
							</button>
						</td>
						{!! Form::close() !!}
					</tr>
					@define $order_status_class = ['PENDING'=>'warning','DELIVERED'=>'success','PROCESSING'=>'info','CANCELED'=>'danger']
					@foreach($orders as $order)
						<tr>
							<td>{!! $order->order_ref_id !!}</td>
							<td>{!! $order->customer->name."(ph:".$order->customer->phone_no.")" !!}</td>
							<td>{!! $order->tax !!}</td>
							<td>{!! $order->vat !!}</td>
							<td>{!! $order->total_price !!}</td>
							<td>{!! $order->deliver_at !!}</td>
							<td>
								<label class="label label-{{$order_status_class[$order->order_status]}}">
									{!! $order->order_status !!}
								</label>
							</td>
							<td>
								<a href="{!! route('admin.orders.edit', [$order->id]) !!}"><i class="glyphicon glyphicon-edit"></i></a>
								<a href="{!! route('admin.orders.delete', [$order->id]) !!}" onclick="return confirm('Are you sure wants to delete this Order?')"><i class="glyphicon glyphicon-remove"></i></a>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			@endif
		</div>
		{!! $orders->render() !!}
@endsection