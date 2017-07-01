<div class="form-group">
	<label class="col-sm-3 control-label">
	{!! Form::label('description', 'Description:') !!}
	</label>
    <div class="col-sm-9">
    {!! Form::textarea('description', null, ['class' => 'form-control','row'=>5]) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">
    {!! Form::label('images', 'Images:') !!}
    </label>
    <div class="col-sm-9">
    @if(isset($promotion) && isset($promotion->mediaList))
        <div class="row">
            <div class="col-sm-12">
                <input type="file" name="images[]" id="images" multiple="true" class="form-control"/>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 thumb-list">
                @foreach($promotion->mediaList as $media)
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
