@extends('layouts.admin')

@section('title', 'Create Store')
@section('breadcrumbs')
    {!! Breadcrumbs::render('Home') !!}
@stop
@section('top-menu')
    <li><a href="{!! route('admin.stores.index') !!}" class="btn btn-primary">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        back to Store</a>
    </li>
    <li class="active"><a href="{!! route('admin.stores.index') !!}">Store</a></li>
    <li><a href="{!! route('admin.storeCategories.index') !!}">Store Category</a></li>
@stop

    
@section('content')

    @include('common.errors')

    {!! Form::open(['route' => 'admin.stores.store', 'class' => 'form-horizontal','enctype' => 'multipart/form-data']) !!}

        @include('stores.fields')

    {!! Form::close() !!}

@endsection