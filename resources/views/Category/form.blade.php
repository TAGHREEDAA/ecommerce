@section('title')
    {{($mode=='store')? 'Add New Category' :'Edit Category' }}
@endsection
@extends('layouts/template')

@section('content')
    @if(Session::has('flash_message'))
        <div class="alert alert-success">
            {{ Session::get('flash_message') }}
        </div>
        @endif

    <div class="row">

        <div class="col-sm-8" >
            <br>
            <h1>    {{($mode=='store')? 'Add New Category' :'Edit Category' }} </h1>
            <br>
            @if($mode=='store')
                <form action="{{route('category.'.$mode)}}" method="post" enctype="multipart/form-data">
                    @else
                        <form action="{{route('category.'.$mode, $Category->id)}}" method="post" enctype="multipart/form-data">
                            {{ method_field('PUT') }}
                            @endif
                            {{csrf_field()}}
                            <div class="form-group row">

                                <label for="parent_id" class="col-sm-4 col-form-label col-form-label-lg">Main Category</label>
                                <div class="col-sm-8">
                                    <select class="select2 form-control form-control-lg" name="parent_id" required>
                                        @foreach($ParentCategories as $category)
                                            @if($mode=='update' && $category->id == $Category->parent_id))
                                                <option value="{{ $category->id }}" selected="true">{{ $category->name }}</option>
                                            @else
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">

                                <label for="name" class="col-sm-4 col-form-label col-form-label-lg">Name</label>
                                <div class="col-sm-8">
                                    <input type="text" value="{{($mode=='update')? $Category->name : ''}}" class="form-control form-control-lg" id="name" placeholder="Name" name="name" required>
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="Description" class="col-sm-4 col-form-label col-form-label-lg">Description</label>
                                <div class="col-sm-8">
                                    <textarea name="description" value="{{($mode=='update')? $Category->description : ''}}" rows="4" cols="40"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4"></div>
                                <input type="submit" class="btn btn-primary">
                            </div>
                        </form>
        </div>

    </div>
@endsection