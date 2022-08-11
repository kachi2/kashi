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
                                        <th>Category Name</th>
                                        <th>Image</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                   @foreach ($category as $cats )
                                    <tr>
                                        <td>{{$cats->id}}</td>
                                        <td>{{$cats->name}}</td>
                                        <td><img width="50px" width="50px" src="{{asset('images/category/'.$cats->image)}}"></td>
                                        <td>{{$cats->created_at->format('d-m-yy')}}</td>
                                        <td>
                                        {{Form::open(['action'=> ['CategoryController@bill_edit', $cats->id], 'method'=>'get'])}}
                                          <button class="btn btn-primary btn-xs">Edit</button>
                                          {{Form::close()}}
                                           {{Form::open(['action'=> ['CategoryController@bill_destroy', $cats->id], 'method'=>'POST'])}}
                                         <button onclick="return confirm('Are you sure you want to delete this')" class="btn btn-danger btn-xs">Delete</button>
                                          {{Form::close()}}
                                          </td> 
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>


@endsection
