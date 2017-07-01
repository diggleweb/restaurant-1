@extends('app')

@section('content')

    @include('common.errors')

    {!! Form::open(['route' => 'media.store', 'class' => 'form-horizontal']) !!}

        @include('media.fields')

    {!! Form::close() !!}
@endsection
