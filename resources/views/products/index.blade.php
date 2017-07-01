@extends('layouts.admin')
@section('title', 'Product')
@section('breadcrumbs')
	{!! Breadcrumbs::render('Product') !!}
@stop
@section('top-menu')
	<li>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">
			<span class="glyphicon glyphicon-upload" aria-hidden="true"></span>
			Bulk Upload
		</button>
	</li>
	<li><a href="{!! route('admin.products.create') !!}" class="btn btn-primary">
		<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
		Add Product</a>
	</li>
	<li class="active"><a href="{!! route('admin.products.index') !!}">Procuct</a></li>
	<li><a href="{!! route('admin.productCategories.index') !!}">Procuct Categories</a></li>
	<li><a href="{!! route('admin.uoms.index') !!}">UOM</a></li>

@stop
@section('content')
@include('common.errors')
		<div class="row">
			@if($products->isEmpty())
				<div class="well text-center">No Products found.</div>
			@else
				<table class="table table-hover">
					<thead>
					<th>Store Id</th>
					<th>Product Category</th>
					<th>Name</th>
					<th>Description</th>
					<th>Price</th>
					<th width="50px">Action</th>
					</thead>
					<tbody>
					<tr class="search-row">
						{!! Form::open(['route' => 'admin.products.index', 'method' => 'get', 'class' => "form-inline", 'id' => "search_form"]) !!}
							<td width="150px">
								{!! Form::select('store_id',$storeList, $attributes['store_id'], ['class' => 'form-control']) !!}
							</td>
							<td width="150px">
								{!! Form::select('product_category_id', $productCategoryList, $attributes['product_category_id'], ['class' => 'form-control']) !!}
							</td>
							<td>
								{!! Form::text('name', $attributes['name'], ['class' => 'form-control','placeholder'=>'by Name']) !!}
							</td>
							<td>
								{!! Form::text('description', $attributes['description'], ['class' => 'form-control','placeholder'=>'by description']) !!}
							</td>
							<td>
								{!! Form::text('price', $attributes['price'], ['class' => 'form-control','placeholder'=>'by price']) !!}
							</td>
							<td>
								<button onclick="return $('#search_form').submit()" class="btn btn-primary">
									<i class="glyphicon glyphicon-search"></i>
								</button>
							</td>

						{!! Form::close() !!}
					</tr>
					@foreach($products as $product)
						<tr>
							<td>{!! $product->store->name !!}</td>
							<td>{!! $product->category->name !!}</td>
							<td>{!! $product->name !!}</td>
							<td>{!! $product->description !!}</td>
							<td>{!! 'Rs. '.$product->price.'/'.$product->uom->name !!}</td>
							<td>
								<a href="{!! route('admin.products.edit', [$product->id]) !!}"><i class="glyphicon glyphicon-edit"></i></a>
								<a href="{!! route('admin.products.delete', [$product->id]) !!}" onclick="return confirm('Are you sure wants to delete this Product?')"><i class="glyphicon glyphicon-remove"></i></a>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			@endif
		</div>
		{!! $products->render() !!}
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
	{!! Form::open(['route' => 'admin.products.upload', 'enctype' => 'multipart/form-data']) !!}
	<div class="input-group">
		<span class="input-group-btn">
			<a href="{!! asset('upload/sample/product.xlsx') !!}" class="btn btn-default">Download Sample</a>
		</span>
		<input type="file" name="excel" id="excel" class="form-control" placeholder="upload excel file"/>
		<span class="input-group-btn">
			{!! Form::submit('Upload', ['class' => 'btn btn-primary']) !!}
		</span>
    </div>
    {!! Form::close() !!}
    </div>
  </div>
</div>
@endsection
