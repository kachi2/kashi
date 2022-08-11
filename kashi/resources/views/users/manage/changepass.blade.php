@extends('layouts.app')

@section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('settings')}}"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">Change password</h6>
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
          <div class="card user-info-card">
            <div class="card-body p-4 d-flex align-items-center">
              <div class="user-profile mr-3"><img src={{"/images/mmm.png"}} alt=""></div>
              <div class="user-info">
                <p class="mb-0 text-white">{{auth()->user()->name}}</p>
              </div>
            </div>
          </div>
          <!-- User Meta Data-->
          <div class="card user-data-card">
           @if(Session::has('pass'))
        <span class="alert {!! Session::get('alert')!!}"> {!!Session::get('pass')!!}</span>
            @endif
            <div class="card-body">
                <div class="form-group">
               
                {{Form::open(['action'=> 'HomeController@changePassword', 'method' => 'post'])}}
                @csrf
                  <div class="title mb-2"><i class="lni lni-key"></i><span>Old Password</span></div>
                  <input class="form-control @error('oldPassword') is-invalid @enderror"  name="oldPassword" type="password">
                @error('oldPassword')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <div class="title mb-2"><i class="lni lni-key"></i><span>New Password</span></div>
                  <input class="form-control @error('password') is-invalid @enderror" name="password" type="password">
                  @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <div class="title mb-2"><i class="lni lni-key"></i><span>Repeat New Password</span></div>
                  <input class="form-control @error('password_confirmation') is-invalid @enderror"  name="password_confirmation" type="password">
                 @error('password_confirmation')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                  </span>
                  @enderror
                </div>
                <button class="btn btn-success w-100" type="submit">Update Password</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>


@endsection