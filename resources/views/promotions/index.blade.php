@extends('layouts.admin')
@section('title', 'Promotion')
@section('top-menu')
    <li><a class="btn btn-primary" href="{!! route('admin.promotions.create') !!}">Add New</a></li>
@stop
@section('content')
        <div class="row">
            @if($promotions->isEmpty())
                <div class="well text-center">No Promotions found.</div>
            @else
                <table class="table table-hover">
                    <thead>
                    <th>Description</th>
                    <th width="50px">Action</th>
                    </thead>
                    <tbody>
                    @foreach($promotions as $promotion)
                        <tr>
                            <td>{!! $promotion->description !!}</td>
                            <td>
                                <a href="{!! route('admin.promotions.edit', [$promotion->id]) !!}"><i class="glyphicon glyphicon-edit"></i></a>
                                <a href="{!! route('admin.promotions.delete', [$promotion->id]) !!}" onclick="return confirm('Are you sure wants to delete this Promotion?')"><i class="glyphicon glyphicon-remove"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        {!! $promotions->render() !!}
@endsection