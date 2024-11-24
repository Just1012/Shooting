@extends('layouts.web')
@push('css')
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush
@section('title')
    Brands
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <h5 class="card-title mb-0 col-sm-8 col-md-10">Brands</h5>

                                <div class="hstack flex-wrap gap-2 mb-lg-0 mb-0 col-sm-2 col-md-1">
                                    <a href="{{ route('brand.addBrand') }}" class="btn btn-outline-secondary btn-load">
                                        <span class="d-flex align-items-center">
                                            <span class="spinner-grow flex-shrink-0" role="status">
                                                <span class="visually-hidden">+</span>
                                            </span>
                                            <span class="flex-grow-1 ms-2">+</span>
                                        </span>
                                    </a>
                                </div>

                                <button type="submit"
                                    class="btn btn-outline-primary mb-0 col-sm-2 col-md-1 btn-icon waves-effect waves-light"
                                    id="refresh"><i class="ri-24-hours-fill"></i></button>

                                <div class="alert alert-secondary col-md-7 mx-auto alert-border-left alert-dismissible fade show"
                                    role="alert" id="alert" style="display: none">
                                    <i class="ri-check-double-line me-3 align-middle"></i>
                                    <strong id="strong"></strong>
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
                                        <th>Main Image</th>
                                        <th>Brand Name</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center"></tbody>
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
            ajax: '{{ route('brand.dataTable') }}',
            columns: [{
                    'data': null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1; // Row numbering
                    }
                },
                {
                    'data': null,
                    render: function(data) {
                        const filePath = `{{ asset('images') }}/${data.image}`;
                        const fileExtension = filePath.split('.').pop().toLowerCase();

                        if (['jpeg', 'jpg', 'png', 'gif', 'svg'].includes(fileExtension)) {
                            return `<img src="${filePath}" class="small-image" style="height: 50px; width: 50px" onclick="openFullScreen('${filePath}', 'image')">`;
                        } else if (['mp4', 'avi', 'mov'].includes(fileExtension)) {
                            return `<video class="small-video" style="height: 50px; width: 50px" onclick="openFullScreen('${filePath}', 'video')" controls>
                                        <source src="${filePath}" type="video/${fileExtension}">
                                        Your browser does not support the video tag.
                                    </video>`;
                        } else {
                            return `<span>Unsupported format</span>`;
                        }
                    }
                },
                {
                    'data': null,
                    render: function(data) {
                        var name = '{{ App::getLocale() == 'ar' ? 'brand_name_ar' : 'brand_name_en' }}';
                        return data[name];
                    }
                },

                {
                    'data': 'priority'
                },


                {
                    'data': null,
                    render: function(data) {
                        return `<label class="switch">
                                    <input type="checkbox" data-id="${data.id}" id="status" ${data.status == 1 ? 'checked' : ''}>
                                    <span class="slider round"></span>
                                </label>`;
                    }
                },
                {
                    'data': null,
                    render: function(data) {
                        var editUrl = '{{ route('brand.edit', ':id') }}'.replace(':id', data.id);
                        var detailsUrl = '{{ route('brandDetails', ':id') }}'.replace(':id', data.id);
                        var deleteUrl = '{{ route('brand.delete', ':id') }}'.replace(':id', data.id);

                        return `<a href="${detailsUrl}" class="mx-1"> <i class="bx bxs-detail btn btn-success"></i></a>
                        <a href="${editUrl}" class="mx-1"> <i class="bx bxs-edit btn btn-warning"></i></a>
                                <a href="javascript:void(0);" class="mx-1" onclick="confirmDeletion('${deleteUrl}')">
                                    <i class="bx bx-trash btn btn-danger"></i>
                                </a>`;
                    }
                },
                {
                    'data': 'created_at',
                    render: function(data) {
                        var date = new Date(data);
                        return !isNaN(date.getTime()) ? date.toISOString().split('T')[0] : 'Invalid Date';
                    }
                }
            ]
        });

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

        function openFullScreen(filePath, type) {
            const fullScreenContainer = document.createElement('div');
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

            const closeButton = document.createElement('button');
            closeButton.innerText = '×';
            closeButton.style.cssText = `
                position: absolute;
                top: 20px;
                right: 20px;
                color: white;
                font-size: 30px;
                background: none;
                border: none;
                cursor: pointer;
            `;
            closeButton.addEventListener('click', () => document.body.removeChild(fullScreenContainer));

            fullScreenContainer.appendChild(content);
            fullScreenContainer.appendChild(closeButton);
            document.body.appendChild(fullScreenContainer);
        }

        $('#refresh').on('click', function() {
            $('#alert').hide();
            table.ajax.reload();
        });
    </script>
    <script>
        $(document).on('click', '#status', function() {
            var url = '{{ route('brand.status', ':id') }}';
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
@endpush
