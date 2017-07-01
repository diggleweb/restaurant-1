@extends('app')

@section('content')

    @include('common.errors')

    {!! Form::open(['route' => 'addresses.store', 'class' => 'form-horizontal']) !!}
		<!--- Submit Field --->
		<div class="form-group">
		    <div class="btn-group pull-right">
		        <a class="btn btn-default" href="#">Cancel</a>
		        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
		    </div>
		</div>
        @include('addresses.fields')
    {!! Form::close() !!}
@endsection
