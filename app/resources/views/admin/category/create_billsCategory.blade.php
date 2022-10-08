@extends('layouts.admin')
@section('content')


  <div class="page-body">

            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-6">
                        @include('includes.message')
                            <div class="page-header-left">
                                <h5>Add Category
                                </h5>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ol class="breadcrumb pull-right">
                                <li class="breadcrumb-item"><a href="index.html"><i data-feather="home"></i></a></li>
                                <li class="breadcrumb-item">Dashboard</li>
                                <li class="breadcrumb-item active">Add Bills Category</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row product-adding">
                    <div class="col-xl-6">
                     {{Form::open(['action' =>'CategoryController@bills_store', 'method'=>'POST','enctype'=>'multipart/form-data', 'accept-charset'=>'UTF-8' ])}}
                        <div class="card">
                            <div class="card-body">
                             <div class="digital-add needs-validation">
                                    <div class="form-group">
                                        <label for="validationCustom01" class="col-form-label pt-0"><span>*</span> Category Name</label>
                                        <input class="form-control" name="name" placeholder="enter category name" value="{{old('name')}}"id="validationCustom01" type="text" required="">
                                    </div>
                                <label class="d-block" for="edo-ani1">
                                               Select Image
                                </label>
                            <input class="btn btn-primary" type="file" name="image" class="file-upload-field">
                            

                                </div>
                                
                            </div>
                             <div class="form-group mb-0">
                                        <div class="product-buttons text-center">
                                            <input type="submit" class="btn btn-primary" value="Submit">
                                           <a href="/index"> <button type="button" class="btn btn-light">Cancel</button></a>
                                        </div>
                                    </div>
                                    {{Form::close()}}
                        </div>
                    </div>
                   
                </div>
            </div>
            <!-- Container-fluid Ends-->

        </div>
        
@endsection