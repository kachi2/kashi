@extends('layouts.app')

@section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('checkout.index')}}"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">Add Address</h6>
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
          
          <!-- User Meta Data-->
          <div class="card user-data-card">
            <div class="card-body">
              {{Form::open(['action' => 'checkoutController@shipping', 'method'=>'post'])}}
                <div class="form-group">
                  <div class="title mb-2"><i class="lni lni-user"></i><span>Receiver</span></div>
                  <input class="form-control @error('receiver') is-invalid @enderror" type="text" value="{{old('receiver')}}" name="receiver" placeholder="Receiver" autocomplete="off">
                @error('receiver')
                <span class="invalid-feedback" role="alert"> <strong> {{$message}}</strong></span>
                @enderror
                </div>
                <div class="form-group">
                  <div class="title mb-2"><i class="lni lni-phone"></i><span>Phone</span></div>
                  <input class="form-control @error('phone') is-invalid @enderror" value="{{old('phone')}}" type="text" name="phone" placeholder="080 30111 222" autocomplete="off">
                @error('phone')
                <span class="invalid-feedback" role="alert"> <strong> {{$message}}</strong></span>
                @enderror
                </div>
                <div class="form-group">
                  <div class="title mb-2"><i class="lni lni-envelope"></i><span>Email Address</span></div>
                  <input class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" type="email" name="email" placeholder="youremail@example.com" autocomplete="off">
              @error('email')
                <span class="invalid-feedback" role="alert"> <strong> {{$message}}</strong></span>
                @enderror
                </div>
                <div class="form-group">
                  <div class="title mb-2"><i class="lni lni-map-marker"></i><span>Shipping Address</span></div>
                  <input class="form-control @error('address') is-invalid @enderror" value="{{old('address')}}" type="text" name="address" placeholder="Shipping Address" autocomplete="off">
                @error('address')
                <span class="invalid-feedback" role="alert"> <strong> {{$message}}</strong></span>
                @enderror
                </div>
                <div class="form-group">
                  <div class="title mb-2"><i class="lni lni-map-marker"></i><span>State</span></div>
                  <input class="form-control @error('state') is-invalid @enderror" value="{{old('state')}}" type="text" name="state" placeholder="Shipping State" autocomplete="off">
                @error('state')
                <span class="invalid-feedback" role="alert"> <strong> {{$message}}</strong></span>
                @enderror
                </div>
                <button class="btn btn-success w-100" type="submit">Add Shipping Addresss</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection
