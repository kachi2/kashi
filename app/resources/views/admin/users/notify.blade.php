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
                     {{Form::open(['action' =>'AdminController@push_notify', 'method'=>'POST','enctype'=>'multipart/form-data', 'accept-charset'=>'UTF-8' ])}}
                        <div class="card">
                            <div class="card-body">
                             <div class="digital-add needs-validation">
                                    <div class="form-group">
                                        <label for="validationCustom01" class="col-form-label pt-0"><span>*</span>Header</label>
                                        <input class="form-control" name="name" placeholder="Enter notification header" value="{{old('topic')}}"id="validationCustom01" type="text" required="">
                                    </div>
                                </div>
                            </div>
                        </div>
                  
                        <div class="card">
                            <div class="card-header">
                                <h6>Notification Message</h6>
                            </div>
                            <div class="card-body">
                                <div class="digital-add needs-validation">
                                    <div class="form-group mb-0">
                                        <div class="description-sm">
                                            <textarea  name="message" placeholder="Enter Message" cols="10" rows="4"> {{old('message')}}</textarea>
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