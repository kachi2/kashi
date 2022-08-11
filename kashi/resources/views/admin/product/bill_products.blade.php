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
                                <h5>Add Product
                                </h5>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ol class="breadcrumb pull-right">
                                <li class="breadcrumb-item"><a href="index.html"><i data-feather="home"></i></a></li>
                                <li class="breadcrumb-item">Dashboard</li>
                                <li class="breadcrumb-item active">Add Product</li>
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
                        <div class="card">
                            <div class="card-header">
                                <h5>Add Bill Product</h5>
                            </div>
                            <div class="card-body">
                                <div class="digital-add needs-validation">
                                {{Form::open(['action'=> 'ProductController@create_Bills', 'method'=>'post', 'enctype'=>'multipart/form-data', 'accept-charset'=>'UTF-8'])}}
                                    <div class="form-group">
                                        <label for="validationCustom01" class="col-form-label pt-0"><span>*</span>Product Name</label>
                                        <input class="form-control" value="{{old('name')}}" name="name" id="validationCustom01" type="text" required="">
                                    </div>
                                     <div class="form-group">
                                        <label for="validationCustom01" class="col-form-label pt-0"><span>*</span>Slug</label>
                                        <input class="form-control" value="{{old('slug')}}" name="slug" id="validationCustom01" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label"><span>*</span>Bill category</label>
                                        <select name="bill_category" value="{{old('bill_category')}}" class="custom-select">
                                         <option value="">--Select--</option> 
                                         @foreach ($bill_category as $cat )

                                        <option value="{{ $cat->id}}">{{$cat->name}}</option> 

                                         @endforeach
                                          
                                        </select>
                                     </div>
                                 
                                      <div class="form-group">
                                        <label class="col-form-label"><span>*</span>Editable Price</label>
                                        <select name="price_editable" value="{{old('price_editable')}}" class="custom-select">
                                        
                                         <option value="">--Select--</option> 
                                         
                                        <option value="1">yes</option> 
                                         <option value="0">No</option> 
                                       
                                        
                                        </select>
                                     </div>

                                    <div class="form-group">
                                        <label for="validationCustomtitle" class="col-form-label pt-0"><span>*</span>Service ID</label>
                                        <input class="form-control" value="{{old('servide_id')}}" name="service_id" id="validationCustomtitle" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label for="validationCustomtitle" class="col-form-label pt-0"><span>*</span>Min Amount</label>
                                        <input class="form-control" value="{{old('min_amount')}}" name="min_amount" id="validationCustomtitle" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label"><span>*</span> Max Amount</label>
                                        <input name="max_amount" value="{{old('max_amount')}}" class="custom-select" required="">
                                       
                                    </div>

                                     <div class="form-group">
                                        <label class="col-form-label"><span>*</span>Commission Type</label>
                                        <select name="commission_type"  class="custom-select" required="">
                                         <option value="">--Select--</option>     
                                        <option value="flat">Flat</option>
                                        <option value="percentage">percentage</option>       
                                        </select>
                                    </div>

                                     <div class="form-group">
                                        <label class="col-form-label"><span>*</span>Commission</label>
                                        <input name="commission" value="{{old('commission')}}" class="custom-select" required="">
                                       
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="validationCustom02" class="col-form-label"><span>*</span>Convinience Fee</label>
                                        <input class="form-control" value="{{old('convinience_fee')}}" name="convinience_fee" id="validationCustom02" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label"><span>*</span> Status</label>
                                        <div class="m-checkbox-inline mb-0 custom-radio-ml d-flex radio-animated">
                                            <label class="d-block" for="edo-ani">
                                                <input class="radio_animated" id="edo-ani" value="1" type="radio" name="status">
                                                Enable
                                            </label>
                                            <label class="d-block" for="edo-ani1">
                                                <input class="radio_animated" id="edo-ani1" value="0" type="radio" name="status">
                                                Disable
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                    <div class="card">
                            <div class="card-header">
                                <h5>Add Image</h5>
                            </div>
                            <div class="card-body">Add Cover Image
                                <div class="digital-add needs-validation">
                                    <div class="form-group">
                                    <input type="file" name="image" class="btn btn-primary" >
                                    </div>
                                </div>
                            </div>
                        </div>
                           <div class="card">
                            <div class="card-body">
                                <div class="digital-add needs-validation">
                                    
                                    <div class="form-group mb-0">
                                        <div class="product-buttons text-center">
                                            <button type="submit" class="btn btn-primary btn-lg">Add</button>
                                            <a href="{{route('products.index')}}"><button type="button" class="btn btn-light btn-lg">Discard</button></a>
                                        </div>
                                        {{Form::close()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    
                        
                
            </div>
            <!-- Container-fluid Ends-->

        </div>
        
@endsection