@extends('layouts.app')

@section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('home')}}"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">My Profile</h6>
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
         @if(Session::has('welcome'))
          <div class="p-1"></div>
        <p class="alert alert-warning"> {{Session::get('welcome')}}</p>

            @endif
        <div class="profile-wrapper-area py-3">
          <!-- User Information-->
          <div class="card user-info-card">
            <div class="card-body p-4 d-flex align-items-center">
              <div class="user-profile mr-3"><img src="{{asset('/images/mmm.png')}}" alt=""></div>
              <div class="user-info">
                <p class="mb-0 text-white">{{auth()->user()->name}}</p>
              </div>
            </div>
          </div>
          <!-- User Meta Data-->
          <div class="card user-data-card">
            <div class="card-body">
           
              <div class="single-profile-data d-flex align-items-center justify-content-between">
                <div class="title d-flex align-items-center"><i class="lni lni-user"></i><span>Full Name</span></div>
                <div class="data-content">{{auth()->user()->name}}</div>
              </div>
              <div class="single-profile-data d-flex align-items-center justify-content-between">
                <div class="title d-flex align-items-center"><i class="lni lni-phone"></i><span>Phone</span></div>
                <div class="data-content">{{auth()->user()->phone}}</div>
              </div>
              <div class="single-profile-data d-flex align-items-center justify-content-between">
                <div class="title d-flex align-items-center"><i class="lni lni-envelope"></i><span>Email Address</span></div>
                <div class="data-content">{{auth()->user()->email}}</div>
              </div>
              <div class="single-profile-data d-flex align-items-center justify-content-between">
                <div class="title d-flex align-items-center"><i class="lni lni-envelope"></i><span>Date Joined</span></div>
                <div class="data-content">{{auth()->user()->created_at->diffForHumans()}}</div>
              </div>
               <div class="single-profile-data d-flex align-items-center justify-content-between">
                <div class="title d-flex align-items-center"><i class="lni lni-envelope"></i><span>Account Type</span></div>
                <div class="data-content">@if(auth()->user()->level == 1) <span class="btn-success p-2"> Regular</span> @else  <span class="btn-success p-2">Premium </span>@endif</div>
              </div>
               <div class="single-profile-data d-flex align-items-center justify-content-between">
                <div class="title d-flex align-items-center"><i class="lni lni-envelope"></i><span>Referral Link</span>  <span id="hh" hidden  class="btn-secondary p-1" style="font-size:12px;">Copied</span></div>
              <input class="form-control" style="font-size:10px " id="copyT" value="https://paym.com.ng/referral?referral={{auth()->user()->email}}" readOnly>  <a href=""><button type="submit" class=" btn btn-secondary" onclick="copyTex()">Copy</button>
             
             </a>  </div>
              
              
            </div>
          </div>
          <!-- Edit Profile-->
         
        </div>
      </div>
    </div>
@endsection

@section('script')

<script>
function copyTex() {
  var copyText = document.getElementById("copyT");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  document.execCommand("copy");
  $('#hh').attr('hidden', false);
}
</script>
@endsection