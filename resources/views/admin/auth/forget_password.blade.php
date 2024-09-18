<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Eonsweb Admin | Forget Password </title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="EonswebSolutions">
	<meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">

    <!-- Favicon -->
    <link rel="icon" href=" {{ asset('admin/assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">

    <!-- Main Theme Js -->
    <script src=" {{ asset('admin/assets/js/authentication-main.js') }}"></script>

    <!-- Bootstrap Css -->
    <link id="style" href=" {{ asset('admin/assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" >

    <!-- Style Css -->
    <link href=" {{ asset('admin/assets/css/styles.min.css') }}" rel="stylesheet" >

    <!-- Icons Css -->
    <link href=" {{ asset('admin/assets/css/icons.min.css') }}" rel="stylesheet" >


</head>

<body>

    <div class="container">
        <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
                <div class="my-5 d-flex justify-content-center">
                    <a href="index.html">
                        {{-- <img src="{{ asset('admin/assets/images/brand-logos/desktop-logo.png')}}" alt="logo" class="desktop-logo">
                        <img src="{{ asset('admin/assets/images/brand-logos/desktop-dark.png')}}" alt="logo" class="desktop-dark"> --}}
                        Eonsweb
                    </a>
                </div>
                <div class="card custom-card">
                    <div class="card-body p-5">
                        <p class="h5 fw-semibold mb-2 text-center">Forgot Password</p>
                        <p class="mb-4 text-muted op-7 fw-normal text-center">Enter your email address below and we'll send you a link to reset your password! !</p>
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form class="user" method="POST" action="{{route('admin.forget.password.submit')}}">
                            @csrf
                            <div class="row gy-3">
                            
                                <div class="col-xl-12">
                                    <label for="email" class="form-label text-default">Email Address</label>
                                    <input type="text" 
                                        class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                        name="email" 
                                        placeholder="email address"
                                    >
                                    @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                </div>
                                
                                <div class="col-xl-12 d-grid mt-2">
                                    <button type="submit" class="btn btn-lg btn-primary">Forget Password</button>
                                </div>
                                <div class="text-center">
                                    <p class="fs-12 text-muted mt-3">Back to Login ? <a href="{{ route('admin.login') }}" class="text-primary">Login</a></p>
                                </div>
                            </div>
                        </form>
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>


   