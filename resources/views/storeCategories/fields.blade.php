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
	{!! Form::label('display_mode', 'Display Mode:') !!}
	</label>
	<div class="col-sm-9">
	{{-- Form::text('display_mode', null, ['class' => 'form-control']) --}}
		<div class="btn-group btn-radio" data-toggle="buttons">
		  <label class="btn btn-default">
		  	{!! Form::radio('display_mode','STORE', null, ['class' => 'form-control']) !!}
			<!-- <input type="radio" name="display_mode" id="option1" value='STORE' autocomplete="off" checked>  -->
			Store Wish Display
		  </label>
		  <label class="btn btn-default">
		  	{!! Form::radio('display_mode','PRODUCT', null, ['class' => 'form-control']) !!}
			<!-- <input type="radio" name="display_mode" id="option2" value='PRODUCT' autocomplete="off">  -->
			 Product Wish Display
		  </label>
		</div>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('images', 'Images:') !!}
	</label>
    <div class="col-sm-9">
    @if(isset($storeCategory) && isset($storeCategory->mediaList))
        <div class="row">
            <div class="col-sm-12">
                <input type="file" name="images[]" id="images" multiple="true" class="form-control"/>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 thumb-list">
                @foreach($storeCategory->mediaList as $media)
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
<div class="form-group">
	<div class="btn-group pull-right">
		<a class="btn btn-default" href="#">Cancel</a>
		{!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
	</div>
</div>
