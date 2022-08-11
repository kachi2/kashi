@extends('layouts.app')

@section('content')

     <div class="page-content-wrapper">
      <div class="container">
        <!-- Offline Area-->
        <div class="offline-area-wrapper py-3 d-flex align-items-center justify-content-center">
          <div class="offline-text text-center">
            <h5>Page Expired!</h5>
            <p>This page has expired!</p>
            <a class="btn btn-primary" onclick="location.reload()"href="{{route('index')}}">Return Home</a>
          </div>
        </div>
      </div>
    </div>
@endsection