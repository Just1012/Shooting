@extends('layouts.web')
@push('css')
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Bootstrap Css -->
@endpush
@section('title')
    Photography Image
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <h5 class="card-title mb-0 col-sm-8 col-md-10">
                                    Photography Image
                                </h5>
                                <div id="topmodal" class="modal fade" tabindex="-1" aria-hidden="true"
                                    style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body text-center p-5">
                                                <lord-icon src="https://cdn.lordicon.com/skkahier.json" trigger="loop"
                                                    colors="primary:#eb4034,secondary:#eb4034"
                                                    style="width:120px;height:120px">
                                                </lord-icon>
                                                <div class="mt-4">
                                                    <h4 class="mb-3">Are you sure to delete this partner ?</h4>
                                                    <p class="text-muted mb-4"> If You Deleted It You Can't Restore It .</p>
                                                    <div class="hstack gap-2 justify-content-center">
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-link link-success fw-medium"
                                                            data-bs-dismiss="modal"><i
                                                                class="ri-close-line me-1 align-middle"></i>
                                                            Close</a>
                                                        <a href="#" id="delete-confirm"
                                                            class="btn btn-danger">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                <!-- Load More Buttons -->
                                <div class="hstack flex-wrap gap-2   mb-lg-0 mb-0 col-sm-2 col-md-1">
                                    <a href="{{ route('photography.addPhotography') }}" class="btn btn-outline-secondary btn-load">
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
                                        <th>Image</th>
                                        <th>Age</th>
                                        <th>Weight</th>
                                        <th>height</th>
                                        <th>Model Number</th>
                                        <th>Action</th>
                                        <th>Created At</th>
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
            ajax: '{{ route('photography.dataTable') }}',
            columns: [{
                    'data': null,
                    render: function(data, type, row, meta) {
                        // 'meta.row' is the index number
                        return meta.row + 1;
                    }
                },

                {
                    'data': null,
                    render: function(data, row) {
                        return `<img src="{{ asset('images') }}/${data.image}"
                                class="small-image" style="height: 50px; width: 50px" onclick="openFullScreen(this)">`;
                    }
                },

                {
                    'data': 'age'
                },
                {
                    'data': 'weight'
                },
                {
                    'data': 'height'
                },
                {
                    'data': 'model_number'
                },

                {
                    'data': null,
                    render: function(data) {
                        var editUrl = '{{ route('photography.edit', ':id') }}';
                        editUrl = editUrl.replace(':id', data.id);

                        var editButton = '<a href="' + editUrl +
                            '" class="mx-1"> <i class="bx bxs-edit btn btn-warning"></i></a>';

                        var deleteUrl = '{{ route('photography.delete', ':id') }}';
                        deleteUrl = deleteUrl.replace(':id', data.id);

                        var deleteButton =
                            '<a href="javascript:void(0);" class="mx-1" onclick="confirmDeletion(\'' +
                            deleteUrl + '\')"> <i class="bx bx-trash btn btn-danger"></i></a>';


                        return editButton + deleteButton;
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

    <script>
        function confirmDeletion(deleteUrl) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).on('click', '#status', function() {
            var url = '{{ route('photography.status', ':id') }}';
            url = url.replace(':id', $(this).data('id'));

            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    // Evaluate the toastr script from the server response
                    eval(response.toastrScript);
                    table.ajax.reload();
                },
                error: function(response) {
                    toastr.error('أعد المحاولة', 'خطأ !');
                    table.ajax.reload();
                }
            });
        });

        $('#refresh').on('click', function() {
            $('#alert').css('display', 'none');
            table.ajax.reload();
        });
    </script>

    <script>
        function openFullScreen(image) {
            var fullScreenContainer = document.createElement('div');
            fullScreenContainer.className = 'fullscreen-image';

            var fullScreenImage = document.createElement('img');
            fullScreenImage.src = image.src;

            fullScreenContainer.appendChild(fullScreenImage);
            document.body.appendChild(fullScreenContainer);

            fullScreenContainer.addEventListener('click', function() {
                document.body.removeChild(fullScreenContainer);
            });
        }
    </script>
@endpush
