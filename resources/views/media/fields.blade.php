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

<!--- Path Field --->
<div class="form-group">
    <label class="col-sm-3 control-label">
    {!! Form::label('file', 'File:') !!}
    </label>
    <div class="col-sm-9">
    {!! Form::file('file', null, ['class' => 'form-control','multiple'=>true]) !!}
    </div>
</div>

<!--- Submit Field --->
<div class="form-group">
    <div class="btn-group pull-right">
        <a class="btn btn-default" href="#">Cancel</a>
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
