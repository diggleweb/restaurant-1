@extends('layouts.admin')
@section('title', 'Edit Store Categories')
@section('breadcrumbs')
    {!! Breadcrumbs::render('StoreCategories') !!}
@stop
@section('top-menu')
    <li><a href="{!! route('admin.storeCategories.index') !!}" class="btn btn-primary">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        back to Store Categories</a>
    </li>
    <li><a href="{!! route('admin.stores.index') !!}">Store</a></li>
    <li class="active"><a href="{!! route('admin.storeCategories.index') !!}">Store Category</a></li>
@stop


@section('content')

    @include('common.errors')

    {!! Form::open(['route' => 'admin.storeCategories.store', 'class' => 'form-horizontal','enctype' => 'multipart/form-data']) !!}

        @include('storeCategories.fields')

    {!! Form::close() !!}
@endsection
