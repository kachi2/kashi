
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
 <link rel="icon" href="img/core-img/favicon.ico">
    <!-- Stylesheet-->
    <!-- Styles -->
    <link href="{{asset('/frontend/style.css') }}" rel="stylesheet">
    <style>
    .field-icon {
  float: right;
  margin-left: -15px;
  margin-top: -50px;
  position: relative;
  z-index: 2;
}
    </style>
</head>
<body>
 <!-- Preloader-->
    <div class="preloader" id="preloader">
      <div class="spinner-grow text-secondary" role="status">
        <div class="sr-only">Loading...</div>
      </div>
    </div>
    <!-- Sidenav Black Overlay-->
    <div class="sidenav-black-overlay"></div>
    <!-- Side Nav Wrapper-->
    <div class="suha-sidenav-wrapper" id="sidenavWrapper">
      <!-- Sidenav Profile-->
      <!-- Go Back Button-->
      <div class="go-home-btn" id="goHomeBtn"><i class="lni lni-arrow-left"></i></div>
    </div>
<div class="login-wrapper d-flex align-items-center justify-content-center text-center">
      <!-- Background Shape-->
      <div class="background-shape"></div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-sm-9 col-md-7 col-lg-6 col-xl-5"><img src="{{asset('/images/icons/lolj.png')}}" width="90px" height="74px" alt="payM logo">
            <!-- Register Form-->
            <div class="register-form mt-5 px-4">
             <form method="POST" action="{{ route('register_user') }}">
                        @csrf
                <div class="form-group text-left mb-4"><span>Name</span>
                  <label for="username"><i class="lni lni-user"></i></label>
                  <input class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" name="name" id="username" type="text" placeholder="full name"  autocomplete="off">
                              @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                </div>
              
                <div class="form-group text-left mb-4"><span>Email</span>
                  <label for="email"><i class="lni lni-envelope"></i></label>
                  <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email')}}" type="email" placeholder="example@email.com" placeholder="user@example.com" autocomplete="off">
                  @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                </div>
                 <div class="form-group text-left mb-4"><span>Phone</span>
                  <label for="email"><i class="lni lni-phone"></i></label>
                  <input class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{old('phone')}}" type="text" maxlength="11" placeholder="08030000000" autocomplete="off">
                   @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                </div>
                <div class="form-group text-left mb-4"><span>Password</span>
                  <label for="password"><i class="lni lni-lock"></i></label>
                  <div class="input-group mb-2">
                  <input class="input-psswd form-control @error('password') is-invalid @enderror" name="password" id="registerassword" type="password" placeholder="********************" autocomplete="off">                  
              <div class="input-group-append">
                  <span class=" input-group-text " style="color:#fff; padding:10px; background:none; border-bottom:1px solid #ffffee1c" onclick="myFunction()"><i class="fa fa-fw fa-eye"></i>View</span>
                </div>                
                </div>
                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </span>
              <script>
                function myFunction() {
            var x = document.getElementById("registerassword");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
            }
            </script>
            
                </div >
                <button class="btn btn-success btn-lg w-100" type="submit">Register Now</button>
              </form>
            </div>
            <!-- Login Meta-->
            <div class="login-meta-data">
              <p class="mt-3 mb-0">Already have an account?<a class="ml-1" href="{{route('login')}}">Login</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="{{asset('/frontend/js/jquery.min.js')}}"></script>
    <script src="{{asset('/frontend/js/popper.min.js')}}"></script>
    <script src="{{asset('/frontend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('/frontend/js/waypoints.min.js')}}"></script>
    <script src="{{asset('/frontend/js/jquery.easing.min.js')}}"></script>
    <script src="{{asset('/frontend/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('/frontend/js/jquery.animatedheadline.min.js')}}"></script>
    <script src="{{asset('/frontend/js/jquery.counterup.min.js')}}"></script>
    <script src="{{asset('/frontend/js/wow.min.js')}}"></script>
    <script src="{{asset('/frontend/js/jarallax.min.js')}}"></script>
    <script src="{{asset('/frontend/js/jarallax-video.min.js')}}"></script>
    <script src="{{asset('/frontend/js/default/jquery.passwordstrength.js')}}"></script>
    <script src="{{asset('/frontend/js/default/dark-mode-switch.js')}}"></script>
    <script src="{{asset('/frontend/js/default/active.js')}}"></script>
