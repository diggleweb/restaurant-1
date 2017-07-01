@extends('app')

@section('content')


        <div class="row">
            <h1 class="pull-left">OrderDetails</h1>
            <a class="btn btn-primary pull-right" style="margin-top: 25px" href="{!! route('orderDetails.create') !!}">Add New</a>
        </div>

        <div class="row">
            @if($orderDetails->isEmpty())
                <div class="well text-center">No OrderDetails found.</div>
            @else
                <table class="table">
                    <thead>
                    <th>Order Id</th>
			<th>Product Id</th>
			<th>Qty</th>
			<th>Uom Id</th>
			<th>Price</th>
                    <th width="50px">Action</th>
                    </thead>
                    <tbody>
                     <tr>
    {!! Form::open(['route' => 'orderDetails.index', 'method' => 'get', 'class' => "form-inline", 'id' => "search_form"]) !!}

        

<!--- Order Id Field --->
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('order_id', 'Order Id:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('order_id', null, ['class' => 'form-control']) !!}
    </div>
</div>



<!--- Product Id Field --->
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('product_id', 'Product Id:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('product_id', null, ['class' => 'form-control']) !!}
    </div>
</div>



<!--- Qty Field --->
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('qty', 'Qty:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('qty', null, ['class' => 'form-control']) !!}
    </div>
</div>



<!--- Uom Id Field --->
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('uom_id', 'Uom Id:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('uom_id', null, ['class' => 'form-control']) !!}
    </div>
</div>



<!--- Price Field --->
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('price', 'Price:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
    </div>
</div>



        <td>
            <button onclick="return $('#search_form').submit()" class="btn btn-primary">
                <i class="glyphicon glyphicon-search"></i>
            </button>
        </td>

    {!! Form::close() !!}
</tr>
                    @foreach($orderDetails as $orderDetail)
                        <tr>
                            <td>{!! $orderDetail->order_id !!}</td>
					<td>{!! $orderDetail->product_id !!}</td>
					<td>{!! $orderDetail->qty !!}</td>
					<td>{!! $orderDetail->uom_id !!}</td>
					<td>{!! $orderDetail->price !!}</td>
                            <td>
                                <a href="{!! route('orderDetails.edit', [$orderDetail->id]) !!}"><i class="glyphicon glyphicon-edit"></i></a>
                                <a href="{!! route('orderDetails.delete', [$orderDetail->id]) !!}" onclick="return confirm('Are you sure wants to delete this OrderDetail?')"><i class="glyphicon glyphicon-remove"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        {!! $orderDetails->render() !!}
@endsection