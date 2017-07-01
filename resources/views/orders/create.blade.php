@extends('layouts.admin')

@section('content')

    @include('common.errors')

    {!! Form::open(['route' => 'admin.orders.store', 'class' => 'form-horizontal']) !!}

        @include('orders.fields')

    {!! Form::close() !!}
@endsection
