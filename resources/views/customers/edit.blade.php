@extends('layouts.admin')
@section('title', 'Edit Customer')
@section('breadcrumbs')
    {!! Breadcrumbs::render('Customer') !!}
@stop
@section('top-menu')
    <li><a href="{!! route('admin.customers.index') !!}" class="btn btn-primary">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        back to Customer List</a>
    </li>
@stop

@section('content')

    @include('common.errors')

    {!! Form::model($customer, ['route' => ['admin.customers.update', $customer->id], 'method' => 'patch', 'class' => 'form-horizontal']) !!}

        @include('customers.fields')

    {!! Form::close() !!}
@endsection
