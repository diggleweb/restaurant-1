@extends('app')

@section('content')


        <div class="row">
            <h1 class="pull-left">Addresses</h1>
            <a class="btn btn-primary pull-right" style="margin-top: 25px" href="{!! route('addresses.create') !!}">Add New</a>
        </div>

        <div class="row">
            @if($addresses->isEmpty())
                <div class="well text-center">No Addresses found.</div>
            @else
                <table class="table">
                    <thead>
                    <th>Reference Id</th>
			<th>Reference Type</th>
			<th>Lat</th>
			<th>Long</th>
			<th>Address1</th>
			<th>Address2</th>
			<th>City</th>
			<th>State</th>
			<th>Country</th>
			<th>Pincode</th>
                    <th width="50px">Action</th>
                    </thead>
                    <tbody>
                     <tr>
    {!! Form::open(['route' => 'addresses.index', 'method' => 'get', 'class' => "form-inline", 'id' => "search_form"]) !!}

        

<!--- Reference Id Field --->
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('reference_id', 'Reference Id:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('reference_id', null, ['class' => 'form-control']) !!}
    </div>
</div>



<!--- Reference Type Field --->
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('reference_type', 'Reference Type:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('reference_type', null, ['class' => 'form-control']) !!}
    </div>
</div>



<!--- Lat Field --->
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('lat', 'Lat:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('lat', null, ['class' => 'form-control']) !!}
    </div>
</div>



<!--- Long Field --->
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('long', 'Long:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('long', null, ['class' => 'form-control']) !!}
    </div>
</div>



<!--- Address1 Field --->
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('address1', 'Address1:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('address1', null, ['class' => 'form-control']) !!}
    </div>
</div>



<!--- Address2 Field --->
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('address2', 'Address2:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('address2', null, ['class' => 'form-control']) !!}
    </div>
</div>



<!--- City Field --->
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('city', 'City:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('city', null, ['class' => 'form-control']) !!}
    </div>
</div>



<!--- State Field --->
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('state', 'State:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('state', null, ['class' => 'form-control']) !!}
    </div>
</div>



<!--- Country Field --->
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('country', 'Country:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('country', null, ['class' => 'form-control']) !!}
    </div>
</div>



<!--- Pincode Field --->
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('pincode', 'Pincode:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('pincode', null, ['class' => 'form-control']) !!}
    </div>
</div>



        <td>
            <button onclick="return $('#search_form').submit()" class="btn btn-primary">
                <i class="glyphicon glyphicon-search"></i>
            </button>
        </td>

    {!! Form::close() !!}
</tr>
                    @foreach($addresses as $address)
                        <tr>
                            <td>{!! $address->reference_id !!}</td>
					<td>{!! $address->reference_type !!}</td>
					<td>{!! $address->lat !!}</td>
					<td>{!! $address->long !!}</td>
					<td>{!! $address->address1 !!}</td>
					<td>{!! $address->address2 !!}</td>
					<td>{!! $address->city !!}</td>
					<td>{!! $address->state !!}</td>
					<td>{!! $address->country !!}</td>
					<td>{!! $address->pincode !!}</td>
                            <td>
                                <a href="{!! route('addresses.edit', [$address->id]) !!}"><i class="glyphicon glyphicon-edit"></i></a>
                                <a href="{!! route('addresses.delete', [$address->id]) !!}" onclick="return confirm('Are you sure wants to delete this Address?')"><i class="glyphicon glyphicon-remove"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        {!! $addresses->render() !!}
@endsection