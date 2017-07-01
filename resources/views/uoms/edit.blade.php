@extends('layouts.admin')
@section('title', 'Edit UOM')
@section('breadcrumbs')
	{!! Breadcrumbs::render('Uom') !!}
@stop
@section('top-menu')
	<li><a href="{!! route('admin.uoms.index') !!}" class="btn btn-primary">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		back to UOM List</a>
	</li>
	<li><a href="{!! route('admin.products.index') !!}">Procuct</a></li>
	<li><a href="{!! route('admin.productCategories.index') !!}">Procuct Categories</a></li>
	<li class="active"><a href="{!! route('admin.uoms.index') !!}">UOM</a></li>
@stop
@section('content')

    @include('common.errors')

    {!! Form::model($uom, ['route' => ['admin.uoms.update', $uom->id], 'method' => 'patch', 'class' => 'form-horizontal']) !!}

        @include('uoms.fields')

    {!! Form::close() !!}
@endsection
