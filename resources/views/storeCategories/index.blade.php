@extends('layouts.admin')
@section('title', 'Store')
@section('breadcrumbs')
	{!! Breadcrumbs::render('StoreCategories') !!}
@stop
@section('top-menu')
	<li><a href="{!! route('admin.storeCategories.create') !!}" class="btn btn-primary">
		<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
		Add Store Categories</a>
	</li>
	<li><a href="{!! route('admin.stores.index') !!}">Store</a></li>
	<li class="active"><a href="{!! route('admin.storeCategories.index') !!}">Store Category</a></li>
@stop

@section('content')
		<div class="row">
			@if($storeCategories->isEmpty())
				<div class="well text-center">No StoreCategories found.</div>
			@else
				<table class="table table-hover">
					<thead>
					<th>Name</th>
					 <th>Display Mode</th>
					<th width="50px">Action</th>
					</thead>
					<tbody>
					 <tr>
						{!! Form::open(['route' => 'admin.storeCategories.index', 'method' => 'get', 'class' => "form-inline", 'id' => "search_form"]) !!}
							<td>
								{!! Form::text('name', $attributes['name'], ['class' => 'form-control','placeholder'=>'Search by Category Name']) !!}
							</td>
							<td>
								<div class="btn-group" data-toggle="buttons">
								  <label class="btn btn-default {{($attributes['display_mode']=='STORE')?'active':''}}">
									<input type="radio" name="display_mode" id="option1" value='STORE' autocomplete="off" checked> Store Wish Display
								  </label>
								  <label class="btn btn-default {{($attributes['display_mode']=='PRODUCT')?'active':''}}">
									<input type="radio" name="display_mode" id="option2" value='PRODUCT' autocomplete="off">  Product Wish Display
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
					@foreach($storeCategories as $storeCategory)
						<tr>
							<td>{!! $storeCategory->name !!}</td>
							<td>{!! $storeCategory->display_mode !!}</td>
							<td>
								<a href="{!! route('admin.storeCategories.edit', [$storeCategory->id]) !!}"><i class="glyphicon glyphicon-edit"></i></a>
								<a href="{!! route('admin.storeCategories.delete', [$storeCategory->id]) !!}" onclick="return confirm('Are you sure wants to delete this StoreCategory?')"><i class="glyphicon glyphicon-remove"></i></a>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			@endif
		</div>
		{!! $storeCategories->render() !!}
@endsection