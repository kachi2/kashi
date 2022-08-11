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
        <!-- Notifications Area-->
        <div class="notification-area pt-3 pb-2">
          <h6 class="pl-1">Notifications</h6>
          <div class="list-group">
            <!-- Single Notification-->
            @if(count($notifications)> 0)
            @foreach($notifications as $notify)
            <a class="list-group-item {{$notify->is_read==1?'readed': ''}} d-flex align-items-center" href="{{route('notify-details', $notify->id)}}"><span class="noti-icon"><i class="lni lni-alarm"></i></span>
              <div class="noti-info">
                <h6 class="mb-0">{{substr($notify->topic, 0,25)}}</h6><span>{{$notify->created_at->diffForHumans()}}</span>
              </div></a>
              @endforeach
              {{$notifications->links()}}
            <!-- Single Notification-->
            @else
            <a class="list-group-item readed d-flex align-items-center" href="notification-details.html"><span class="noti-icon"><i class="lni lni-heart-filled"></i></span>
              <div class="noti-info">
                <h6 class="mb-0">You dont have any notificaton uet.</h6><span>2 days ago</span>
              </div></a>
         @endif
          </div>
        </div>
      </div>
    </div>


@endsection