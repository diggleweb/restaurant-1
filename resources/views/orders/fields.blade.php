<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('order_ref_id', 'Order Ref Id:') !!}
	</label>
	<div class="col-sm-9">
	{!! Form::text('order_ref_id', null, ['class' => 'form-control']) !!}
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('customer_id', 'Customer:') !!}
	</label>
	<div class="col-sm-9">
	{!! Form::hidden('customer_id', null) !!}
	<b>Name : </b>{{$order['customer']['name'] or ''}}<b>Phone No : </b>{{$order['customer']['phone_no'] or ''}}
	</div>
</div>

@if(isset($order) && isset($order->orderDetails))
	@define $i = 0
	@foreach($order->orderDetails as $orderDetail)
		@include('orderDetails.fields',['orderDetails_count'=>$i, 'id' =>$orderDetail->id, 'order_id'=>$orderDetail->order_id, 'orderDetail' => $orderDetail])
		@define $i++
	@endforeach
@else
	@include('orderDetails.fields',['orderDetails_count'=>0, 'id' =>null, 'order_id'=>null])
@endif
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('tax', 'Tax:') !!}
	</label>
	<div class="col-sm-9">
	{!! Form::text('tax', null, ['class' => 'form-control']) !!}
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('vat', 'Vat:') !!}
	</label>
	<div class="col-sm-9">
	{!! Form::text('vat', null, ['class' => 'form-control']) !!}
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('total_price', 'Total Price:') !!}
	</label>
	<div class="col-sm-9">
	{!! Form::text('total_price', null, ['class' => 'form-control']) !!}
	</div>
</div>

@if(isset($order) && isset($order->addressList) && count($store->addressList)>0)
	@define $i = 0
	@foreach($order->addressList as $address)
		@include('addresses.fields',['address_count'=>$i, 'id' =>$address->id, 'reference_id'=>null,'reference_type'=>null, 'address' => $address])
		@define $i++
	@endforeach
@else
	@include('addresses.fields',['address_count'=>0, 'id' =>null, 'reference_id'=>null,'reference_type'=>null])
@endif

<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('deliver_at', 'Deliver At:') !!}
	</label>
	<div class="col-sm-9">
	{!! Form::text('deliver_at', null, ['class' => 'form-control']) !!}
	</div>
</div>
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('remarks', 'Remarks:') !!}
	</label>
	<div class="col-sm-9">
	{!! Form::text('remarks', null, ['class' => 'form-control']) !!}
	</div>
</div>


<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('order_status', 'Order Status:') !!}
	</label>
	<div class="col-sm-9">
	{!! Form::text('order_status', null, ['class' => 'form-control']) !!}
	</div>
</div>


<div class="form-group">
	<div class="btn-group pull-right">
		<a class="btn btn-default" href="#">Cancel</a>
		{!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
	</div>
</div>