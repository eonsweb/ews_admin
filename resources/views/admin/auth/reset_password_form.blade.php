<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Eonsweb Admin - Reset Password</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('admin/css/sb-admin-2.min.css')}}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

      <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9 mt-5">

                <div class="card o-hidden border-0 shadow-lg my-5 pt-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 font-weight-bold text-primary mb-4">Reset Password</h1>
                                    </div>
                                

                                {{-- Reset Password Form  --}}
                                    <form class="user" method="POST" action="{{route('admin.reset.password.submit',['token' => $token, 'email' => $email])}}" >
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="remember_token" value="{{ $token }}">
                                        <input type="hidden" name="email" value="{{ $email }}">
                                        <div class="form-group">
                                            <input type="password"  name="password"
                                                class="form-control form-control-lg @error('password') is-invalid @enderror"
                                                id="exampleInputPassword" placeholder="New Password"
                                            />
                                            @error('password')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="confirm_password"
                                                class="form-control form-control-lg @error('confirm_password') is-invalid @enderror"
                                                id="exampleInputPassword" placeholder="Confirm Password"
                                            />
                                            @error('confirm_password')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                        
                                        {{-- @if(session('error'))
                                            <div class="alert alert-danger">
                                                {{ session('error') }}
                                            </div>
                                        @endif
                                        @if(session('success'))
                                            <div class="alert alert-success">
                                                {{ session('success') }}
                                            </div>
                                        @endif --}}

                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            Reset
                                        </button>
                                        
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{route('admin.forget_password')}}">Forgot Password?</a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>


    @include('admin.layout.footer_auth')