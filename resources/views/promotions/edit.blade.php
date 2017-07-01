@extends('layouts.admin')
@section('title', 'Promotion')

@section('content')

    @include('common.errors')

    {!! Form::model($promotion, ['route' => ['admin.promotions.update', $promotion->id], 'method' => 'patch', 'class' => 'form-horizontal','enctype' => 'multipart/form-data']) !!}

        @include('promotions.fields')

    {!! Form::close() !!}
@endsection
