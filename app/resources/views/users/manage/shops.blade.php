@extends('layouts.app')
@section('navigation')
   <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="{{route('home')}}"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">My shops</h6>
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
        @if(Session::has('msg'))
        <p class="alert {{Session::get('class', 'alert-success')}}"> {{Session::get('msg')}} </p>
        @endif
        @if($shop)
        <div class="profile-wrapper-area py-3">
          <!-- User Information-->
          <div class="card user-info-card">
            <div class="card-body p-4 d-flex align-items-center">
              <div class="user-profile mr-3"><img src="{{asset('/images/shops/'.$shop->image)}}" alt=""></div>
              <div class="user-info">
                
                <h6 class="mb-0" style="color:#fff">{{$shop->name}}</h6>
                <p>
                <i class="lni lni-envelope" style="color:#fff"></i><span style="color:#fff"> {{$shop->email}}</span><br>
                <i class="lni lni-phone" style="color:#fff"></i><span style="color:#fff"> {{$shop->phone}}</span><br>
                <i class="lni lni-money-location" style="color:#fff"></i><span style="color:#fff"> {{$shop->location}}</span>
                <div class="edit-profile-btn mt-3"><a class="btn btn-info w-100" href="{{route('edit-shop')}}"><i class="lni lni-pencil mr-2"></i>Edit Profile</a></div>
                 </p>
              </div>
            </div>
          </div>
          <!-- User Meta Data-->
          <div class="p-2"></div>
        <div class="card settings-card">
            <div class="card-body">
              <!-- Single Settings-->
              <div class="single-settings d-flex align-items-center justify-content-between">
                <div class="title"><i class="lni lni-cloud-upload"></i><span>Products</span></div>
                <div class="data-content">
                  <div class="toggle-button-cover">
                 <a href="{{route('my-products')}}">  <button type="button" class="btn btn-primary" >  View</button></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
         <div class="card settings-card">
            <div class="card-body">
              <!-- Single Settings-->
              <div class="single-settings d-flex align-items-center justify-content-between">
                <div class="title"><i class="lni lni-folder"></i><span>Orders</span></div>
                <div class="data-content">
                  <div class="toggle-button-cover">
                   <a href="{{route('vendor-orders')}}">  <button type="button" class="btn btn-primary" >View</button></a>
                  </div>
                </div>
              </div>
            </div>
          </div>

            <div class="card settings-card">
            <div class="card-body">
              <!-- Single Settings-->
              <div class="single-settings d-flex align-items-center justify-content-between">
                <div class="title"><i class="lni lni-revenue"></i><span>Settlements</span></div>
                <div class="data-content">
                  <div class="toggle-button-cover">
                     <a href="{{route('payment-settlement')}}"> <button type="button" class="btn btn-primary" >View</button></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
           <div class="card settings-card">
            <div class="card-body">
              <!-- Single Settings-->
              <div class="single-settings d-flex align-items-center justify-content-between">
                <div class="title"><i class="lni lni-trash"></i><span>Trashed Products</span></div>
                <div class="data-content">
                  <div class="toggle-button-cover">
                     <a href="{{route('archiveProducts')}}"> <button type="button" class="btn btn-primary" >View</button></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
       
          <!-- Edit Profile-->
        </div>
        @else
        {{Form::open(['action'=> 'vendorsController@add_shops', 'method' => 'get'])}}
         <div style="padding:10px"></div>
        <div class="card user-data-card">
            <div class="card-body">
               <div class="single-settings d-flex align-items-center justify-content-between">
                <div class="title"><span class=" btn btn-warning">You currently do not have any shop yet</span></div>
                <div class="data-content">
                  <div class="toggle-button-cover">
                    
                    
                  
                  </div>
                </div>
                
              </div>
              
            </div>
           
             <button type="submit" class="btn btn-primary p-2 "> Add New</button>
             {{Form::close()}}
          </div>

        @endif
      </div>
    </div>
@endsection