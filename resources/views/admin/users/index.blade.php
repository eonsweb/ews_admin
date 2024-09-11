@extends('admin.app')

@section('title','Settings') 
@section('heading','Users') 

@section('main_content')
<!-- Content Row -->
<div class="row">

    
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
    
                <div class="col-6">
                    <a href="#" class="btn btn-sm btn-success"><i class="fas fa-plus"></i><span class="pl-1 ">New</span></a>
                    <a href="#" class="btn btn-sm btn-primary"><i class="fas fa-filter"></i><span class="pl-1">Filter</span></a>
                </div>

                <div class="col-6">
                    <div class="d-flex justify-content-end">
                        {{-- Export Files Button --}}
                        <div class="btn-group btn-sm" role="group">
                            <button id="btnExportGroup" 
                                    type="button" 
                                    class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split" 
                                    data-toggle="dropdown" 
                                    aria-haspopup="true" 
                                    aria-expanded="false"
                            >
                                <i class="fas fa-download"></i><span class="pl-1 pr-1">Export</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnExportGroup">
                                <a href="#" target="_blank" class="dropdown-item">All</a>
                                <a href="#" target="_blank" class="dropdown-item">Current page</a>
                                <a href="#" target="_blank" class="dropdown-item">Selected rows</a>
                            </div>
                        </div>

                        {{-- Table Filter Button --}}
                        <div class="btn-group btn-sm" role="group">
                            <button id="btnFilterGroup" type="button" 
                                    class="btn btn-primary btn-sm dropdown-toggle" 
                                    data-toggle="dropdown" 
                                    aria-haspopup="true" aria-expanded="false"
                            >
                            <i class="fas fa-table"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnFilterGroup">
                                <li class="form-check">
                                    
                                    <label class="dropdown-item" for="column-select-name">
                                        <input type="checkbox" class="form-check-input" value="" id="column-select-name">
                                        Name
                                    </label>
                                </li>
                                <li class="form-check">
                                    <label class="dropdown-item" for="column-select-username">
                                        <input type="checkbox" class="form-check-input" value="" id="column-select-username">
                                        Username
                                    </label>
                                </li>
                                <li class="form-check">
                                    <label class="dropdown-item" for="column-select-email">
                                        <input type="checkbox" class="form-check-input" value="" id="column-select-email">
                                        Email
                                    </label>
                                </li>
                                <li class="form-check">
                                    <label class="dropdown-item" for="column-select-photo">
                                        <input type="checkbox" class="form-check-input" value="" id="column-select-photo">
                                        Photo
                                    </label>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li class="text-center">
                                    <button class="btn btn-sm btn-light column-select-all" onclick="admin.grid.columns.all()">All</button> &nbsp;
                                    <button class="btn btn-sm btn-primary column-select-all" onclick="admin.grid.columns.submit()">Submit</button>
                                </li>
                            
                            </div>
                        </div>
                    </div>
                </div>
             
            </div>
        </div>
        {{-- Table Body --}}
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Photo</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Isaac Agyei Duku</td>
                            <td>ai.duku</td>
                            <td>admin</td>
                            <td>i.agyeiduku@gmail.com</td>
                            <td></td>
                            <td>10-09-2024</td>
                            <td>10-09-2024</td>
                            <td>
                                <a href="#" class="btn btn-primary btn-circle btn-sm mr-1">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#" class="btn btn-success btn-circle btn-sm mr-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <a href="#" class="btn btn-danger btn-circle btn-sm">
                                    <i class="fas fa-trash"></i>
                                </a>
                        </td>
                        </tr>
                    </tbody>
                    
                    
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
   

    

    
</div>
@endsection