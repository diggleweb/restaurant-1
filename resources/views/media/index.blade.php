@extends('app')

@section('content')


        <div class="row">
            <h1 class="pull-left">Media</h1>
            <a class="btn btn-primary pull-right" style="margin-top: 25px" href="{!! route('media.create') !!}">Add New</a>
        </div>

        <div class="row">
            @if($media->isEmpty())
                <div class="well text-center">No Media found.</div>
            @else
                <table class="table">
                    <thead>
                    <th>Reference Id</th>
			<th>Reference Type</th>
			<th>Media Type</th>
			<th>Path</th>
                    <th width="50px">Action</th>
                    </thead>
                    <tbody>
                     <tr>
    {!! Form::open(['route' => 'media.index', 'method' => 'get', 'class' => "form-inline", 'id' => "search_form"]) !!}

        

<!--- Reference Id Field --->
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('reference_id', 'Reference Id:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('reference_id', null, ['class' => 'form-control']) !!}
    </div>
</div>



<!--- Reference Type Field --->
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('reference_type', 'Reference Type:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('reference_type', null, ['class' => 'form-control']) !!}
    </div>
</div>



<!--- Media Type Field --->
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('media_type', 'Media Type:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('media_type', null, ['class' => 'form-control']) !!}
    </div>
</div>



<!--- Path Field --->
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('path', 'Path:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('path', null, ['class' => 'form-control']) !!}
    </div>
</div>



        <td>
            <button onclick="return $('#search_form').submit()" class="btn btn-primary">
                <i class="glyphicon glyphicon-search"></i>
            </button>
        </td>

    {!! Form::close() !!}
</tr>
                    @foreach($media as $media)
                        <tr>
                            <td>{!! $media->reference_id !!}</td>
					<td>{!! $media->reference_type !!}</td>
					<td>{!! $media->media_type !!}</td>
					<td>{!! $media->path !!}</td>
                            <td>
                                <a href="{!! route('media.edit', [$media->id]) !!}"><i class="glyphicon glyphicon-edit"></i></a>
                                <a href="{!! route('media.delete', [$media->id]) !!}" onclick="return confirm('Are you sure wants to delete this Media?')"><i class="glyphicon glyphicon-remove"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        {!! $media->render() !!}
@endsection