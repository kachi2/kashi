@extends('layouts.admin')
@section('content')
<div class="page-body">

            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="page-header-left">
                                <h4>Category
                                </h4>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ol class="breadcrumb pull-right">
                                <li class="breadcrumb-item"><a href="index.html"><i data-feather="home"></i></a></li>
                                <li class="breadcrumb-item">Dashbhoard</li>
                                <li class="breadcrumb-item active">Category</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->

            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                    @include('includes.message')
                        <div class="card">
                            <div class="card-body">
                               
                               <div class="table-responsive">
        <table class="table table-striped table-bordered" id="table2">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product Name</th>
                                        <th>Image</th>
                                        <th>Sub Categories</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                   @foreach ($products as $pro )
                                       
                           
                                    <tr>
                                        <td>{{$pro->id}}</td>
                                        <td>{{$pro->name}}</td>
                                        <td><img width="50px" width="50px" src="{{asset('images/products/'.$pro->cover_image)}}"></td>
                                        <td>                               
                                             <p>{{$pro->category->name}}</p>
                                                       
                                        </td>
                                        <td>{{$pro->created_at}}</td>
                                        <td>
                                        {{Form::open(['action'=> ['ProductController@edit', $pro->id], 'method'=>'get'])}}
                                          <button class="btn btn-primary btn-xs">Edit</button>
                                          {{Form::close()}}
                                           {{Form::open(['action'=> ['ProductController@destroy', $pro->id], 'method'=>'POST'])}}
                                         <button onclick="return confirm('Are you sure you want to delete this')" class="btn btn-danger btn-xs">Delete</button>
                                         {{Form::hidden('_method', 'DELETE')}}
                                          {{Form::close()}}
                                          </td> 
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                    <div> {{$products->links()}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>


@endsection
