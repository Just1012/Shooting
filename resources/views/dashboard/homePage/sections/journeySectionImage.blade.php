@extends('layouts.web')

@push('css')
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endpush

@section('title')
    Image List
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
                                    Image List
                                </h5>

                                {{-- Add Modal --}}
                                <div id="topmodal" class="modal fade" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body text-center p-5">
                                                <div class="mt-4">
                                                    <form action="{{ route('journeyImage.store') }}" method="POST"
                                                        id="addForm">
                                                        @csrf
                                                        <h4 class="mb-3">Add New Image</h4>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="address1ControlTextarea"
                                                                        class="form-label">Upload Image</label>
                                                                    <input type="file" class="form-control dropify"
                                                                        name="image" id="address1ControlTextarea">
                                                                </div>
                                                            </div><!--end col-->
                                                        </div>
                                                        <div class="hstack gap-2 justify-content-center">
                                                            <button type="submit" class="btn btn-primary">Add</button>
                                                            <a href="javascript:void(0);"
                                                                class="btn btn-link link-success fw-medium"
                                                                data-bs-dismiss="modal">
                                                                <i class="ri-close-line me-1 align-middle"></i> Close
                                                            </a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Edit Modal --}}
                                <div id="edit" class="modal fade" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body text-center p-5">
                                                <div class="mt-4">
                                                    <form action="" method="POST" id="editForm"
                                                        enctype="multipart/form-data">
                                                        @csrf

                                                        <h4 class="mb-3">Edit Image</h4>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="editImage" class="form-label">Upload
                                                                        Image</label>
                                                                    <input type="file" class="form-control dropify"
                                                                        name="image" id="editImage" data-default-file="">

                                                                </div>
                                                            </div><!--end col-->
                                                        </div>
                                                        <div class="hstack gap-2 justify-content-center">
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                            <a href="javascript:void(0);"
                                                                class="btn btn-link link-success fw-medium"
                                                                data-bs-dismiss="modal">
                                                                <i class="ri-close-line me-1 align-middle"></i> Close
                                                            </a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Add Button -->
                                <div class="hstack flex-wrap gap-2 mb-lg-0 mb-0 col-sm-2 col-md-1">
                                    <a href="javascript:void(0);" class="btn btn-outline-secondary btn-load"
                                        data-bs-toggle="modal" data-bs-target="#topmodal">
                                        <span class="d-flex align-items-center">
                                            <span class="spinner-grow flex-shrink-0" role="status">
                                                <span class="visually-hidden">+</span>
                                            </span>
                                            <span class="flex-grow-1 ms-2">+</span>
                                        </span>
                                    </a>
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
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <script>
        $('.dropify').dropify({
            messages: {
                'default': 'Drag and drop a file here or click',
                'replace': 'Drag and drop or click to replace',
                'remove': 'Remove',
                'error': 'Ooops, something wrong happened.'
            }
        });
    </script>

    <script>
        var table = $('#alternative-pagination').DataTable({
            ajax: '{{ route('journeyImage.dataTable') }}',
            columns: [{
                    'data': null,
                    render: function(data, type, row, meta) {
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
                    'data': null,
                    render: function(data, row, type) {
                        if (data.status == 1) {
                            return `<label class="switch">
                                         <input type="checkbox" data-id="${data.id}" id="status" checked>
                                         <span class="slider round"></span>
                                    </label>`

                        } else {
                            return `<label class="switch">
                                         <input type="checkbox" data-id="${data.id}" id="status">
                                         <span class="slider round"></span>
                                    </label>`
                        }
                    }
                },

                {
                    'data': null,
                    render: function(data) {
                        var editButton =
                            '<a href="javascript:void(0);" class="mx-1" onclick="openEditModal(' + data.id +
                            ', \'' + data.image +
                            '\')"> <i class="bx bxs-edit btn btn-warning"></i></a>';

                        var deleteUrl = '{{ route('journeyImage.delete', ':id') }}';
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
                        var date = new Date(data);
                        if (!isNaN(date.getTime())) {
                            var year = date.getFullYear();
                            var month = (date.getMonth() + 1).toString().padStart(2, '0');
                            var day = date.getDate().toString().padStart(2, '0');
                            return year + '-' + month + '-' + day;
                        } else {
                            return 'لا يجود بيانات'; // Handle invalid date strings
                        }
                    }
                },
            ]
        });

        // Add Image via AJAX
        $('#addForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var actionUrl = $(this).attr('action');
            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#topmodal').modal('hide');
                    Swal.fire({
                        title: 'Success!',
                        text: 'Image added successfully.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    $('#alternative-pagination').DataTable().ajax.reload(null, false);
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while adding the image.',
                        icon: 'error',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        });

        // Edit Image via AJAX
        $('#editForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            var formData = new FormData(this); // Get form data
            var actionUrl = $(this).attr('action'); // Get the form action URL

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                contentType: false, // Required for FormData
                processData: false, // Required for FormData
                success: function(response) {
                    // Hide the modal on success
                    $('#edit').modal('hide');

                    // Display success message
                    Swal.fire({
                        title: 'Success!',
                        text: 'Image updated successfully.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    // Reload the table to reflect changes
                    $('#alternative-pagination').DataTable().ajax.reload(null, false);
                },
                error: function(xhr) {
                    // Display error message
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while updating the image.',
                        icon: 'error',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        });

        // Open Edit Modal
        function openEditModal(id, image) {
            $('#edit input[name="image"]').attr('data-default-file', "{{ asset('images/') }}/" + image);

            $('.dropify').dropify({
                messages: {
                    'default': 'Drag and drop a file here or click',
                    'replace': 'Drag and drop or click to replace',
                    'remove': 'Remove',
                    'error': 'Ooops, something wrong happened.'
                }
            }).dropify();

            $('#editForm').attr('action', '{{ route('journeyImage.update', ':id') }}'.replace(':id', id));
            $('#edit').modal('show');
        }

        // Reset modals on close
        $('#edit').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
        });
        $('#topmodal').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
        });

        // Confirm Deletion via AJAX
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
                    $.ajax({
                        url: deleteUrl,
                        type: 'GET',
                        success: function(response) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Image deleted successfully.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            $('#alternative-pagination').DataTable().ajax.reload(null, false);
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'An error occurred while deleting the image.',
                                icon: 'error',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    });
                }
            });
        }

        // Toggle Status
        $(document).on('click', '#status', function() {
            var url = '{{ route('journeyImage.status', ':id') }}';
            url = url.replace(':id', $(this).data('id'));

            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    eval(response.toastrScript);
                    table.ajax.reload();
                },
                error: function(response) {
                    toastr.error('أعد المحاولة', 'خطأ !');
                    table.ajax.reload();
                }
            });
        });

        // Refresh table
        $('#refresh').on('click', function() {
            $('#alert').css('display', 'none');
            table.ajax.reload();
        });

        // Open full screen for image
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
