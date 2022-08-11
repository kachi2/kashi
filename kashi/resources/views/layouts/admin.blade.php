<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Bigdeal admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Bigdeal admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href={{"/backend/images/favicon/favicon.ico"}} type="image/x-icon">
    <title>payM| Admin</title>

    <!-- Google font-->
     <script src="https://cdn.ckeditor.com/4.14.0/basic/ckeditor.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Font Awesome-->
       
          <link rel="stylesheet" type="text/css" href={{"/custom/vendors/bootstrap-fileinput/css/fileinput.css"}} media="all" />

    <link rel="stylesheet" type="text/css" href={{"/custom/css/formelements.css"}}>
   <link href={{"/custom/vendors/iCheck/css/all.css"}} rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href={{"/backend/css/font-awesome.css"}}>

    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href={{"/backend/css/flag-icon.css"}}>
     
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href={{"/backend/css/icofont.css"}}>
      <link rel="stylesheet" type="text/css" href={{"/backend/css/dropzone.css"}}>
    <!-- Prism css-->
    <link rel="stylesheet" type="text/css" href={{"/backend/css/prism.css"}}>
     <link rel="stylesheet" type="text/css" href={{"/backend/css/jsgrid.css"}}>

    <!-- Chartist css -->
    <link rel="stylesheet" type="text/css" href={{"/backend/css/chartist.css"}}>

    <!-- vector map css -->
    <link rel="stylesheet" type="text/css" href={{"/backend/css/vector-map.css"}}>

    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href={{"/backend/css/bootstrap.css"}}>

    <!-- App css-->
    <link rel="stylesheet" type="text/css" href={{"/backend/css/admin.css"}}>
</head>

<body>

<!-- page-wrapper Start-->
<div class="page-wrapper">

    <!-- Page Header Start-->
    <div class="page-main-header">
        <div class="main-header-left">
            <div class="logo-wrapper"><a href="index.html">payM</a></div>
        </div>
        <div class="main-header-right row">
            <div class="mobile-sidebar">
                <div class="media-body text-right switch-sm">
                    <label class="switch">
                        <input id="sidebar-toggle" type="checkbox" checked="checked"><span class="switch-state"></span>
                    </label>
                </div>
            </div>
            <div class="nav-right col">
                <ul class="nav-menus">
                    <li>
                        <form class="form-inline search-form">
                            <div class="form-group">
                                <input class="form-control-plaintext" type="search" placeholder="Search.."><span class="d-sm-none mobile-search"><i data-feather="search"></i></span>
                            </div>
                        </form>
                    </li>
                    <li class="onhover-dropdown"><a class="txt-dark" href="#">
                        <h6>EN</h6></a>
                        
                    </li>
                    <li class="onhover-dropdown">
                        <div class="media align-items-center"><img class="align-self-center pull-right img-50 rounded-circle blur-up lazyloaded" src="{{asset('/images/mmm.png')}}" alt="header-user">
                            <div class="dotted-animation"><span class="animate-circle"></span><span class="main-circle"></span></div>
                        </div>
                        <ul class="profile-dropdown onhover-show-div p-20 profile-dropdown-hover">
                           <li><a href="#">Dashboard<span class="pull-right"><i data-feather="file-text"></i></span></a></li>
                            <li><a href="#">Profile<span class="pull-right"><i data-feather="user"></i></span></a></li>
                            <li><a href="#">Settings<span class="pull-right"><i data-feather="settings"></i></span></a></li>
                        </ul>
                    </li>
                </ul>
                <div class="d-lg-none mobile-toggle pull-right"><i data-feather="more-horizontal"></i></div>
            </div>
        </div>
    </div>
<div class="page-body-wrapper">

        <!-- Page Sidebar Start-->
        <div class="page-sidebar">
            <div class="sidebar custom-scrollbar">
                <div class="sidebar-user text-center">
                    <div><img class="img-60 rounded-circle lazyloaded blur-up" src={{asset('/images/mmm.png')}} alt="#">
                    </div>
                    @guest
                    @else
                    <h6 class="mt-3 f-14">{{Auth()->user()->first_name}}</h6>
                    @endguest
                </div>
                <ul class="sidebar-menu">
                    <li><a class="sidebar-header" href="{{route('admin.index')}}"><i data-feather="home"></i><span>Dashboard</span></a></li>
                     <li><a class="sidebar-header" href="#"><i data-feather="box"></i> <span>Category</span><i class="fa fa-angle-right pull-right"></i></a>
                        <ul class="sidebar-submenu">   
                            <li><a href="{{route('category.index')}}"><i class="fa fa-circle"></i>Category</a></li>
                            <li><a href="{{route('category.sub-category')}}"><i class="fa fa-circle"></i>Sub Category</a></li>
                            <li><a href="{{route('category.create')}}"><i class="fa fa-circle"></i>Create Category</a></li>
                            <li><a href="{{route('bills.categories')}}"><i class="fa fa-circle"></i>Bill Category</a></li>
                            <li><a href="{{route('category.bills')}}"><i class="fa fa-circle"></i>Create Bill Category</a></li>
                        </ul>
                    </li>
                    <li><a class="sidebar-header" href="#"><i data-feather="box"></i> <span>Products</span><i class="fa fa-angle-right pull-right"></i></a>
                        <ul class="sidebar-submenu">
                                    <li><a href="{{route('products.index')}}"><i class="fa fa-circle"></i>Product List</a></li>
                                    <li><a href="{{route('products.create')}}"><i class="fa fa-circle"></i>Add Product</a></li>
                                    <li><a href="{{route('bills.products.index')}}"><i class="fa fa-circle"></i>Bill Products</a></li>
                                    <li><a href="{{route('bills_products')}}"><i class="fa fa-circle"></i>Add Bill Products</a></li>
                        </ul>
                    </li>
                    <li><a class="sidebar-header" href="#"><i data-feather="dollar-sign"></i><span>Sales</span><i class="fa fa-angle-right pull-right"></i></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{route('admin.orders')}}"><i class="fa fa-circle"></i>Orders</a></li>
                            <li><a href="{{route('admin.transaction')}}"><i class="fa fa-circle"></i>Transactions</a></li>
                            <li><a href="{{route('users_bill_transactions')}}"><i class="fa fa-circle"></i>Bills Transactions</a></li>
                        <li><a href="{{route('users_settlements')}}"><i class="fa fa-circle"></i>Vendor Settlements</a></li>
                        </ul>
                    </li>
                    <li><a class="sidebar-header" href="#"><i data-feather="user-plus"></i><span>Users</span><i class="fa fa-angle-right pull-right"></i></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{route('admin.users')}}"><i class="fa fa-circle"></i>User List</a></li>
                        </ul>
                    </li>
                     <li><a class="sidebar-header" href="#"><i data-feather="fa-bell"></i><span>Notifications</span><i class="fa fa-angle-right pull-right"></i></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{route('admin.notify')}}"><i class="fa fa-circle"></i>Send Notifications</a></li>
                        </ul>
                    </li>
                     <li><a class="sidebar-header" href="#"><i data-feather="fa fa-circle"></i><span>Fund Request</span><i class="fa fa-angle-right pull-right"></i></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{route('fund-request')}}"><i class="fa fa-circle"></i>Fund Request</a></li>
                        </ul>
                    </li>
                      <li><a class="sidebar-header" href="#"><i data-feather="fa fa-circle"></i><span>Activation Request</span><i class="fa fa-angle-right pull-right"></i></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{route('activation-request')}}"><i class="fa fa-circle"></i>Wallet Activations</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
@yield('content')




<footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 footer-copyright">
                        <p class="mb-0">Copyright 2020 © Kashi All rights reserved.</p>
                    </div>
                    <div class="col-md-6">
                        
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer end-->
    </div>

</div>
<!--custom -->
<script type="text/javascript" src={{"/custom/vendors/bootstrap-fileinput/js/fileinput.js"}}></script>
<script type="text/javascript" src={{"/custom/vendors/bootstrap-fileinput/js/theme.js"}}>  </script>
<script type="text/javascript" src={{"/custom/js/custom_js/form_elements.js"}}></script>
<script src={{"/custom/vendors/iCheck/js/icheck.js"}}></script>
<!-- latest jquery-->
<script src={{"/backend/js/jquery-3.3.1.min.js"}}></script>

<!-- Bootstrap js-->
<script src={{"/backend/js/popper.min.js"}}></script>
<script src={{"/backend/js/bootstrap.js"}}></script>

<!-- feather icon js-->
<script src={{"/backend/js/icons/feather-icon/feather.min.js"}}></script>
<script src={{"/backend/js/icons/feather-icon/feather-icon.js"}}></script>

<!-- Sidebar jquery-->

<script src={{"/backend/js/sidebar-menu.js"}}></script>


<!-- Jsgrid js-->
<script src={{"/backend/js/jsgrid/jsgrid.min.js"}}></script>
<script src={{"/backend/js/jsgrid/griddata-digital.js"}}></script>
<script src={{"/backend/js/jsgrid/jsgrid-manage-product.js"}}></script>
<!--chartist js-->
<script src={{"/backend/js/chart/chartist/chartist.js"}}></script>


<!-- lazyload js-->
<script src={{"/backend/js/lazysizes.min.js"}}></script>

<!--copycode js-->
<script src={{"/backend/js/prism/prism.min.js"}}></script>
<script src={{"/backend/js/clipboard/clipboard.min.js"}}></script>
<script src={{"/backend/js/custom-card/custom-card.js"}}></script>

<!--counter js-->
<script src={{"/backend/js/counter/jquery.waypoints.min.js"}}></script>
<script src={{"/backend/js/counter/jquery.counterup.min.js"}}></script>
<script src={{"/backend/js/counter/counter-custom.js"}}></script>

<!--Customizer admin-->


<!--map js-->
<script src={{"/backend/js/vector-map/jquery-jvectormap-2.0.2.min.js"}}></script>
<script src={{"/backend/js/vector-map/map/jquery-jvectormap-world-mill-en.js"}}></script>

<!--apex chart js-->
<script src={{"/backend/js/chart/apex-chart/apex-chart.js"}}></script>
<script src={{"/backend/js/chart/apex-chart/stock-prices.js"}}></script>

<script src={{"/backend/js/dropzone/dropzone.js"}}></script>
<script src={{"/backend/js/dropzone/dropzone-script.js"}}></script>
<!--chartjs js-->
<script src={{"/backend/js/chart/flot-chart/excanvas.js"}}></script>
<script src={{"/backend/js/chart/flot-chart/jquery.flot.js"}}></script>
<script src={{"/backend/js/chart/flot-chart/jquery.flot.time.js"}}></script>
<script src={{"/backend/js/chart/flot-chart/jquery.flot.categories.js"}}></script>
<script src={{"/backend/js/chart/flot-chart/jquery.flot.stack.js"}}></script>
<script src={{"/backend/js/chart/flot-chart/jquery.flot.pie.js"}}></script>
<!--dashboard custom js-->
<script src={{"/backend/js/dashboard/default.js"}}></script>

<!--right sidebar js-->
<script src={{"/backend/js/chat-menu.js"}}></script>

<!--height equal js-->
<script src={{"/backend/js/equal-height.js"}}></script>

<!-- lazyload js-->
<script src={{"/backend/js/lazysizes.min.js"}}></script>

<!--script admin-->
<script src={{"/backend/js/admin-script.js"}}></script>

</body>
</html>
