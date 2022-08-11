@extends('layouts.app')

    @section('navigation')
  <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Logo Wrapper-->
        <div class="logo-wrapper"><a href="{{route('home')}}"> <img src="{{asset('/images/icons/lolj.png')}}" width="55px" height="54px" alt="payM logo"></a></div>
        <!-- Search Form-->
        <div class="top-search-form">
          <form action="{{route('search-results')}}" method="get">
            <input class="form-control" name="search" type="search" placeholder="Search products, brands..">
            <button type="submit"><i class="fa fa-search"></i></button>
          </form>
        </div>
        <!-- Navbar Toggler-->
        <div class="suha-navbar-toggler d-flex flex-wrap" id="suhaNavbarToggler"><span></span><span></span><span></span></div>
      </div>
    </div>

@section('content')

     <div class="page-content-wrapper">
      <div class="container">
        <!-- Offline Area-->
        <div class="offline-area-wrapper py-3 d-flex align-items-center justify-content-center">
          <div class="offline-text text-center">
            <h5>An Error Occured!</h5>
            <p>The page you are requesting is currently not available, please try later <a href="https://wa.me/2348022091426?text=Hello"> Report Here </a></p><a class="btn btn-primary" href="{{route('index')}}">Back Home</a>
          </div>
        </div>
      </div>
    </div>
@endsection