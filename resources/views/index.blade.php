<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 07/10/17
 * Time: 08:39 م
 */
?>

@section('title')
Ecommerce Home Page
@endsection

@section('content')
    <div class="row" >

        <div class="col-lg-3">

            <h1 class="my-4">All Categories</h1>
            <div class="list-group categories-list">
                @foreach($Categories as $cat)
                <a class="list-group-item" href="{{route('category.show',$cat->id)}}">{{$cat->name}}</a>
                @endforeach
            </div>

        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-9">

            <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img class="d-block img-fluid" src="{{asset('images/slider/3.jpg')}}" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block img-fluid" src="{{asset('images/slider/2.jpg')}}" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block img-fluid" src="{{asset('images/slider/1.jpg')}}" alt="Third slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

            <div class="row">

                @foreach($Products as $Product)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <a href="{{route('product.show',$Product->id)}}">
                            <img class="card-img-top" src="{{asset('images/products/'.$Product->image)}}" alt="Product image"></a>
                        <div class="card-body">
                            <h4 class="card-title">

                                <a href="{{route('product.edit',$Product->id)}}"><i class="fa fa-pencil fa-xs"></i> {{$Product->name}}</a>
                            </h4>
                            <h5>${{$Product->price}}</h5>
                            <p class="card-text">{{$Product->description}}</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                        </div>
                    </div>
                </div>

                    @endforeach
            </div>
            <!-- /.row -->

        </div>
        <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

@endsection


@include('layouts/template')
