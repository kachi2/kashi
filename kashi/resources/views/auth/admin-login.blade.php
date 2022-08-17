<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
  <meta name="keywords" content="paym.com.ng, buy airtime, buy cheap data, buy power">
  <meta name="author" content="paym.com.ng">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
 
  <meta name="description" content="paym.com.ng Platform for quick purchase of Airtime, Internet Data Bundles, DSTV, GOTV, PHCN and payment for other services in Nigeria">
        
  <meta name="keywords" content="paym.com.ng  - Buy airtime online, buy MTN airtime, buy internet data subscription, Etisalat Glo Airtel Airtime, DSTV payment,GOTV payment,PHCN payment">

    <link rel="shortcut icon" href={{"/backend/images/favicon/favicon.ico"}} type="image/x-icon">
  <title>Admin</title>

    <!-- Google font-->
   <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href={{"backend/css/font-awesome.css"}}>

    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href={{"backend/css/themify.css"}}>

    <!-- slick icon-->
    <link rel="stylesheet" type="text/css" href={{"backend/css/slick.css"}}>
    <link rel="stylesheet" type="text/css" href={{"backend/css/slick-theme.css"}}>

    <!-- jsgrid css-->
    <link rel="stylesheet" type="text/css" href={{"backend/css/jsgrid.css"}}>

    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href={{"backend/css/bootstrap.css"}}>

    <!-- App css-->
    <link rel="stylesheet" type="text/css" href={{"backend/css/admin.css"}}>
</head>
<body>

<!-- page-wrapper Start-->
<div class="page-wrapper">
    <div class="authentication-box">
        <div class="container">
            <div class="row">
                <div class="col-md-3 p-0 card-left">
                   
                </div>
                <div class="col-md-7 p-0 card-right">
                    <div class="card tab2-card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="top-profile-tab" data-toggle="tab" href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="true"><span class="icon-user mr-2"></span>Login</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="top-tabContent">
                                <div class="tab-pane fade show active" id="top-profile" role="tabpanel" aria-labelledby="top-profile-tab">

                                    <form class="form-horizontal" action="{{route('admin.login.submit')}}" method="POST">
                                         @csrf
                                        <div class="form-group">
                                            <input required="" name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="email" value="{{ old('email') }}" id="exampleInputEmail1">
                                         @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <input required="" name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert"> 
                                        <strong> {{$message}}</strong>
                                        </span>
                                        @enderror

                                        </div>
                                        <div class="form-terms">
                                            <div class="custom-control custom-checkbox mr-sm-2">
                                                <input type="checkbox" class="custom-control-input" id="customControlAutosizing">
                                                <label class="custom-control-label" for="customControlAutosizing">Remember me</label>
                                                <a href="#" class="btn btn-default forgot-pass">lost your password</a>
                                            </div>
                                        </div>
                                        <div class="form-button">
                                            <button class="btn btn-primary" type="submit">Login</button>
                                        </div>
                                        <div class="form-footer">
                                           
                                        </div>
                                    {{Form::close()}}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
<script src={{"/backend/js/slick.js"}}></script>

<!-- Jsgrid js-->
<script src={{"/backend/js/jsgrid/jsgrid.min.js"}}></script>
<script src={{"/backend/js/jsgrid/griddata-invoice.js"}}></script>
<script src={{"/backend/js/jsgrid/jsgrid-invoice.js"}}></script>

<!-- lazyload js-->
<script src={{"/backend/js/lazysizes.min.js"}}></script>

<!--right sidebar js-->
<script src={{"/backend/js/chat-menu.js"}}></script>

<!--script admin-->
<script src={{"/backend/js/admin-script.js"}}></script>
<script>
    $('.single-item').slick({
            arrows: false,
            dots: true
        }
    );
</script>
</body>

<!-- Mirrored from themes.pixelstrap.com/bigdeal/admin/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 21 Apr 2020 23:08:37 GMT -->
</html>
