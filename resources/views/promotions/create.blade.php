@extends('layouts.admin')
@section('title', 'Promotion')

@section('content')

    @include('common.errors')

    {!! Form::open(['route' => 'admin.promotions.store', 'class' => 'form-horizontal','enctype' => 'multipart/form-data']) !!}

        @include('promotions.fields')

    {!! Form::close() !!}
@endsection
