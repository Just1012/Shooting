@extends('layouts.web')
@push('css')
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('title')
    Blog List
@endsection

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <h5 class="card-title mb-0 col-sm-8 col-md-10">Blog List</h5>
                                <div class="hstack flex-wrap gap-2 mb-lg-0 mb-0 col-sm-2 col-md-1">
                                    {{-- <a href="{{ route('blog.addBlog') }}" class="btn btn-outline-secondary btn-load">
                                        <span class="d-flex align-items-center">
                                            <span class="spinner-grow flex-shrink-0" role="status">
                                                <span class="visually-hidden">+</span>
                                            </span>
                                            <span class="flex-grow-1 ms-2">+</span>
                                        </span>
                                    </a> --}}
                                </div>
                                <button type="submit"
                                    class="btn btn-outline-primary mb-0 col-sm-2 col-md-1 btn-icon waves-effect waves-light"
                                    id="refresh">
                                    <i class="ri-24-hours-fill"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Filter Links -->
                        <div class="card-header d-flex gap-3">

                            <a href="{{ route('blog.index') }}"
                                class="btn btn-primary">{{ App::getLocale() == 'ar' ? 'العودة' : 'Back' }}</a>

                        </div>

                        <div class="card-body" style="overflow:auto">
                            <table id="alternative-pagination"
                                class="table nowrap dt-responsive align-middle table-hover table-bordered"
                                style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>#SSL</th>
                                        <th>Thumbnail</th>
                                        <th>Title</th>
                                        <th>Categories</th>
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
    <script>
        var table;

        function initDataTable(status = '') {
            if (table) {
                table.destroy();
            }
            table = $('#alternative-pagination').DataTable({
                ajax: {
                    url: '{{ route('blog.getBlogForTrash') }}',
                    data: function(d) {
                        d.status = status; // Pass the selected status for filtering
                    },
                    dataSrc: 'data'
                },
                columns: [{
                        'data': null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        'data': 'thumbnail',
                        render: function(data) {
                            return `<img src="${data}" class="small-image" style="height: 50px; width: 50px" onclick="openFullScreen(this)">`;
                        }
                    },
                    {
                        'data': 'title'
                    },
                    {
                        'data': 'categories',
                        render: function(categories) {
                            if (Array.isArray(categories) && categories.length > 0) {
                                return categories.map(name =>
                                    `<span class="badge bg-secondary">${name}</span>`).join(' ');
                            } else {
                                return `<span class="badge bg-secondary">N/A</span>`;
                            }
                        }
                    },

                    {
                        'data': null,
                        render: function(data) {
                            const editUrl = '{{ route('blog.restoreBlog', ':id') }}'.replace(':id', data
                            .id);
                            const deleteUrl = '{{ route('blog.delete', ':id') }}'.replace(':id', data.id);
                            return `<a href="${editUrl}" class="mx-1"><i class="bx bx-revision btn btn-primary"></i></a>
                                    <a href="javascript:void(0);" class="mx-1" onclick="confirmDeletion('${deleteUrl}')">
                                        <i class="bx bx-trash btn btn-danger"></i></a>`;
                        }
                    },

                    {
                        'data': 'created_at'
                    }
                ]
            });
        }

        function filterByStatus(status) {
            initDataTable(status);
        }



        function confirmDeletion(deleteUrl) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        }

        $(document).ready(function() {
            initDataTable();
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
@endpush
