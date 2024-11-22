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
    {{ __('messages.sliderSection') }}
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
                                    {{ __('messages.sliderSection') }}
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
                                                    <h4 class="mb-3">{{ __('messages.confirmDelete') }}</h4>
                                                    <p class="text-muted mb-4">{{ __('messages.deleteWarning') }}</p>
                                                    <div class="hstack gap-2 justify-content-center">
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-link link-success fw-medium"
                                                            data-bs-dismiss="modal"><i
                                                                class="ri-close-line me-1 align-middle"></i>
                                                            {{ __('messages.close') }}</a>
                                                        <a href="#" id="delete-confirm"
                                                            class="btn btn-danger">{{ __('messages.delete') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                <!-- Load More Buttons -->
                                <div class="hstack flex-wrap gap-2   mb-lg-0 mb-0 col-sm-2 col-md-1">
                                    <a href="{{ route('slider.addSlider') }}" class="btn btn-outline-secondary btn-load">
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
                                        <th>{{ __('messages.ssl') }}</th>
                                        <th>{{ __('messages.image') }}</th>
                                        <th>{{ __('messages.status') }}</th>
                                        <th>{{ __('messages.action') }}</th>
                                        <th>{{ __('messages.createdAt') }}</th>
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
            ajax: '{{ route('slider.dataTable') }}',
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
                        // Construct the file path
                        const filePath = `{{ asset('images') }}/${data.image_ar}`;
                        const fileExtension = filePath.split('.').pop().toLowerCase();

                        // Determine whether to render an image or a video
                        if (['jpeg', 'jpg', 'png', 'gif', 'svg'].includes(fileExtension)) {
                            // Render an image
                            return `<img src="${filePath}" class="small-image" style="height: 50px; width: 50px" onclick="openFullScreen('${filePath}', 'image')">`;
                        } else if (['mp4', 'avi', 'mov'].includes(fileExtension)) {
                            // Render a video with play controls
                            return `<video class="small-video" style="height: 50px; width: 50px" onclick="openFullScreen('${filePath}', 'video')" controls>
                        <source src="${filePath}" type="video/${fileExtension}">
                        Your browser does not support the video tag.
                    </video>`;
                        } else {
                            // If the file type is unknown, display a placeholder
                            return `<span>Unsupported format</span>`;
                        }
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
                        var editUrl = '{{ route('slider.edit', ':id') }}';
                        editUrl = editUrl.replace(':id', data.id);

                        var editButton = '<a href="' + editUrl +
                            '" class="mx-1"> <i class="bx bxs-edit btn btn-warning"></i></a>';

                        var deleteUrl = '{{ route('slider.delete', ':id') }}';
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
            var url = '{{ route('slider.status', ':id') }}';
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
    <script>
        function openFullScreen(filePath, type) {
            // Create a container for the full-screen view
            const fullScreenContainer = document.createElement('div');
            fullScreenContainer.className = 'fullscreen-container';
            fullScreenContainer.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.8);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 9999;
            `;

            // Create the content (image or video)
            let content;
            if (type === 'image') {
                content = document.createElement('img');
                content.src = filePath;
                content.style.cssText = 'max-width: 90%; max-height: 90%;';
            } else if (type === 'video') {
                content = document.createElement('video');
                content.src = filePath;
                content.controls = true;
                content.autoplay = true;
                content.style.cssText = 'max-width: 90%; max-height: 90%;';
            }

            // Append the content to the container
            fullScreenContainer.appendChild(content);

            // Close the full-screen view on click
            fullScreenContainer.addEventListener('click', () => {
                document.body.removeChild(fullScreenContainer);
            });

            // Append the container to the body
            document.body.appendChild(fullScreenContainer);
        }
    </script>
@endpush
