@extends('layouts.app')
@section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('home')}}"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">My Referrals</h6>
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
          <h6 class="pl-1">Referrals</h6>
          <div class="list-group">
            <!-- Single Notification-->
            @if(count($user )> 0)
            @foreach ($user as  $users)
            <a class="list-group-item d-flex align-items-center" href="">
            <img  width="40px" height="40px" src="{{asset('/images/mmm.png')}}" alt="">
              <div class="noti-info">
                <p class="mb-0" style="font-weight:bold"> </p> <span> Name: {{$users->name}}
                </span><span>  Date Join: {{$users->created_at}}</span>
              </div></a>
                   @endforeach
              @else
              <a class="list-group-item d-flex align-items-center" href="">
              <div class="noti-info">
                <span>You have not referred anyone yet, refer someone with your referral link below and earn up to 1% commission from any transaction from them.</span>
                <input class="form-control" style="font-size:10px " id="copyT" value="https://paym.com.ng/referral?referral={{auth()->user()->email}}" readOnly> <button type="button" class=" btn btn-secondary" onclick="copyTex()">Copy</button>
                
                <span id="hh" hidden style="font-size:12px">Text Copied</span>
              </div></a>
              @endif
          </div>
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