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
                                <h5>Add Product</h5>
                            </div>
                            <div class="card-body">
                                <div class="digital-add needs-validation">
                                {{Form::open(['action'=> 'ProductController@store', 'method'=>'post', 'enctype'=>'multipart/form-data', 'accept-charset'=>'UTF-8'])}}
                                    <div class="form-group">
                                        <label for="validationCustom01" class="col-form-label pt-0"><span>*</span>Product Name</label>
                                        <input class="form-control" value="{{old('name')}}" name="name" id="validationCustom01" type="text" required="">
                                    </div>
                                        <div class="form-group">
                                        <label class="col-form-label"><span>*</span> Product Brand</label>
                                        <select name="brand" value="{{old('brand')}}" class="custom-select">
                                         <option value="">--Select--</option>
                                          @foreach ($brands as $brand)
                                                 <option value="{{$brand->id}}">{{$brand->name}}</option>
                                            @endforeach
                                        </select>
                                        Add New Brand: <input class="form-group" type="text" name="brandNew">
                                    </div>

                                    <div class="form-group">
                                        <label for="validationCustomtitle" class="col-form-label pt-0"><span>*</span> Product Color</label>
                                        <input class="form-control" value="{{old('color')}}" name="color" id="validationCustomtitle" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label for="validationCustomtitle" class="col-form-label pt-0"><span>*</span> Product weight</label>
                                        <input class="form-control" value="{{old('weight')}}" name="weight" id="validationCustomtitle" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label"><span>*</span> Product Categories</label>
                                        <select name="category" value="{{old('category')}}" class="custom-select" required="">
                                         <option value="">--Select--</option>
                                          @foreach ($category as $cat)
                                        <optgroup label="{{$cat->name}}">  
                                         @foreach ($cat->subcat as $key => $ca)
                                                 <option value="{{$ca->id}}">{{$ca->name}}</option>
                                                 @endforeach 
                                            </optgroup>
                                            @endforeach
                                        </select>
                                    </div>

                                     <div class="form-group">
                                        <label class="col-form-label"><span>*</span>Condition</label>
                                        <select name="condtn"  class="custom-select" required="">
                                         <option value="">--Select--</option>     
                                        <option value="1">New</option>
                                        <option value="2">Used</option>       
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="validationCustom02" class="col-form-label"><span>*</span>Price</label>
                                        <input class="form-control" value="{{old('price')}}" name="price" id="validationCustom02" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="validationCustom02" class="col-form-label"><span>*</span> Sale Price</label>
                                        <input class="form-control" value="{{old('sale_price')}}" name="sale_price" id="validationCustom02" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="validationCustom02" class="col-form-label"><span>*</span> Quantity</label>
                                        <input class="form-control" value="{{old('qty')}}" name="qty" id="validationCustom02" type="text" required="">
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
                                <h5>Add Images</h5>
                            </div>
                            <div class="card-body">Add Cover Image
                                <div class="digital-add needs-validation">
                                    <div class="form-group">
                                    <input type="file" name="image" class="btn btn-primary" >
                                    </div>
                                    <label> Add More Images</label>
                                    <div class="form-group">
                                    <input type="file" name="images[]" multiple id="images[]" class="btn btn-primary">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Add Description</h5>
                            </div>
                            <div class="card-body">
                                <div class="digital-add needs-validation">
                                    <div class="form-group mb-0">
                                        <div class="description-sm">
                                                     <textarea id="description" name="description" cols="10" 

                                            placeholder="Enter Product description">{{old('description')}}</textarea>
                                                   <script>
                        CKEDITOR.replace( 'description' );
                        CKEDITOR.replace( 'description', {
        skin: 'moonocolor,/myskins/moonocolor/kama'
} );
                </script> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <div class="card">
                            <div class="card-header">
                                <h5>Add Specifications</h5>
                            </div>
                            <div class="card-body">
                                <div class="digital-add needs-validation">
                                    <div class="form-group mb-0">
                                        <div class="description-sm">
                                            <textarea id="editor1" name="specification" cols="10" 

                                            placeholder="Enter Product Specification">{{old('specification')}}</textarea>
                                                   <script>
                        CKEDITOR.replace( 'specification' );
                </script>
                                        </div>
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