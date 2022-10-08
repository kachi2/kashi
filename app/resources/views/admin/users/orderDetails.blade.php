@extends('layouts.admin')
@section('content')
<div class="page-body">

            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="page-header-left">
                                <h4>Orders Detail
                                </h4>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ol class="breadcrumb pull-right">
                                <li class="breadcrumb-item"><a href=""><i data-feather="home"></i></a></li>
                                <li class="breadcrumb-item">Dashbhoard</li>
                                <li class="breadcrumb-item active">Orders Details</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->

            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                    @include('includes.message')
                        <div class="card">
                            <div class="card-body">
                               
                               <div class="table-responsive">
        <table class="table table-striped table-bordered" id="table2">
                                    <thead>
                                    <tr>
                                          <th>Image</th>
                                        <th>Order ID</th>
                                         <th>Product Name</th>
                                         <th>Price Per Unit</th>
                                        <th>Amount</th>
                                        <th>Quantity</th>
                                        <th>Shop_id</th>
                                        <th>Transaction Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                   @foreach ($orders as $pro )
                                    <tr>
                                    <td><img src="{{asset('/images/products/'.$pro->image)}}"width="100" height="80"></td>
                                        <td>{{$pro->id}}</td>
                                        <td>{{$pro->product_name }}</td>
                                        <td>N{{number_format($pro->price,2)}} </td>
                                        <td>{{$pro->qty}}</td>
                                        <td>N{{number_format($pro->amount)}}</td>
                                        <td>{{$pro->shop_id}}</td>
                                       <td>{{$pro->created_at}}</td> 
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
              

@endsection
