@extends('layouts.web')
@push('css')
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <!-- Bootstrap Css -->
@endpush
@section('title')
    قائمة المستخدمين
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <h5 class="card-title mb-0 col-sm-8 col-md-10"> قائمة المستخدمين ({{ $role->name }})</h5>
                                <!-- Load More Buttons -->

                                <div class="hstack flex-wrap gap-2   mb-lg-0 mb-0 col-sm-2 col-md-1">
                                    <a href="{{ route('user.create') }}" class="btn btn-outline-secondary btn-load">
                                        <span class="d-flex align-items-center">
                                            <span class="spinner-grow flex-shrink-0" role="status">
                                                <span class="visually-hidden">+</span>
                                            </span>
                                            <span class="flex-grow-1 ms-2">
                                                +
                                            </span>
                                        </span>
                                    </a>
                                </div>

                                <button type="submit"
                                    class="btn btn-outline-primary mb-0 col-sm-2 col-md-1 btn-icon waves-effect waves-light"
                                    id="refresh"><i class="ri-24-hours-fill"></i></button>

                                <div class="alert alert-secondary col-md-7 mx-auto alert-border-left alert-dismissible fade show"
                                    role="alert" id="alert" style="display: none">
                                    <i class="ri-check-double-line me-3 align-middle"></i> <strong id="strong"></strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body" style="overflow:auto">
                            <table id="alternative-pagination"
                                class="table nowrap dt-responsive align-middle table-hover table-bordered"
                                style="width:100%;overflow: scroll">
                                <thead>
                                    <tr>
                                        <th>#SSL</th>
                                        <th>اسم المستخدم</th>
                                        <th>البريد الالكترونى</th>
                                  
                                        <th>التحكم</th>
                                        <th>تم الانشاء فى</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div>
    </div>
@endsection
@push('js')
    <script>
        var table = $('#alternative-pagination').DataTable({

            ajax: {
                url: '{{ route('user.datatable', $role->id) }}',
                error: function(xhr, error, thrown) {
                    if (xhr.status === 401) {
                        // Session expired, redirect to login
                        window.location.href = '/login';
                    } else {
                        // Handle other errors
                        console.error('AJAX error: ', error);
                    }
                }
            },
            columns: [{
                    'data': null,
                    render: function(data, type, row, meta) {
                        // 'meta.row' is the index number
                        return meta.row + 1;
                    }
                },

                {
                    'data': 'name'
                },

                {
                    'data': 'email'
                },





                {
                    'data': null,
                    render: function(data) {
                        var editUrl = '{{ route('user.edit', ':id') }}';
                        editUrl = editUrl.replace(':id', data.id);

                        var editButton = '<a href="' + editUrl +
                            '" class="mx-1"> <i class="bx bxs-edit btn btn-warning"></i></a>';

                        var deleteUrl = '{{ route('user.delete', ':id') }}';
                        deleteUrl = deleteUrl.replace(':id', data.id);

                        var deleteButton =
                            '<a href="javascript:void(0);" class="mx-1" onclick="confirmDeletion(\'' +
                            deleteUrl + '\')"> <i class="bx bx-trash btn btn-danger"></i></a>';

                        // If the authenticated user's ID is not 1, or the row user ID is 1, only show the edit button
                        if ({{ auth()->user()->id }} != 1 || data.id == 1) {
                            return editButton;
                        } else {
                            return editButton + deleteButton;
                        }
                    }
                },

                {
                    'data': 'created_at',
                    render: function(data, type, row) {
                        // Parse the date string
                        var date = new Date(data);

                        // Check if the date is valid
                        if (!isNaN(date.getTime())) {
                            // Format the date as 'YYYY-MM-DD'
                            var year = date.getFullYear();
                            var month = (date.getMonth() + 1).toString().padStart(2,
                                '0'); // Months are zero-based
                            var day = date.getDate().toString().padStart(2, '0');

                            return year + '-' + month + '-' + day;
                        } else {
                            return 'لا يجود بيانات'; // Handle invalid date strings
                        }
                    }

                },
            ]
        });
    </script>
@endpush
