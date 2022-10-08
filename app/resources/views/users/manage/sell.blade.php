@extends('layouts.app')


@section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('home')}}"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">Add product</h6>
        </div>
        <!-- Navbar Toggler-->
        <div class="suha-navbar-toggler d-flex justify-content-between flex-wrap" id="suhaNavbarToggler"><span></span><span></span><span></span></div>
      </div>
    </div>

@endsection
@section('content')

 <div class="page-content-wrapper">
      <div class="container">
        <!-- Profile Wrapper-->
        
              @if(!$shops)

               {{Form::open(['action'=> 'vendorsController@add_shops', 'method' => 'get'])}}
         <div style="padding:10px"></div>
        <div class="card user-data-card">
            <div class="card-body">
               <div class="single-settings d-flex align-items-center justify-content-between">
                <div class="title"><span class=" ">You currently do not have any shop yet</span></div>
                <div class="data-content">
                  <div class="toggle-button-cover">
                    
                    
                  
                  </div>
                </div>
                
              </div>
              
            </div>
           
             <button type="submit" class="btn btn-primary p-2 "> Add New Shop</button>
             {{Form::close()}}
          </div>
          @else
              <div class="profile-wrapper-area py-3">
          <!-- User Information-->
          <div style="btn btn-primary" class="card user-info-card">
            <div class="card-body p-4 d-flex align-items-center">
              <div class="user-info">
                <h5 style="color:#fff" class="mb-0">Post Product</h5>
              </div>
            </div>
          </div>
    
          <!-- User Meta Data-->
          <div class="card user-data-card">
            <div class="card-body">
              {{Form::open(['action'=> 'vendorsController@products_store', 'method'=>'post', 'enctype'=>'multipart/form-data'])}}
                <div class="form-group">
                  <div class="title mb-2"><span>Select Category</span></div>
                  <Select class="form-control"  name="category" id="catid" required>
                  <option>Select Category</option> 
                  @foreach ($category as $cat )
                      <option value="{{$cat->id}}">{{$cat->name}}</option> 
                  @endforeach
                 
                  </Select>
                </div>
                 <div class="form-group">
                  <div class="title mb-2"><span>Select Sub Category</span></div>
                  <Select class="form-control @error('sub_category') is-invalid @enderror" value="{{old('sub_category')}}" name="sub_category" id="subcat">
                  <option> Select Sub Category</option>
                  </Select>
                   @error('sub_category')
               <span class="invalid-feedback" role="alert"> 
               <strong> {{$message}}</strong>
               </span>
                @enderror
                </div>
                
                <div class="form-group">
                  <div class="title mb-2"><span>Product Name</span></div>
                  <input class="form-control @error('name') is-invalid @enderror"  value="{{old('name')}}" type="text" name="name" placeholder=" Enter Product name" autocomplete="off">
                @error('name')
               <span class="invalid-feedback" role="alert"> 
               <strong> {{$message}}</strong>
               </span>
                @enderror
               
                </div>
              
                <div class="form-group" id="colors">
                  <div class="title mb-2"><span>Color</span></div>
                  <select class="form-control @error('color') is-invalid @enderror" value="{{old('color')}}" name="color">
                   <option value="0"> Select Color </option>
                  @foreach ($colors as $color )
                      <option value="{{$color->id}}">{{$color->name}}</option>
                  @endforeach
                  </select>
                    <span style="font-size:12px"> Not Here?</span> <input type="checkbox" id="newcolor">
                  <p id="showcolor"> Add your Color: <input class="form-control" type="text" value="{{old('newColor')}}" name="colorNew" placeholder="Enter color name" autocomplete="off"></p>
                   @error('color')
               <span class="invalid-feedback" role="alert"> 
               <strong> {{$message}}</strong>
               </span>
                @enderror
                </div>
                <div class="form-group" id="condition">
                  <div class="title mb-2"><span>Condition</span>
                  </div>
                  <span style="font-size:9px">*Select if Item is NEW or USED item </span>
                  <Select class="form-control" name="condtn">
                         
                      <option value ='0'>Select Condition</option>
                  <option value="1">New</option>
                   <option value="0">Used</option>
                  </Select>
                </div>
                <div class="form-group">
                  <div class="title mb-2"><span>Price</span></div>
                  <input class="form-control @error('price') is-invalid @enderror"  value="{{old('price')}}" type="text" name="price" placeholder="0.00" autocomplete="off">
                    @error('price')
               <span class="invalid-feedback" role="alert"> 
               <strong> {{$message}}</strong>
               </span>
                @enderror  
                  <div class="p-1"></div>
                  <span style="font-size:12px"> Discount Price? </span> <input type="checkbox" id="hasdis">
                  <div class="p-1"></div>
                  <p hidden id="discount"> Sale Price: <input class="form-control" type="text" name="sale_price" placeholder="0.00" autocomplete="off"></p>
              
                </div>
      
                <div class="form-group">
                  <div class="title mb-2"><span>Descriptions</span></div>
                  <textarea id="description"  class="form-control @error('description') is-invalid @enderror" name="description" cols="30" rows="5" 
                              placeholder="Enter Product description">{{old('description')}}</textarea>
                  <script>
                        CKEDITOR.replace( 'description' );
                        CKEDITOR.replace( 'description', {
               skin: 'moonocolor,/myskins/moonocolor/kama'
                        } );
                </script>
                 @error('description')
               <span class="invalid-feedback" role="alert"> 
               <strong> {{$message}}</strong>
               </span>
                @enderror
                </div>
             
                <div class="form-group">
                 <input type="file" name="image" class="btn btn-primary  @error('image') is-invalid @enderror"  value="{{old('image')}}" >                         
                @error('image')
               <span class="invalid-feedback" role="alert"> 
               <strong> {{$message}}</strong>
               </span>
                @enderror
                  </div>
                <label> Add Slide Images</label>
               <div class="form-group">
              <input type="file" name="images[]" multiple id="images[]" class="btn btn-primary @error('images') is-invalid @enderror"  value="{{old('images')}}">                
                @error('images')
               <span class="invalid-feedback" role="alert"> 
               <strong> {{$message}}</strong>
               </span>
                @enderror
                        </div>
                </div>
                <button class="btn btn-primary btn-lg w-100" id="post"  type="submit">Submit</button> 
              {{Form::close()}}
              
            </div>
            @endif
          </div>
         
        </div>
      </div>
    </div>
     <div class="p-2"></div>


@endsection


@section('script')
<script>
 $(document).ready(function(){
  $(window).on('load', function(){

    document.getElementById('showcolor').hidden = true;
      document.getElementById('showbrand').hidden = true;

  });
 });

    $('#hasdis').on('change', function(){
      document.getElementById('discount').hidden = false;
      if(document.getElementById('hasdis').checked == false){
        document.getElementById('discount').hidden = true;
      }
      
    });
       $('#newBrand').on('change', function(){
      document.getElementById('showbrand').hidden = false;
      if(document.getElementById('newBrand').checked == false){
        document.getElementById('showbrand').hidden = true;
      }
      
    });

        $('#newcolor').on('change', function(){
      document.getElementById('showcolor').hidden = false;
      if(document.getElementById('newcolor').checked == false){
        document.getElementById('showcolor').hidden = true;
      }
      
    });

    $('#post').on('click', function(){
        
          $('#post').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Please wait...'); 
          $('#post').attr('readOnly', true);
    });

      $('#catid').on('change', function(){

        var cat = $('#catid').val();
            $.ajaxSetup({
              headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }

            })
          $.ajax({
              url: "{{route('sub-cat')}}",
              type: "get",
              data:  {
              cat: cat,
              cache:false
              },
              dataType: "json",
                success:function(response){
                  var options = '';
                 console.log(response);
                  $.each(response, function(key, value){
                   options += '<option value=" '+value.id+'">'+value.name+'</option>';
                  });
                   $('#subcat').empty(options);
                   $('#subcat').append(options);
                  
                }      
          });
});


</script>

@endsection