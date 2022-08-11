@extends('layouts.app')

@section('content')

     <div class="page-content-wrapper">
      <div class="container">
        <!-- Offline Area-->
        <div class="offline-area-wrapper py-3 d-flex align-items-center justify-content-center">
          <div class="offline-text text-center">
            <h5>No Internet Connection!</h5>
            <p>Seems like you're offline, please check your internet connection. This page doesn't support when you offline!</p>
            <a class="btn btn-primary" onclick="location.reload()"href="{{route('index')}}">Refresh Page</a>
          </div>
        </div>
      </div>
    </div>
@endsection