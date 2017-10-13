<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 09/10/17
 * Time: 05:47 م
 */?>


@section('title')
    {{$product->name}}

@endsection
@extends('layouts/template')

@section('content')

    <div class="row">
        <div class="col-sm-4">
            <img src="{{asset('images/products/'.$product->image)}}" class="img-thumbnail" style="margin-top: 10%;margin-bottom: 20%;padding: 5%; width: 100%; height: 80%" id="uploaded_img" alt="Product Image" />

        </div>
        <div class="col-sm-8" >
            <br>
            <h1>{{$product->name}}</h1>
            <h4><i class="fa fa-money" aria-hidden="true"></i> {{$product->price.'    $'}}</h4>
            <br>
                <div class="form-group row">
                    <div class="col-sm-8">
                        {{$product->description}}
                    </div>
                </div>


            <div class="form-group row">
                <label class="col-sm-4 col-form-label col-form-label-lg">
                    <i class="fa fa-tags" aria-hidden="true"></i>
                    Categories</label>
                <div class="col-sm-12">
            @foreach($product->categories as $category)
                    <a href="{{URL::to('category/'.$category->id)}}" style="margin: 5px">
                        <span class="btn btn-primary">
                        <i class="fa fa-tag" aria-hidden="true"></i>
                             {{$category->name}}
                    </span>
                    </a>

                    @endforeach
                </div>
            </div>
        </div>




    </div>
@endsection


@section('scripts')

@endsection