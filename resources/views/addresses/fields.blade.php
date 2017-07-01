@if(!isset($address))
    @eval($address['address1'] =null)
    @eval($address['address1'] =null )
    @eval($address['address2'] =null )
    @eval($address['city'] =null )
    @eval($address['state'] =null )
    @eval($address['country'] =null)
    @eval($address['pincode'] =null )
@endif
    {!! Form::hidden('address['.$address_count.'][id]', $id) !!}
    {!! Form::hidden('address['.$address_count.'][reference_id]', $reference_id) !!}
    {!! Form::hidden('address['.$address_count.'][reference_type]', $reference_type) !!}
    {!! Form::hidden('address['.$address_count.'][lat]', null) !!}
    {!! Form::hidden('address['.$address_count.'][long]', null) !!}

<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('address['.$address_count.'][address1]', 'Address1:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('address['.$address_count.'][address1]', $address['address1'], ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('address['.$address_count.'][address2]', 'Address2:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('address['.$address_count.'][address2]', $address['address2'], ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('address['.$address_count.'][city]', 'City:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('address['.$address_count.'][city]', $address['city'] , ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('address['.$address_count.'][state]', 'State:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('address['.$address_count.'][state]', $address['state'], ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('address['.$address_count.'][country]', 'Country:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('address['.$address_count.'][country]', $address['country'], ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('address['.$address_count.'][pincode]', 'Pincode:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('address['.$address_count.'][pincode]', $address['pincode'], ['class' => 'form-control']) !!}
    </div>
</div>
