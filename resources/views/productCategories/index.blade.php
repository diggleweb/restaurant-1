@extends('layouts.admin')
@section('title', 'Procuct Categories')
@section('breadcrumbs')
    {!! Breadcrumbs::render('ProductCategories') !!}
@stop
@section('top-menu')
    <li><a href="{!! route('admin.productCategories.create') !!}" class="btn btn-primary">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        Add Product Categories</a>
    </li>
    <li><a href="{!! route('admin.products.index') !!}">Procuct</a></li>
    <li class="active"><a href="{!! route('admin.productCategories.index') !!}">Procuct Categories</a></li>
    <li><a href="{!! route('admin.uoms.index') !!}">UOM</a></li>
@stop
@section('content')

        <div class="row">
            @if($productCategories->isEmpty())
                <div class="well text-center">No ProductCategories found.</div>
            @else
                <table class="table table-hover">
                    <thead>
                    <th>Name</th>
                    <th width="50px">Action</th>
                    </thead>
                    <tbody>
                     <tr>
                        {!! Form::open(['route' => 'admin.productCategories.index', 'method' => 'get', 'class' => "form-inline", 'id' => "search_form"]) !!}
                            <td>
                                {!! Form::text('name', null, ['class' => 'form-control','placeholder'=>'Search by Category Name']) !!}
                            </td>
                            <td>
                                <button onclick="return $('#search_form').submit()" class="btn btn-primary">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                            </td>
                            {!! Form::close() !!}
                        </tr>
                    @foreach($productCategories as $productCategory)
                        <tr>
                            <td>{!! $productCategory->name !!}</td>
                            <td>
                                <a href="{!! route('admin.productCategories.edit', [$productCategory->id]) !!}"><i class="glyphicon glyphicon-edit"></i></a>
                                <a href="{!! route('admin.productCategories.delete', [$productCategory->id]) !!}" onclick="return confirm('Are you sure wants to delete this ProductCategory?')"><i class="glyphicon glyphicon-remove"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        {!! $productCategories->render() !!}
@endsection