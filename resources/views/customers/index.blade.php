@extends('layouts.admin')
@section('title', 'Customer')
@section('breadcrumbs')
	{!! Breadcrumbs::render('Customer') !!}
@stop
@section('content')

		<div class="row">
			@if($customers->isEmpty())
				<div class="well text-center">No Customers found.</div>
			@else
				<table class="table table-hover">
					<thead>
					<th>Name</th>
					<th>Phone No</th>
					<th>Address</th>
					<th width="50px">Action</th>
					</thead>
					<tbody>
					<tr>
					{!! Form::open(['route' => 'admin.customers.index', 'method' => 'get', 'class' => "form-inline", 'id' => "search_form"]) !!}
						<td colspan=2>
							{!! Form::text('name', $attributes['name'], ['class' => 'form-control','placeholder'=>'Search by Name']) !!}
						</td>
						<td>
							{!! Form::text('phone_no', $attributes['phone_no'], ['class' => 'form-control','placeholder'=>'Search by Phone No']) !!}
						</td>
						<td>
							<button onclick="return $('#search_form').submit()" class="btn btn-primary">
								<i class="glyphicon glyphicon-search"></i>
							</button>
						</td>
						{!! Form::close() !!}
					</tr>
					{{--dd($customers)--}}
					@foreach($customers as $customer)
						<tr>
							<td>{!! $customer->name !!}</td>
							<td>{!! $customer->phone_no !!}</td>
							<td>
								@if(!empty($customer->addressList))
									@foreach($customer->addressList as $address)
									<address>
										{!! preg_replace('/\v+|\\\[rn]/','<br/>', $address->full_address) !!}
										@endforeach
									</address>
								@endif
							</td>
							<td>
								<a href="{!! route('admin.customers.edit', [$customer->id]) !!}"><i class="glyphicon glyphicon-edit"></i></a>
								<a href="{!! route('admin.customers.delete', [$customer->id]) !!}" onclick="return confirm('Are you sure wants to delete this Customer?')"><i class="glyphicon glyphicon-remove"></i></a>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			@endif
		</div>
		{!! $customers->render() !!}
@endsection