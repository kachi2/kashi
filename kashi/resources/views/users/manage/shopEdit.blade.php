@extends('layouts.app')
@section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('home')}}"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">Edit Shops</h6>
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
        <div class="profile-wrapper-area py-3">
          <!-- User Information-->
          <div class=" btn-primary card user-info-card btn-primary">
            <div class="card-body p-4 d-flex align-items-center">
              
              <div class="user-info">
                <h5 class="mb-0" style="color:#fff">Edit Shop</h5>
              </div>
            </div>
          </div>
          <!-- User Meta Data-->
          <div class="card user-data-card">
            <div class="card-body">
              {{Form::open(['action'=> 'vendorsController@update_shops', 'method' => 'post', 'enctype' => 'multipart/form-data' ])}}
                <div class="form-group">
                  <div class="title mb-2"><span>Shop Name</span></div>
                  <input class="form-control @error('name') is-invalid @enderror"  value="{{$shop->name}}" name="name" type="text" placeholder="shop name">
                @error('name')
                <span class="invalid-feedback" role="alert"> <strong> {{$message}}</strong></span>
                @enderror
                </div>
                <div class="form-group">
                  <div class="title mb-2"><span>Email</span></div>
                  <input class="form-control @error('email') is-invalid @enderror" value="{{$shop->email}}" name="email" type="text" placeholder="contact email">
                   @error('email')
                <span class="invalid-feedback" role="alert"> <strong> {{$message}}</strong></span>
                @enderror
                </div>
                <div class="form-group">
                  <div class="title mb-2"><span>Phone</span></div>
                  <input class="form-control @error('name') is-invalid @enderror" name="phone" value="{{$shop->phone}}" type="text" placeholder="contact phone">
                   @error('phone')
                <span class="invalid-feedback" role="alert"> <strong> {{$message}}</strong></span>
                @enderror
                </div>
                <div class="form-group">
                  <div class="title mb-2"><span>Address</span></div>
                 <input class="form-control @error('location') is-invalid @enderror"  value="{{$shop->location}}" name="location" type="text" placeholder="location">
                  @error('location')
                <span class="invalid-feedback" role="alert"> <strong> {{$message}}</strong></span>
                @enderror
                </div>
                <div class="form-group">
                    <img src="{{asset('images/shops/'.$shop->image)}}" height="auto" width="50px">
                  <div class="title mb-2"><span></span></div>
                  <input type="file"  name="image" class=" btn btn-primary @error('image') is-invalid @enderror">
                   @error('image')
                <span class="invalid-feedback" role="alert"> <strong> {{$message}}</strong></span>
                @enderror
                </div>

                </div>
                <button class="btn btn-primary btn-lg w-100" id="post" type="submit">Update Shop        </button>
                
              </form>
            </div>
          </div>
          <div class="p-1"></div>
        </div>
      </div>
    </div>


@endsection


    @section('script')

    <script>
        
         $('#post').on('click', function(){
        
          $('#post').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Please wait...'); 
          document.getElementById('post').readOnly = true;
    });
    </script>

    @endsection
