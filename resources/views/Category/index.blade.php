@section('title')
    All Categories
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
                        <h3 class="panel-title">Categories </h3>
                    </div>
                    <div class="col col-xs-6 text-right">
                        <a href="{{URL::to('category/create')}}" type="button" class="btn btn-sm btn-primary btn-create">Add New Category</a>
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
                       
                        <th>Description</th>
                        <th>Products</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($Categories) && $Categories->count())
                        @foreach($Categories as $cat )
                            <tr>
                                <td style="float: left" align="center">
                                    <a href="{{route('category.edit', $cat->id )}}" class="btn btn-default"><em class="fa fa-pencil"></em></a>

                                    {{Form::open([ 'method'  => 'delete', 'route' => [ 'category.destroy', $cat->id ]])}}
                                        <button type="submit" class="btn btn-danger"><em class="fa fa-trash"></em></button>
                                    {{Form::close()}}
                                </td>
                                <td class="hidden-xs">{{$cat->id}}</td>
                                <td>{{$cat->name}}</td>

                                <td>{{$cat->description}}</td>
                                <td>
                                    <ul>
                                    @foreach($cat->products as $product)
                                        <li>
                                            {{$product->name}}
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
                {!! $Categories->render() !!}

            </div>



        </div>

    </div>
    <!-- /.row -->

@endsection


@include('layouts/template')
