<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 08/10/17
 * Time: 03:29 م
 */
?>

@section('title')
    {{($mode=='store')? 'Add New Product' :'Edit Product' }}
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
        <h1>    {{($mode=='store')? 'Add New Product' :'Edit Product' }} </h1>
        <br>
        @if($mode=='store')
            <form action="{{route('product.'.$mode)}}" method="post" enctype="multipart/form-data">
        @else
            <form action="{{route('product.'.$mode, $Product->id)}}" method="post" enctype="multipart/form-data">
                {{ method_field('PUT') }}
        @endif
                {{csrf_field()}}
            <div class="form-group row">

                <label for="parent_id" class="col-sm-4 col-form-label col-form-label-lg">Category</label>
                <div class="col-sm-8">
                    <select class="select2 form-control form-control-lg" name="category_id[]"  multiple required>
                        @foreach($Categories as $category)
                        @if($mode=='update' && isset($prodCategoriesIDs)  && in_array($category->id, $prodCategoriesIDs))
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
                    <input type="text" value="{{($mode=='update')? $Product->name : ''}}" class="form-control form-control-lg" id="name" placeholder="Name" name="name" required>
                </div>

            </div>
            <div class="form-group row">

                <label for="image" class="col-sm-4 col-form-label col-form-label-lg">Image</label>
                <div class="col-sm-8">
                    <input type="file" value="{{($mode=='update')? $Product->image : ''}}" accept="image/*" class="form-control form-control-lg" id="image" placeholder="image" name="image">
                </div>
            </div>
            <div class="form-group row">

                <label for="price" class="col-sm-4 col-form-label col-form-label-lg">Price</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-lg" required id="price" value="{{($mode=='update')? $Product->price : ''}}"
                           onkeypress="return isNumberKey(event)" placeholder="Price" name="price">
                </div>

            </div>
            <div class="form-group row">
                <label for="Description" class="col-sm-4 col-form-label col-form-label-lg">Description</label>
                <div class="col-sm-8">
                    <textarea name="description" value="{{($mode=='update')? $Product->description : ''}}" rows="4" cols="40"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4"></div>
                <input type="submit" class="btn btn-primary">
            </div>
        </form>
    </div>

    <div class="col-sm-4">
            <img src="{{($mode=='update')? asset('images/products/'.$Product->image): ''}}" class="img-thumbnail" style="margin-top: 30%;margin-bottom: 20%;padding: 5%; width: 100%; height: 80%" id="uploaded_img" alt="Product Image" />
    </div>


</div>
@endsection


@section('scripts')
    <script type="application/javascript">
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#uploaded_img').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#image").change(function(){
        readURL(this);
    });
    </script>
@endsection