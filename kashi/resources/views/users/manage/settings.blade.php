@extends('layouts.app')
@section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('home')}}"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">Settings</h6>
        </div>
        <!-- Navbar Toggler-->
        <div class="suha-navbar-toggler d-flex justify-content-between flex-wrap" id="suhaNavbarToggler"><span></span><span></span><span></span></div>
      </div>
    </div>

@endsection
@section('content')
   <div class="page-content-wrapper">
      <div class="container">
        <!-- Settings Wrapper-->
        <div class="settings-wrapper py-3">
        {{Form::open(['action'=>['vendorsController@accountSwitch', auth()->user()->id], 'method'=>'post', 'id'=>'form1'])}}
          <div class="card settings-card">
            <div class="card-body">
              <!-- Single Settings-->
              <div class="single-settings d-flex align-items-center justify-content-between">
                <div class="title"><i class="lni lni-angle-double-right"></i><span>Switch to Vendor Account</span></div>
                <div class="data-content">
                  <div class="toggle-button-cover">
                    <div class="button r">
                      <input class="checkbox" type="checkbox" id="vendor" {{auth()->user()->level == 2? 'checked' : ' '}}>
                      <div class="knobs" ></div>
                      <div class="layer"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
         {{Form::close()}}
          <div class="p-1"></div>
          {{Form::open(['action'=>['vendorsController@notifySwitch', auth()->user()->id], 'method'=>'post', 'id'=>'form2'])}}
            <div class="card settings-card">
            <div class="card-body">
              <!-- Single Settings-->
              <div class="single-settings d-flex align-items-center justify-content-between">
                <div class="title"><i class="lni lni-alarm"></i><span>Notifications</span></div>
                <div class="data-content">
                  <div class="toggle-button-cover">
                    <div class="button r">
                      <input class="checkbox" type="checkbox"  name="notify" id="notify" {{auth()->user()->is_notify == 1? 'checked' : ' '}}>
                      <div class="knobs"></div>
                      <div class="layer"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          {{Form::close()}}
                 <div class="p-1"></div>
         {{Form::open(['action'=>'HomeController@activate_wallet', 'method'=>'post', 'id'=>'form3'])}}
            <div class="card settings-card">
            <div class="card-body">
              <!-- Single Settings-->
              <div class="single-settings d-flex align-items-center justify-content-between">
                <div class="title"><i class="lni lni-wallet"></i><span>Activate Wallet</span></div>
                <div class="data-content">
                  <div class="toggle-button-cover">
                    <div class="button r">
                      <input class="checkbox" type="checkbox"  name="wallet" id="wallet" @if(auth()->user()->is_wallet == 1) checked @elseif(auth()->user()->is_wallet == 2) disabled @else  @endif>
                      <div class="knobs"></div>
                      <div class="layer"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
           {{Form::close()}}
      <div class="p-1"></div>
          <div class="card settings-card">
            <div class="card-body">
              <!-- Single Settings-->
              <div class="single-settings d-flex align-items-center justify-content-between">
                <div class="title"><i class="lni lni-night"></i><span>Night Mode</span></div>
                <div class="data-content">
                  <div class="toggle-button-cover">
                    <div class="button r">
                      <input class="checkbox" id="darkSwitch" type="checkbox">
                      <div class="knobs"></div>
                      <div class="layer"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
         
       
          <div class="card settings-card">
            <div class="card-body">
              <!-- Single Settings-->
              <div class="single-settings d-flex align-items-center justify-content-between">
                <div class="title"><i class="lni lni-protection"></i><span>Support</span></div>
                <div class="data-content"><a class="pl-4" href="https://wa.me/2348022091426?text=Hello, Good Day!">Chat Us<i class="lni lni-chevron-right"></i></a></div>
              </div>
            </div>
          </div>
          <div class="card settings-card">
            <div class="card-body">
              <!-- Single Settings-->
              <div class="single-settings d-flex align-items-center justify-content-between">
                <div class="title"><i class="lni lni-lock"></i><span>Password<span></span></span></div>
                <div class="data-content"><a href="{{route('change-pass')}}">Change<i class="lni lni-chevron-right"></i></a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
 
@endsection


@section('script')

<script>

$('#vendor').on('change', function(){
  if(document.getElementById('vendor').checked == true){
  swal({
    title: "Are you Sure",
    text: "You are about to become a Reseller on payM",
    icon: "warning",
    closeModal: false,
      buttons: {
    cancel: true,
    confirm: 'confirm',
  },
    }).then(function(isConfirm) {
      if (isConfirm) {
        swal({
          title: 'Welcome',
          text: 'You can now  Resell our products and sell yours!',
          icon: 'success'
        }).then(function() {
           $('#form1').submit(); // <--- submit form programmaticall
        });
      } else {
         document.getElementById('vendor').checked = false;
        swal("Cancelled", "Request rejected", "error").the(function(){
        
        });
        
      }
    });
}
if(document.getElementById('vendor').checked == false){
  swal({
    title: "Are you Sure",
    text: "You are about switching back to user account",
    icon: "warning",
    closeModal: false,
      buttons: {
    cancel: true,
    confirm: 'confirm',
  },
    }).then(function(isConfirm) {
      if (isConfirm) {
        swal({
          title: 'Goodbye',
          text: 'You are no longer a reseller on payM!',
          icon: 'error'
        }).then(function() {
           $('#form1').submit(); // <--- submit form programmaticall
        });
      } else {
         document.getElementById('vendor').checked = true;
        swal("Cancelled", "Request rejected", "error").the(function(){
        
        });
        
      }
    });
}
});


$('#notify').on('change', function(){

if(document.getElementById('notify').checked == true){

$('#form2').submit();

}

if(document.getElementById('notify').checked == false){

$('#form2').submit();

}



});

$('#wallet').on('change', function(){

if(document.getElementById('wallet').checked == true){
swal({
  title: "Confirm",
  text: "Make sure your registered email and phone number is valid for successfully activation",
  icon: "warning",
}).then(function() {
$('#form3').submit();

});
}

if(document.getElementById('wallet').checked == false){


$('#form3').submit();

}



});

</script>


@endsection