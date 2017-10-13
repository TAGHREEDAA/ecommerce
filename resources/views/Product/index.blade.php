<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 08/10/17
 * Time: 03:29 م
 */?>


@section('title')
    All Products
@endsection

@section('content')
<br>
    <div class="col-md-12">
    @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        @if ($message = Session::get('error'))
                    <div class="alert alert-danger">
                        <p>{{ $message }}</p>
                    </div>
        @endif
        <div class="panel panel-default panel-table">
            <div class="panel-heading">
                <div class="row">
                    <div class="col col-xs-6">
                        <h3 class="panel-title">Products </h3>
                    </div>
                    <div class="col col-xs-6 text-right">
                        <a href="{{URL::to('product/create')}}" type="button" class="btn btn-sm btn-primary btn-create">Add New Product</a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-list">
                    <thead>
                    <tr>
                        <th><em class="fa fa-cog"></em></th>
                        <th class="hidden-xs">ID</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th>Price $</th>
                        <th>Categories</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($Products) && $Products->count())
                        @foreach($Products as $prod )
                            <tr>
                                <td style="float: left" align="center">
                                    <a href="{{route('product.edit', $prod->id )}}" class="btn btn-default">
                                        <em class="fa fa-pencil"></em></a>

                                    {{Form::open([ 'method'  => 'delete', 'route' => [ 'product.destroy', $prod->id ]])}}
                                        <button type="submit" class="btn btn-danger"><em class="fa fa-trash"></em></button>
                                    {{Form::close()}}
                                </td>
                                <td class="hidden-xs">{{$prod->id}}</td>
                                <td>{{$prod->name}}</td>
                                <td>
                                    <img src="{{asset('images/products/'.$prod->image)}}" class="img-rounded" style="border-radius: 50%;height: 70px; width: 70px">
                                </td>
                                <td>{{$prod->description}}</td>
                                <td>{{$prod->price. ' $ '}}</td>
                                <td>
                                    <ul>
                                    @foreach($prod->categories as $category)
                                        <li>
                                            {{$category->name}}
                                        </li>

                                    @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="10">There are no data.</td>
                        </tr>
                    @endif


                    </tbody>
                </table>

            </div>
            <div class="panel-footer">
                {!! $Products->render() !!}

            </div>



        </div>

    </div>
    <!-- /.row -->

@endsection


@include('layouts/template')
