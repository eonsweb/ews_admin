@extends('admin.app')

@section('title','Profile')

@section('page-heading','Profile')

@section('main-content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="col-xxl-4 col-xl-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body p-0">
                    <div class="d-sm-flex align-items-top p-4 border-bottom-0 main-profile-cover">
                        <div>
                            @if (empty($profile->photo))
                            <span class="avatar avatar-xxl avatar-rounded online me-3">
                                {{-- <img src="" alt=""> --}}
                                <i class="ti ti-user-circle fs-50 me-2 op-7"></i>
                            </span>
                            @else
                            <span class="avatar avatar-xxl avatar-rounded online me-3">
                                <img src=" {{url('admin/assets/images/uploads/'.$profile->photo) }}" alt="">
                            </span>
                            @endif
                        </div>
                        <div class="flex-fill main-profile-info">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="fw-semibold mb-1 text-fixed-white">{{ $profile->name }}</h6>
                                {{-- <button class="btn btn-light btn-wave"><i class="ri-add-line me-1 align-middle d-inline-block"></i>Follow</button> --}}
                            </div>
                            <p class="mb-1 text-muted text-fixed-white op-7">{{$profile->role}}</p>
                            
                           
                        </div>
                    </div>
                    
                    <div class="p-4 border-bottom border-block-end-dashed">
                        <p class="fs-15 mb-2 me-4 fw-semibold">Contact Information :</p>
                        <div class="text-muted">
                            <p class="mb-2">
                                <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                    <i class="ri-mail-line align-middle fs-14"></i>
                                </span>
                                {{ $profile->email }}
                            </p>
                            <p class="mb-2">
                                <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                    <i class="ri-phone-line align-middle fs-14"></i>
                                </span>
                                {{  !empty($profile->phone) ? $profile->phone : 'NIL' }}
                            </p>
                            <p class="mb-0">
                                <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                    <i class="ri-map-pin-line align-middle fs-14"></i>
                                </span>
                                {{  !empty($profile->address) ? $profile->address : 'NIL' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-8 col-xl-12">
            <div class="card custom-card">
                
                    <div class="card-header d-sm-flex d-block">
                        <ul class="nav nav-tabs nav-tabs-header mb-0 d-sm-flex d-block" role="tablist">
                            <li class="nav-item m-1">
                                <a class="nav-link active" data-bs-toggle="tab" role="tab" aria-current="page"
                                href="#personal-info" aria-selected="true">Personal Information</a>
                            </li>
                            <li class="nav-item m-1">
                                <a class="nav-link" data-bs-toggle="tab" role="tab" aria-current="page"
                                href="#account-settings" aria-selected="true">Password Settings</a>
                            </li>
                        
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane show active" id="personal-info"
                                role="tabpanel">
                                <div class="p-sm-3 p-0">
                                    <h6 class="fw-semibold mb-3">
                                        Profile Image :
                                    </h6>
                                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')

                                        <div class="mb-4 d-sm-flex align-items-center">
                                            <div class="mb-0 me-5">
                                                <span class="avatar avatar-xxl avatar-rounded">
                                                    <img src="{{ !empty($profile->photo) 
                                                                ? url('admin/assets/images/uploads/'.$profile->photo) 
                                                                :  url('admin/assets/images/uploads/papak.jpg') }}"
                                                                alt="" 
                                                                id="profile-img-preview"
                                                    >
                                                    <a href="javascript:void(0);" class="badge rounded-pill bg-primary avatar-badge">
                                                        <input type="file" 
                                                            name="photo" 
                                                            class="position-absolute w-100 h-100 op-0" 
                                                            id="profile-img-upload" 
                                                            accept="image/*"
                                                        >
                                                        <i class="fe fe-camera"></i>
                                                    </a>
                                                </span>
                                            </div>
                                            <div class="btn-group">
                                                <button class="btn btn-primary">Change</button>
                                                <button class="btn btn-light">Remove</button>
                                            </div>
                                        </div>
                                        <h6 class="fw-semibold mb-3">
                                            Profile :
                                        </h6>
                                        <div class="row gy-4 mb-4">
                                            <div class="col-xl-6">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" name="name" id="name" value="{{ $profile->name}}" placeholder="Name">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="name" class="form-label">User Name</label>
                                                <input type="text" class="form-control" name="username" id="name" value="{{ $profile->username }}" placeholder="Name">
                                            </div>

                                            
                                        </div>
                                        <h6 class="fw-semibold mb-3">
                                            Personal information :
                                        </h6>
                                        <div class="row gy-4 mb-4">
                                            <div class="col-xl-6">
                                                <label for="phone-number" class="form-label">Phone number :</label>
                                                <input type="text" class="form-control" id="phone-number" name="phone" value="{{$profile->phone}}" placeholder="Phone">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="email-address" class="form-label">Email Address :</label>
                                                <input type="text" class="form-control" id="email-address" name="email" value="{{$profile->email}}" placeholder="xyz@gmail.com">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="Contact-Details" class="form-label">Residential Address</label>
                                                <input type="text" class="form-control" name="address" id="Address" value="{{ $profile->address}}" placeholder="Address">
                                            </div>
                                        
                                        </div>
                                        <div class="card-footer">
                                            <div class="float-end">
                                                <button type="submit" class="btn btn-primary m-1">
                                                     Save Changes
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            <div class="tab-pane" id="account-settings"
                                role="tabpanel">
                                <div class="row gap-3 justify-content-between">
                                    <div class="col-xl-7">
                                        <div class="card custom-card shadow-none mb-0 border">
                                            <div class="card-body">
                                                <form action="{{ route('admin.profile.password.update') }}" method="POST" >
                                                    @csrf
                                                    @method('PATCH')
                                                <div class="d-flex align-items-top justify-content-between">
                                                    <div>
                                                        <p class="fs-14 mb-1 fw-semibold">Reset Password</p>
                                                        <p class="fs-12 text-muted">Password should be min of <b class="text-success">4 digits<sup>*</sup></b>,atleast <b class="text-success">One Capital letter<sup>*</sup></b> and <b class="text-success">One Special Character<sup>*</sup></b> included.</p>
                                                        <div class="mb-2">
                                                            <label for="current-password" class="form-label">Current Password</label>
                                                            <input type="password" 
                                                                class="form-control @error('current_password') is-invalid @enderror" 
                                                                id="current-password" 
                                                                placeholder="Current Password"
                                                                name="current_password"
                                                                >
                                                                @error('current_password')
                                                                    <span class="invalid-feedback">{{$message}}</span>
                                                                @enderror
                                                           
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="new-password" class="form-label">New Password</label>
                                                            <input type="password" 
                                                                class="form-control @error('new_password') is-invalid @enderror" 
                                                                id="new-password" 
                                                                placeholder="New Password"
                                                                name="new_password"
                                                            >
                                                            @error('new_password')
                                                                <span class="invalid-feedback">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-0">
                                                            <label for="confirm-password" class="form-label">Confirm New Password</label>
                                                            <input type="password" 
                                                                class="form-control @error('confirm_new_password') is-invalid @enderror" 
                                                                id="confirm-password" 
                                                                placeholder="Confirm New Password"
                                                                name="confirm_new_password"
                                                            >
                                                            @error('confirm_new_password')
                                                                <span class="invalid-feedback">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="float-end">
                                                        <button type="submit" class="btn btn-primary m-1">
                                                            Update Password
                                                        </button>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        
                        </div>
                    </div>
                    
                
            </div>
        </div>

    </div>
        
   
    <!--End::row-1 -->
    <script>


        document.getElementById('profile-img-upload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgElement = document.getElementById('profile-img-preview');
                    imgElement.src = e.target.result;
                    imgElement.style.display = 'block';  // Show the image preview
                };
                reader.readAsDataURL(file);
            }
        });

    </script>


@endsection