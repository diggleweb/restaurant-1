@extends('layouts.admin')
@section('title', 'Procuct Categories')
@section('breadcrumbs')
    {!! Breadcrumbs::render('ProductCategories') !!}
@stop
@section('top-menu')
    <li><a href="{!! route('admin.productCategories.index') !!}" class="btn btn-primary">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        back to Product Categories</a>
    </li>
    <li><a href="{!! route('admin.products.index') !!}">Procuct</a></li>
    <li class="active"><a href="{!! route('admin.productCategories.index') !!}">Procuct Categories</a></li>
    <li><a href="{!! route('admin.uoms.index') !!}">UOM</a></li>
@stop
@section('content')

    @include('common.errors')

    {!! Form::model($productCategory, ['route' => ['admin.productCategories.update', $productCategory->id], 'method' => 'patch', 'class' => 'form-horizontal']) !!}

        @include('productCategories.fields')

    {!! Form::close() !!}
@endsection
