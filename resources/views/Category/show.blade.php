@section('title')
    {{$category->name}}

@endsection
@extends('layouts/template')

@section('content')

    <div class="row">

        <div class="col-sm-8" >
            <br>
            <h1>{{$category->name}}</h1>
            <br>
                <div class="form-group row">
                    <div class="col-sm-8">
                        <h5>Description</h5>    {{$category->description}}
                    </div>
                </div>


            <div class="form-group row">
                <label class="col-sm-4 col-form-label col-form-label-lg">
                    <i class="fa fa-tags" aria-hidden="true"></i>
                    Products</label>
                <div class="col-sm-12">
                    <ul>
                        @foreach($category->products as $product)
                            <li>
                                <a href="{{URL::to('product/'.$product->id)}}" style="margin: 5px">
                                    <span class="btn btn-primary">
                                        <i class="fa fa-tag" aria-hidden="true"></i>
                                            {{$product->name}}
                                    </span>
                                </a>
                            </li>
                            @endforeach
                    </ul>
                </div>
            </div>
        </div>




    </div>
@endsection


@section('scripts')

@endsection