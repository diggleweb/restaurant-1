@extends('app')

@section('content')

    @include('common.errors')

    {!! Form::model($media, ['route' => ['media.update', $media->id], 'method' => 'patch', 'class' => 'form-horizontal']) !!}

        @include('media.fields')

    {!! Form::close() !!}
@endsection
