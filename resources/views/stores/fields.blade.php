<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('store_category_id', 'Store Category:') !!}
	</label>
    <div class="col-sm-9">
        {!! Form::select('store_category_id', $storeCategoryList, null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('name', 'Name:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('description', 'Description:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('start_time', 'Start Time:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('start_time', null, ['class' => 'form-control timepicker']) !!}
    </div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('end_time', 'End Time:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::text('end_time', null, ['class' => 'form-control timepicker']) !!}
    </div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('delivery_time', 'Delivery Time:') !!}
	</label>
    <div class="col-sm-9">
        <div class="input-group">
            {!! Form::text('delivery_time', null, ['class' => 'form-control']) !!}
            <span class="input-group-addon">minute</span>
        </div>
    </div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('tax', 'Tax:') !!}
	</label>
    <div class="col-sm-9">
        <div class="input-group">
        {!! Form::text('tax', null, ['class' => 'form-control']) !!}
        <span class="input-group-addon">%</span>
        </div>
    </div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('vat', 'Vat:') !!}
	</label>
    <div class="col-sm-9">
        <div class="input-group">
        {!! Form::text('vat', null, ['class' => 'form-control']) !!}
        <span class="input-group-addon">%</span>
        </div>
    </div>
</div>


<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('images', 'Images:') !!}
	</label>
    <div class="col-sm-9">
    @if(isset($store) && isset($store->mediaList))
        <div class="row">
            <div class="col-sm-12">
                <input type="file" name="images[]" id="images" multiple="true" class="form-control"/>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 thumb-list">
                @foreach($store->mediaList as $media)
                <div class="col-xs-6 col-sm-4 col-md-3 thumbnail">
                    <div class="btn btn-group btn-group-xs">
                        <a href="{{ asset($media->path) }}" class="btn btn-default" target="_blank">
                            <span class="glyphicon glyphicon-eye-open"></span>
                        </a>
                        <a href="{!! route('admin.media.delete',$media->id) !!}" onclick="return confirm('Are you sure wants to delete this Media?')" class="btn btn-danger">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    </div>
                    <img src="{{ asset($media->path) }}" class="img-responsive">
                </div>
                @endforeach
            </div>
        </div>
    @else
        <input type="file" name="images[]" id="images" multiple="true" class="form-control"/>
    @endif
    </div>
</div>
@if(isset($store) && isset($store->addressList) && count($store->addressList)>0)
    @define $i = 0
    @foreach($store->addressList as $address)
        @include('addresses.fields',['address_count'=>$i, 'id' =>$address->id, 'reference_id'=>null,'reference_type'=>null, 'address' => $address])
        @define $i++
    @endforeach
@else
    @include('addresses.fields',['address_count'=>0, 'id' =>null, 'reference_id'=>null,'reference_type'=>null])
@endif
<div class="form-group">
    <div class="btn-group pull-right">
        <a class="btn btn-default" href="{!! route('admin.stores.index') !!}">Cancel</a>
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>
</div>

@section('style-top')
    <link rel="stylesheet" href="{{ asset('plugins/pickadate/css/classic.css')}}" id="theme_base">
    <link rel="stylesheet" href="{{-- asset('plugins/pickadate/css/classic.date.css')--}}" id="theme_date">
    <link rel="stylesheet" href="{{ asset('plugins/pickadate/css/classic.time.css')}}" id="theme_time">
@stop
@section('script-bottom')
    <script src="{{ asset('plugins/pickadate/js/picker.js')}}"></script>
    <script src="{{-- asset('plugins/pickadate/js/picker.date.js')--}}"></script>
    <script src="{{ asset('plugins/pickadate/js/picker.time.js')}}"></script>
    <script src="{{ asset('plugins/pickadate/js/legacy.js')}}"></script>
    <script type="text/javascript">
        $(function(){
            $('.timepicker').pickatime({interval: 15});
        });
    </script>
@stop