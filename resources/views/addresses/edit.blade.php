@extends('app')

@section('content')

    @include('common.errors')

    {!! Form::model($address, ['route' => ['addresses.update', $address->id], 'method' => 'patch', 'class' => 'form-horizontal']) !!}

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
