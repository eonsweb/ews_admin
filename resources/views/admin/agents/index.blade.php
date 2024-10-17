@extends('admin.app')

@section('title', 'Agent')

@section('page-heading', 'Agents')
@section('breadcrumb-item', 'Agent')
@section('breadcrumb-active', 'Agent')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/assets/css/datatables/dataTables.bootstrap5.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/datatables/responsive.bootstrap.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/datatables/buttons.bootstrap5.min.css') }} ">

    <style>
        .hover-row {
    font-weight: normal;
    /* font-size: 16px; Initial font size */
    transition: font-weight 0.3s ease; /* Smooth transition */
}

.hover-row:hover {
    font-weight: bold;  /* Makes the font bold on hover */
    /* font-size: 16px !important;    Increases font size on hover */
}
    </style>
@endpush


@section('main-content')
    <div class="container-fluid">



        <!-- Start::row-1 -->
        <div class="row">

            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                          Number of Agents: <span class="text-danger">{{$agents->count()}}</span>
                        </div>
                        <div class=" ms-auto">
                            <a href="{{ route('admin.agent.add') }}" class="btn btn-secondary btn-sm"
                                data-bs-toggle="modal" data-bs-target="#agentNewModal"><i class='bx bx-plus'></i>New
                                Agent
                            </a>

                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="file-export" class="table table-bordered text-nowrap  table-hover w-100 w-100">
                                <thead>
                                    <tr>

                                        <th style="width: 10%;">#</th>
                                        <th>Name</th>
                                        <th style="width:100px">Phone no.</th>
                                        <th>image</th>
                                        <th style="width: 15px">Status</th>
                                        <th style="width: 15px;"><i class='bx bxs-bolt'></i>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agents as $key => $agent)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td class="hover-row"><a class="text-secondary" href="{{route('admin.agent.show',$agent->id)}}">{{ $agent->name }}</a></td>
                                            <td>{{ $agent->phone }}</td>
                                            <td>{{ $agent->image ?? 'N/A' }}</td>
                                            <td class>{!! $agent->status == 1 ? '<span class="text-success badge bg-light text-default">Active</span>' : '<span class="text-danger">Inactive</span>' !!}</td>
                                            <td><a href="{{ route('admin.agent.edit', $agent->id) }}"
                                                    class="btn btn-icon btn-sm btn-success-light  rounded-pill  "
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#agentEditModal-{{ $agent->id }}"
                                                    aria-hidden="true"
                                                >
                                                <i class="bi bi-pencil-square"></i></a>

                                                <a href="{{ route('admin.agent.delete', $agent->id) }}"
                                                    class="btn btn-icon btn-sm btn-danger-light  rounded-pill"><i
                                                        class="bi bi-trash-fill"></i>
                                                </a>
                                            </td>
                                            <!-- Include the modal with a unique ID for each agent -->
                                            @include('admin.agents.edit', ['agent' => $agent])
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-1 -->

    </div>

    <!-- Add Menu Modal -->
    @include('admin.agents.add')

   




@endsection


@if (session('modal') || $errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('agentNewModal'));
            modal.show();
        });
    </script>
@endif

@push('scripts')
    <script src="{{ asset('admin/assets/js/datatables/jquery-3.6.1.min.js') }}"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <!-- Datatables  -->
    <script src="{{ asset('admin/assets/js/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatables/jszip.min.js') }}"></script>

    <!-- Internal Datatables JS -->
    <script src="{{ asset('admin/assets/js/datatables.js') }}"></script>
@endpush
