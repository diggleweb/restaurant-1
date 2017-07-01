@extends('layouts.admin')

@section('content')

    @include('common.errors')

    {!! Form::open(['route' => 'orderDetails.store', 'class' => 'form-horizontal']) !!}

        @include('orderDetails.fields')

    {!! Form::close() !!}
@endsection
