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
                                <h5>Edit Sub-Category
                                </h5>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ol class="breadcrumb pull-right">
                                <li class="breadcrumb-item"><a href="index.html"><i data-feather="home"></i></a></li>
                                <li class="breadcrumb-item">Dashboard</li>
                                <li class="breadcrumb-item active">Edit SUb-Category</li>
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
                    @foreach ($category as $cats )
                        
                  
                     {{Form::open(['action' =>['CategoryController@update', $cats->id], 'method'=>'POST','enctype'=>'multipart/form-data', 'accept-charset'=>'UTF-8' ])}}
                        <div class="card">
                            <div class="card-body">
                             <div class="digital-add needs-validation">
                                   
                                      <div class="form-group">
                                        <label for="validationCustom01" class="mb-1"> Parent Category Name</label>
                                        <select name="category_id" class="custom-select col-md-7"> 
                                        <option value="{{$cats->category->id}}">{{$cats->category->name}}</option>
                                            @foreach ($category as $cat )
                                        <option value="{{ $cat->id}}">{{ $cat->name}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                     <div class="form-group">
                                        <label for="validationCustom01" class="col-form-label pt-0"><span>*</span> Sub Category Name</label>
                                        <input class="form-control" name="name" placeholder="enter category name" value="{{$cats->name}}" id="validationCustom01" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label"><span>*</span> Status</label>
                                        <div class="m-checkbox-inline mb-0 custom-radio-ml d-flex radio-animated">
                                            <label class="d-block" for="edo-ani">
                                            
                                                <input class="radio_animated" id="edo-ani" type="radio" name="status" value="1" @if($cats->is_active == 1)  checked @endif/>
                                                Active
                                            </label>
                                            <label class="d-block" for="edo-ani1">
                                                <input class="radio_animated" id="edo-ani1" type="radio" name="status" value="0" @if($cats->is_active == 0) checked @endif />
                                                In-active
                                            </label>
                                        </div>
                                    </div>
 
                                <label class="d-block" for="edo-ani1">
                                               Select Image
                                </label>
                            <input class="btn btn-primary" type="file" value="{{$cats->image}}" name="image" class="file-upload-field">
                            

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h6>Sub Category Description</h6>
                            </div>
                            <div class="card-body">
                                <div class="digital-add needs-validation">
                                    <div class="form-group mb-0">
                                        <div class="description-sm">
                                            <textarea  name="description" placeholder="Enter category description" cols="10" rows="4">{{$cat->description}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                    <div class="form-group mb-0">
                                        <div class="product-buttons text-center">
                                            <input type="submit" class="btn btn-primary" value="Update">
                                           <a href="/index"> <button type="button" class="btn btn-light">Cancel</button></a>
                                        </div>
                                    </div>
                                    {{Form::hidden('_method', 'PUT')}}
                                    {{Form::close()}}
                            </div>
                              @endforeach
                        </div>
                      
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->

        </div>
        
@endsection