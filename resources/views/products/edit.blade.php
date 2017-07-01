@extends('layouts.admin')
@section('title', 'Product')
@section('breadcrumbs')
    {!! Breadcrumbs::render('Product') !!}
@stop
@section('top-menu')
    <li><a href="{!! route('admin.products.index') !!}" class="btn btn-primary">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        back to Product</a>
    </li>
    <li class="active"><a href="{!! route('admin.products.index') !!}">Procuct</a></li>
    <li><a href="{!! route('admin.productCategories.index') !!}">Procuct Categories</a></li>
    <li><a href="{!! route('admin.uoms.index') !!}">UOM</a></li>
@stop
@section('content')

    @include('common.errors')

    {!! Form::model($product, ['route' => ['admin.products.update', $product->id], 'method' => 'patch', 'class' => 'form-horizontal','enctype' => 'multipart/form-data']) !!}

        @include('products.fields')

    {!! Form::close() !!}
@endsection
