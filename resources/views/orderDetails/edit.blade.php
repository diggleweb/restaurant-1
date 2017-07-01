@extends('app')

@section('content')

    @include('common.errors')

    {!! Form::model($orderDetail, ['route' => ['orderDetails.update', $orderDetail->id], 'method' => 'patch', 'class' => 'form-horizontal']) !!}

        @include('orderDetails.fields')

    {!! Form::close() !!}
@endsection
