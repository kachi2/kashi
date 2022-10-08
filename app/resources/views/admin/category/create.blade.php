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
                                <li class="breadcrumb-item active">Add Category</li>
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
                     {{Form::open(['action' =>'CategoryController@store', 'method'=>'POST','enctype'=>'multipart/form-data', 'accept-charset'=>'UTF-8' ])}}
                        <div class="card">
                            <div class="card-body">
                             <div class="digital-add needs-validation">
                                    <div class="form-group">
                                        <label for="validationCustom01" class="col-form-label pt-0"><span>*</span> Category Name</label>
                                        <input class="form-control" name="name" placeholder="enter category name" value="{{old('name')}}"id="validationCustom01" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label"><span>*</span> Status</label>
                                        <div class="m-checkbox-inline mb-0 custom-radio-ml d-flex radio-animated">
                                            <label class="d-block" for="edo-ani">
                                                <input class="radio_animated" value="1" id="edo-ani" type="radio" name="status">
                                                Enable
                                            </label>
                                            <label class="d-block" for="edo-ani1">
                                                <input class="radio_animated" value="0" id="edo-ani1" type="radio" name="status">
                                                Disable
                                            </label>
                                        </div>
                                    </div>
 
                                <label class="d-block" for="edo-ani1">
                                               Select Image
                                </label>
                            <input class="btn btn-primary" type="file" name="image" class="file-upload-field">
                            

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h6>Category Description</h6>
                            </div>
                            <div class="card-body">
                                <div class="digital-add needs-validation">
                                    <div class="form-group mb-0">
                                        <div class="description-sm">
                                            <textarea  name="description" placeholder="Enter category description" cols="10" rows="4"> {{old('description')}}</textarea>
                                        </div>
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
            </div>
            <!-- Container-fluid Ends-->

        </div>
        
@endsection