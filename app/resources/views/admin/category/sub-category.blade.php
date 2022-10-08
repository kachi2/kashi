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
                                <div class="btn-popup pull-right">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-original-title="test" data-target="#exampleModal">Add Sub Category</button>
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title f-w-600" id="exampleModalLabel">Add sub Category</h5>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                   {{Form::open(['action' =>'CategoryController@store', 'method'=>'POST','enctype'=>'multipart/form-data', 'accept-charset'=>'UTF-8' ])}}
                                                        <div class="form">
                                                            <div class="form-group">
                                                                <label for="validationCustom01" class="mb-1"> Parent Category Name</label>
                                                                <select name="category_id" class="custom-select col-md-7"> 
                                                                 @foreach ($category as $cats )
                                                                <option value="{{ $cats->id}}">{{ $cats->name}}</option>
                                                                @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="validationCustom01" class="mb-1">Sub Category Name</label>
                                                                <input class="form-control" name="name" id="validationCustom01" type="text">
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <label for="validationCustom02"  class="mb-1">Image</label>
                                                                <input class="form-control btn btn-primary"  name="image" id="validationCustom02" type="file">
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-primary" type="submit">Save</button>
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                               <div class="table-responsive">
        <table class="table table-striped table-bordered" id="table2">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Parent Category</th>
                                        <th>Sub Category Name</th>
                                        <th>Image</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                   @foreach ($sub as $cats )
                                    <tr>
                                        <td>{{$cats->id}}</td>
                                         <td>{{$cats->category->name}}</td>
                                        <td>{{$cats->name}}</td>
                                        <td><img width="50px" width="50px" src="{{asset('images/category/'.$cats->image)}}"></td>
                                        <td>{{$cats->created_at->format('d-m-yy')}}</td>
                                        <td>
                                                   {{Form::open(['action'=> ['CategoryController@edit_sub', $cats->id], 'method'=>'get'])}}
                                    <button type="submit" value=""class="btn btn-primary btn-xs">Edit</button>
                                                     {{Form::close()}}
                                                   {{Form::open(['action'=> ['CategoryController@delete', $cats->id], 'method'=>'POST'])}}
                                         <button onclick="return confirm('Are you sure')" name="delete" class="btn btn-danger btn-xs">Delete</button>
                                         {{Form::hidden('_method', 'DELETE')}}
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