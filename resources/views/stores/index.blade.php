@extends('layouts.admin')
@section('title', 'Store')
@section('breadcrumbs')
    {!! Breadcrumbs::render('Store') !!}
@stop
@section('top-menu')
    <li><a href="{!! route('admin.stores.create') !!}" class="btn btn-primary">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        Add Store</a>
    </li>
    <li class="active"><a href="{!! route('admin.stores.index') !!}">Store</a></li>
    <li><a href="{!! route('admin.storeCategories.index') !!}">Store Category</a></li>
@stop
@section('content')
        <div class="row">
            @if($stores->isEmpty())
                <div class="alert alert-info">No Stores found.</div>
            @else
                <table class="table table-hover">
                    <thead>
                        <th>Store Category</th>
            			<th>Name</th>
            			<th>OpenTime</th>
            			<th>Delivery Time</th>
            			<th>Tax (in %)</th>
            			<th>Vat (in %)</th>
                        <th width="50px">Action</th>
                    </thead>
                    <tbody>
                     <tr>
                    {!! Form::open(['route' => 'admin.stores.index', 'method' => 'get', 'class' => "form-inline", 'id' => "search_form"]) !!}
                        <td colspan=2>
                            {!! Form::select('store_category_id', $storeCategoryList, $attributes['store_category_id'], ['class' => 'form-control']) !!}
                        </td>
                        <td colspan=4>
                            {!! Form::text('name', $attributes['name'], ['class' => 'form-control','placeholder'=>'Search by Store Name']) !!}
                        </td>
                        <td>
                            <button onclick="return $('#search_form').submit()" class="btn btn-primary">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </td>
                        {!! Form::close() !!}
                    </tr>
                    @foreach($stores as $store)
                        <tr>
                            <td>{!! $store->category->name !!}</td>
        					<td>{!! $store->name !!}</td>
        					<td>{!! $store->start_time !!} to {!! $store->end_time !!}</td>
        					<td>{!! gmdate("H : i", floor($store->delivery_time*60)) !!}</td>
        					<td>{!! $store->tax !!}</td>
        					<td>{!! $store->vat !!}</td>
                            <td>
                                <a href="{!! route('admin.stores.edit', [$store->id]) !!}"><i class="glyphicon glyphicon-edit"></i></a>
                                <a href="{!! route('admin.stores.delete', [$store->id]) !!}" onclick="return confirm('Are you sure wants to delete this Store?')"><i class="glyphicon glyphicon-remove"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        {!! $stores->render() !!}
@endsection