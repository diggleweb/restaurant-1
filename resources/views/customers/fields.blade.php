<!--- Name Field --->
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('name', 'Name:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!--- Phone No Field --->
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('phone_no', 'Phone No:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('phone_no', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!--- Submit Field --->
<div class="form-group">
    <div class="btn-group pull-right">
        <a class="btn btn-default" href="#">Cancel</a>
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
