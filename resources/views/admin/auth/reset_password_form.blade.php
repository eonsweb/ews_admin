<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Eonsweb Admin | Reset Password </title>
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

    <div class="container-lg">
        <div class="row justify-content-center authentication authentication-basic align-items-center h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
                <div class="my-5 d-flex justify-content-center">
                    <a href="index.html">
                        <img src="{{ asset('admin/assets/images/brand-logos/desktop-logo.png')}}" alt="logo" class="desktop-logo">
                        <img src="{{ asset('admin/assets/images/brand-logos/desktop-dark.png')}}" alt="logo" class="desktop-dark">
                    </a>
                </div>
                <div class="card custom-card">
                    <div class="card-body p-5">
                        <p class="h5 fw-semibold mb-2 text-center">Create Password</p>
                        <form class="user" method="POST" action="{{route('admin.reset.password.submit',['token' => $token, 'email' => $email])}}" >
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="remember_token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ $email }}">
                            <div class="row gy-3">
                                <div class="col-xl-12">
                                    <label for="create-password" class="form-label text-default">New Password</label>
                                    <div class="input-group">
                                        <input type="password" 
                                                name="password" 
                                                class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                                id="create-password" placeholder="new password"
                                        >
                                        <button class="btn btn-light" type="button" onclick="createpassword('create-password',this)"><i class="ri-eye-off-line align-middle"></i></button>
                                        @error('password')
                                            <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-12 mb-2">
                                    <label for="create-confirmpassword" class="form-label text-default">Confirm Password</label>
                                    <div class="input-group">
                                        <input type="password" name="confirm_password"
                                            class="form-control form-control-lg @error('confirm_password') is-invalid @enderror" 
                                            id="create-confirmpassword" placeholder="password"
                                         >
                                        <button class="btn btn-light" onclick="createpassword('create-confirmpassword',this)" type="button"><i class="ri-eye-off-line align-middle"></i></button>
                                        @error('confirm_password')
                                            <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-12 d-grid mt-2">
                                    <button class="btn btn-lg btn-primary">Save Password</button>
                                </div>
                            </div>
                        </form>
                        
                        <div class="text-center">
                            <p class="fs-12 text-muted mt-3">Back to login ? <a href="{{route('admin.login')}}" class="text-primary">Click Here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!-- Bootstrap JS -->
     <script src="{{ asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

     <!-- Show Password JS -->
     <script src="{{ asset('admin/assets/js/show-password.js') }}"></script>
 
 </body>
 
 </html>