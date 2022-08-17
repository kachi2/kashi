<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="keywords" content="paym.com.ng, buy airtime, buy cheap data, buy power">
  <meta name="author" content="paym.com.ng">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
 
  <meta name="description" content="paym.com.ng Platform for quick purchase of Airtime, Internet Data Bundles, DSTV, GOTV, PHCN and payment for other services in Nigeria">
        
  <meta name="keywords" content="paym.com.ng  - Buy airtime online, buy MTN airtime, buy internet data subscription, Etisalat Glo Airtel Airtime, DSTV payment,GOTV payment,PHCN payment">

<meta name="google-site-verification" content="" />
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-TLBPPT4');</script>
  <!-- End Google Tag Manager -->

  <title> @if(isset($title)) {{$title}} @else Home  @endif | {{config('app.name')}}</title>
  
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>payM - Buy, Sell at Ease</title>
    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
 <link rel="icon" href="img/core-img/favicon.ico">
 <script src="https://cdn.ckeditor.com/4.14.0/basic/ckeditor.js"></script>
    <!-- Stylesheet-->
    <!-- Styles -->
    <link href="{{asset('/frontend/style.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
  @laravelPWA

</head>
<body>

    
  
    @yield('navigation')
      
    <!-- Sidenav Black Overlay-->
    <div class="sidenav-black-overlay"></div>
    <!-- Side Nav Wrapper-->
    <div class="suha-sidenav-wrapper" id="sidenavWrapper">
      <!-- Sidenav Nav-->
      @guest

 <ul class="sidenav-nav">
        <li><a href="{{route('register')}}"><i class="lni lni-user"></i>Register</a></li>
        <li><a href="{{route('login')}}"><i class="lni lni-user"></i>Login</a></li>
        
         </ul>
      @else
      <div class="sidenav-profile">
        <div class="user-profile"><img src="{{asset('/images/mmm.png')}}" alt="paym logo"></div>
        <div class="user-info">
        @php 
        $tt = explode(" ", auth()->user()->name);
        $name = $tt[0];
        @endphp
          <h6 class="user-name mb-0">{{strtoupper($name)}}</h6>
         <a href="{{route('my_wallet')}}" class="available-balance">Wallet: <span>₦<span class="counter">{{number_format(auth()->user()->wallet,2)}}</span></span>
        <br><span class="btn btn-success">View</span>
        </a>
        </div>
      </div>
      <ul class="sidenav-nav">
        <li><a href="{{route('profile')}}"><i class="lni lni-user"></i>My Profile</a></li>
        @if(auth()->user()->level == 2)
        <li><a href="{{route('shops.index')}}"><i class="lni lni-files"></i>My Shop</a></li>
        @endif

        <li><a href="{{route('notifications')}}"><i class="lni lni-alarm lni-tada-effect"></i>Notifications<span class="ml-3 badge badge-warning">{{auth()->user()->notifyCount}}</span></a></li>
        <li><a href="{{route('transactions')}}"><i class="lni lni-stats-up"></i>Transactions</a></li>
        <li><a href="{{route('my-orders')}}"><i class="lni lni-folder"></i>My Orders</a></li>
        <li><a href="{{route('my-referrals')}}"><i class="lni lni-users"></i>My Referrals</a></li>
        <li><a href="{{route('settings')}}"><i class="lni lni-cog"></i>Settings</a></li>
        <li><a class="" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                      
                                  <i class="lni lni-power-switch"></i>Sign Out
                                    </a></li>
                                    
                                
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
         </ul>
         @endguest
      <!-- Go Back Button-->
      <div class="go-home-btn" id="goHomeBtn"><i class="lni lni-arrow-left"></i></div>
    </div>
    
@yield('content')
 @include('sweet::alert')

    <div class="footer-nav-area" id="footerNav">
        <div class="internet-connection-status __web-inspector-hide-shortcut__" id="internetStatus"></div>
<!-- Footer Nav-->
      <div class="container h-100 px-0">
          
        <div class="suha-footer-nav h-100" >
            
          <ul class="h-100 d-flex align-items-center justify-content-between">
              
              @guest 
           <li class="active"><a href="{{route('home')}}"><i class="lni lni-home"></i>Home</a></li>
            <li><a href="{{route('carts.index')}}"><span style="color:red" class="cartReload">@if(Cart::count() > 0){{Cart::count()}} @endif</span><i class="lni lni-shopping-basket"> </i>Cart</a></li>
           <li><a href="{{route('transactions')}}"><i class="lni lni-stats-up"></i>History</a></li>
            <li><a href="{{route('profile')}}"><i class="lni lni-user"></i>Account</a></li>
            <li><a href="{{route('settings')}}"><i class="lni lni-cog"></i>Settings</a></li>
            @else
            @if(auth()->user()->level == 2)
           <li class="active"><a href="{{route('home')}}"><i class="lni lni-home"></i>Home</a></li>
            <li><a href="{{route('carts.index')}}"><span style="color:red" class="cartReload">@if(Cart::count() > 0){{Cart::count()}} @endif</span><i class="lni lni-shopping-basket"> </i>Cart</a></li>
            <li ><a class="btn-primary p-2" style="bottom:15px; font-size:20px; border-radius:15px; color:#fff" href="{{route('shops-sell')}}"><i class="lni lni-camera"></i>SELL</a></li>
            <li><a href="{{route('transactions')}}"><i class="lni lni-stats-up"></i>History</a></li>
            <li><a href="{{route('settings')}}"><i class="lni lni-cog"></i>Settings</a></li>
            @else
          <li class="active"><a href="{{route('home')}}"><i class="lni lni-home"></i>Home</a></li>
           <li><a href="{{route('carts.index')}}"><span style="color:red" class="cartReload">@if(Cart::count() > 0){{Cart::count()}} @endif</span><i class="lni lni-shopping-basket"> </i>Cart</a></li>
            <li><a href="{{route('transactions')}}"><i class="lni lni-stats-up"></i>History</a></li>
            <li><a href="{{route('profile')}}"><i class="lni lni-user"></i>Account</a></li>
            <li><a href="{{route('settings')}}"><i class="lni lni-cog"></i>Settings</a></li>
            @endif
             @endguest
          </ul>
     
        </div>
      </div>
      
    </div>
    <!-- All JavaScript Files-->
  
 
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
    <script src="{{asset('/frontend/js/default/no-internet.js')}}"></script>
    <script src="{{asset('/frontend/js/pwa.js')}}"></script>
   
 
   @yield('script')

</body>
</html>
