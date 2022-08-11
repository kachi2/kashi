    @extends('layouts.app')
    @section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('home')}}"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">Edi Product</h6>
        </div>
        <!-- Navbar Toggler-->
        <div class="suha-navbar-toggler d-flex justify-content-between flex-wrap" id="suhaNavbarToggler"><span></span><span></span><span></span></div>
      </div>
    </div>

@endsection
  @section('content')

    <div class="page-content-wrapper">
      <!-- Top Products-->
      <div class="top-products-area pt-3">
        <div class="container">
          <div class="section-heading d-flex align-items-center justify-content-between">
            <h6 class="ml-1">Edit Product</h6>
          </div>
          <div class="row">
            <!-- Single Weekly Product Card-->
          <div class="card user-data-card">
            <div class="card-body">
              {{Form::open(['action'=> ['vendorsController@products_update', $products->id], 'method'=>'post', 'enctype'=>'multipart/form-data'])}}
                <div class="form-group">
                  <div class="title mb-2"><span>Select Category</span></div>
                  <Select class="form-control"  name="category" id="catid">
                  <option value="{{$products->Category->id}}">{{$products->Category->name}}</option> 
                  @foreach ($category as $cat )
                      <option value="{{$cat->id}}">{{$cat->name}}</option> 
                  @endforeach
                 
                  </Select>
                </div>
                 <div class="form-group">
                  <div class="title mb-2"><span>Select Sub Category</span></div>
                  <Select class="form-control @error('sub_category') is-invalid @enderror" name="sub_category" id="subcat">
                  <option value="{{$products->subcat->id}}"> {{$products->subcat->name}}</option>
                  </Select>
                   @error('sub_category')
               <span class="invalid-feedback" role="alert"> 
               <strong> {{$message}}</strong>
               </span>
                @enderror
                </div>
                
                <div class="form-group">
                  <div class="title mb-2"><span>Product Name</span></div>
                  <input class="form-control @error('name') is-invalid @enderror"  value="{{$products->name}}" type="text" name="name" placeholder="product name" autocomplete="off">
                @error('name')
               <span class="invalid-feedback" role="alert"> 
               <strong> {{$message}}</strong>
               </span>
                @enderror
               
                </div>
              
                <div class="form-group">
                  <div class="title mb-2"><span>Color</span></div>
                  <select class="form-control @error('color') is-invalid @enderror" name="color" required>
                   <option value="{{$products->color_id}}">{{$products->color->name}}</option>
                  @foreach ($colors as $color )
                      <option value="{{$color->id}}">{{$color->name}}</option>
                  @endforeach
                  </select>
                    <span style="font-size:12px"> Not Here?</span> <input type="checkbox" id="newcolor">
                  <p hidden id="showcolor"> Add your Color: <input class="form-control" type="text" name="colorNew" placeholder="Enter color name" autocomplete="off"></p>
                   @error('color')
               <span class="invalid-feedback" role="alert"> 
               <strong> {{$message}}</strong>
               </span>
                @enderror
                </div>
               

                <div class="form-group">
                  <div class="title mb-2"><span>Condition</span></div>
                  <Select class="form-control" name="condtn">
                   <option value="{{$products->is_new}}">{{$products->is_new == 1? 'New' : 'Used'}}</option>
                  <option value="1">New</option>
                   <option value="0">Used</option>
                  </Select>
                </div>
                <div class="form-group">
                  <div class="title mb-2"><span>Price</span></div>
                  <input class="form-control @error('price') is-invalid @enderror"  value="{{$products->price}}" type="text" name="price" placeholder="0.00" autocomplete="off">
                    @error('price')
               <span class="invalid-feedback" role="alert"> 
               <strong> {{$message}}</strong>
               </span>
                @enderror  
                  <div class="p-1"></div>
                  <span style="font-size:12px"> Discount Price? </span> <input type="checkbox" id="hasdis">
                  <div class="p-1"></div>
                  <p hidden id="discount"> Sale Price: <input class="form-control" type="text" value="{{$products->sale_price > 0? $products->sale_price: '0.00'}}" name="sale_price" placeholder="0.00" autocomplete="off"></p>
              
                </div>
      
                <div class="form-group">
                  <div class="title mb-2"><span>Descriptions</span></div>
                  <textarea id="description"  class="form-control @error('description') is-invalid @enderror" name="description" cols="30" rows="5" 
                              placeholder="Enter Product description">{{$products->description}}</textarea>
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
                   <div class=""><img src="{{asset('/images/products/'.$products->cover_image)}}" width="50px" height="50px" alt=""></div>
                
                 <input type="file" name="image" class="btn btn-primary  @error('image') is-invalid @enderror"  value="{{old('image')}}" >                         
                @error('image')
               <span class="invalid-feedback" role="alert"> 
               <strong> {{$message}}</strong>
               </span>
                @enderror
                 
                  </div>
               <label> Change Slide Images</label>
               <div class="form-group">
               @php 

            $image = json_decode($products->gallery);

               @endphp
               <div class="">
               @if($image != null)
               @foreach($image as $images)
  <img src="{{asset('/images/products/'.$images)}}" width="50px" height="50px" alt="">
                
               @endforeach
               </div>
               @endif
              <input type="file" name="images[]" multiple id="images[]" class="btn btn-primary @error('images') is-invalid @enderror"  value="{{old('images')}}">                
                @error('images')
               <span class="invalid-feedback" role="alert"> 
               <strong> {{$message}}</strong>
               </span>
                @enderror
                        </div>
                </div>
                <button class="btn btn-primary btn-lg w-100" id="post" type="submit">Update Item</button>
              {{Form::close()}}
            </div>  
       
          </div>

        </div>
        <div class="p-1"></div>
        
      </div>
    </div>


    @endsection


    
@section('script')
<script>

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
          document.getElementById('post').readOnly = true;
    });


      $('#catid').on('click', function(){

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