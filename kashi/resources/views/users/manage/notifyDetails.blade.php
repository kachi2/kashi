@extends('layouts.app')
@section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('home')}}"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">Notifications</h6>
        </div>
        <!-- Navbar Toggler-->
        <div class="suha-navbar-toggler d-flex justify-content-between flex-wrap" id="suhaNavbarToggler"><span></span><span></span><span></span></div>
      </div>
    </div>
@endsection
@section('content')

 <div class="page-content-wrapper">
      <div class="container">
        <!-- Notifications Details Area-->
        <div class="notification-area pt-3 pb-2">
          <h6 class="pl-1">Notifications Details</h6>
          <!-- Notification Details-->
          <div class="list-group-item d-flex py-3"><span class="noti-icon"><i class="lni lni-alarm"></i></span>
            <div class="noti-info">
              <h6>{{$notifications->topic}}</h6>
              <p>{{$notifications->message}}</p>
              <a class="btn btn-primary" href="{{route('notifications')}}">Return Back</a> <a class="btn btn-danger" href="{{route('del-notify', $notifications->id)}}">Delete</a>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection