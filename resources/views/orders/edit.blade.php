@extends('layouts.admin')
@section('title', 'Edit Order')
@section('breadcrumbs')
    {!! Breadcrumbs::render('Order') !!}
@stop
@section('top-menu')
    <li><a href="{!! route('admin.orders.index') !!}" class="btn btn-primary">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        back to Order List</a>
    </li>
@stop

@section('content')
@include('common.errors')
{!! Form::open([
	'route' => ['admin.orders.update', $order->id], 
	'method' => 'patch', 
	'class' => 'panel form-horizontal',
	'style'=>'display: table;width: 100%;'
]) !!}
{!! Form::hidden('customer_id', $order['customer_id']) !!}
{!! Form::hidden('total_price', $order['total_price']) !!}
<?php
$o_status['PENDING'] = null;
$o_status['DELIVERED'] = null;
$o_status['PROCESSING'] = null;
$o_status['CANCELED'] = null;

if (isset($order['order_status'])) {
	if ($order['order_status'] == 'PENDING') {
		$o_status['PENDING'] = true;
	}elseif ($order['order_status'] == 'DELIVERED') {
		$o_status['DELIVERED'] = true;
	}elseif ($order['order_status'] == 'PROCESSING') {
		$o_status['PROCESSING'] = true;
	}elseif ($order['order_status'] == 'CANCELED') {
		$o_status['CANCELED'] = true;
	}
}
?>
<div class="col-xs-12">
	<table class="table">
		<tr>
			<th>Order Reference Id</th>
			<td>{{$order['order_ref_id']}}</td>
			<th>Customer</th>
			<td>{{$order['customer']['name'] or ''}}&nbsp;&nbsp;&nbsp;<b>Ph:</b>{{$order['customer']['phone_no'] or ''}}</td>
		</tr>
		<tr>
			<td colspan=4>
				{!! Form::textarea('remarks', null, ['class' => 'form-control','placeholder' => 'write some remarks...','rows'=>3]) !!}
			</td>
		</tr>
		<tr>
			<th>Deliver At</th>
			<td>
				<div class="input-group input-group-sm">
					{!! Form::text('deliver_at_date', null, ['class' => 'input-sm datepicker','placeholder'=>'Enter Date']) !!}{!! Form::text('deliver_at_time', null, ['class' => 'input-sm timepicker','placeholder'=>'Enter Time']) !!}
					
				</div>
			</td>
			<th>Order Status</th>
			<td>
				<div class="btn-group btn-radio btn-group-xs" data-toggle="buttons">
					<label class="btn btn-warning">
						{!! Form::radio('order_status','PENDING', $o_status['PENDING'], ['class' => 'form-control']) !!}
					PENDING
					</label>
					<label class="btn btn-success">
						{!! Form::radio('order_status','DELIVERED', $o_status['DELIVERED'], ['class' => 'form-control']) !!}
					DELIVERED
					</label>
					<label class="btn btn-info">
						{!! Form::radio('order_status','PROCESSING', $o_status['PROCESSING'], ['class' => 'form-control']) !!}
					PROCESSING
					</label>
					<label class="btn btn-danger">
						{!! Form::radio('order_status','CANCELED', $o_status['CANCELED'], ['class' => 'form-control']) !!}
					CANCELED
					</label>
				</div>
			</td>
		</tr>
	</table>

	<table class="table table-striped">
		<header>
		<tr>
			<th colspan=2>Product</th>
			<th class="text-right">Quantity</th>
			<th class="text-right">Price</th>
		</tr>
		</header>
		@if(isset($order) && isset($order->orderDetails))
			@define $i = 0
			@foreach($order->orderDetails as $orderDetail)
				<tr>
					<td>{{$i+1}}</td>
					<td>{{$orderDetail['product_name']}}</td>
					<td class="text-right">
						{{$orderDetail['qty']." ". $orderDetail['uom']}}
					</td>
					<td class="text-right">
						{{$orderDetail['price']}}
					</td>
				</tr>			
				@define $i++
			@endforeach
		@else
			<tr>
				<div class="well text-center">No Product in this order.</div>
			</tr>
		@endif
		<footer>
			<tr>
				<th colspan=3 class="text-right">Tax</th>
				<td class="text-right"style="border-top: solid 1px #A4A4A4;">{{$order['tax']}} %</td>
			</tr>
			<tr>
				<th colspan=3 class="text-right">Vat</th>
				<td class="text-right">{{$order['vat']}} %</td>
			</tr>
			<tr>
				<th colspan=3 class="text-right">Total Price</th>
				<td class="text-right">Rs {{$order['total_price']}}</td>
			</tr>
		</footer>
	</table>

<h3>Order Address</h3>
	@if(isset($order) &&  isset($order->addressList) && count($order->addressList)>0)
		@define $i = 0
		@foreach($order->addressList as $address)
			@include('addresses.fields',['address_count'=>$i, 'id' =>$address->id, 'reference_id'=>null,'reference_type'=>null, 'address' => $address])
			@define $i++
		@endforeach
	@else
		@include('addresses.fields',['address_count'=>0, 'id' =>null, 'reference_id'=>null,'reference_type'=>null])
	@endif

	<div class="form-group">
		<div class="btn-group pull-right">
			<a class="btn btn-default" href="#">Cancel</a>
			{!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
		</div>
	</div>
</div>
    {!! Form::close() !!}
@endsection

@section('style-top')
    <link rel="stylesheet" href="{{ asset('plugins/pickadate/css/classic.css')}}" id="theme_base">
    <link rel="stylesheet" href="{{ asset('plugins/pickadate/css/classic.date.css')}}" id="theme_date">
    <link rel="stylesheet" href="{{ asset('plugins/pickadate/css/classic.time.css')}}" id="theme_time">
@stop
@section('script-bottom')
    <script src="{{ asset('plugins/pickadate/js/picker.js')}}"></script>
    <script src="{{ asset('plugins/pickadate/js/picker.date.js')}}"></script>
    <script src="{{ asset('plugins/pickadate/js/picker.time.js')}}"></script>
    <script src="{{ asset('plugins/pickadate/js/legacy.js')}}"></script>
    <script type="text/javascript">
        $(function(){
            $('.timepicker').pickatime({interval: 15});
            $('.datepicker').pickadate();
        });
    </script>
@stop