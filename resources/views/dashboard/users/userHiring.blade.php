@extends('layouts.web')

@push('css')
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <!-- Buttons css -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
    User Register List
@endsection

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <h5 class="card-title mb-0 col-sm-8 col-md-10">User Register List</h5>
                                <div class="alert alert-secondary col-md-7 mx-auto alert-border-left alert-dismissible fade show"
                                    role="alert" id="alert" style="display: none"></div>
                            </div>
                        </div>
                        <div class="card-body" style="overflow:auto">
                            <table id="alternative-pagination"
                                class="table nowrap dt-responsive align-middle table-hover table-bordered"
                                style="width:100%;overflow: scroll">
                                <thead>
                                    <tr>
                                        <th>#SSL</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Section</th>
                                        <th>File</th>
                                        <th>Message</th>
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
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#alternative-pagination').DataTable({
                ajax: '{{ route('userHiring.dataTable') }}',
                columns: [{
                        'data': null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        'data': 'name',
                    },
                    {
                        'data': 'email',
                    },
                    {
                        'data': 'phone',
                    },
                    {
                        'data': null,
                        render: function(data) {
                            return data.section == 1 ? 'Hiring' : 'Training';
                        }
                    },
                    {
                        'data': 'file',
                        render: function(data, type, row) {
                            if (data) {
                                return `<a href="{{ asset('uploads/files') }}/${data}" target="_blank">Open File</a>`;
                            } else {
                                return 'No File';
                            }
                        }
                    },

                    {
                        'data': 'message',
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
                                return 'Invalid Date';
                            }
                        }
                    },
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        text: 'Export to Excel',
                        className: 'btn btn-success',
                        init: function(api, node, config) {
                            $(node).removeClass('dt-button');
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Export to PDF',
                        className: 'btn btn-danger',
                        init: function(api, node, config) {
                            $(node).removeClass('dt-button');
                        },
                        orientation: 'landscape',
                        pageSize: 'A4',
                        customize: function(doc) {
                            doc.content[1].table.widths = Array(doc.content[1].table.body[0]
                                .length + 1).join('*').split('');
                            var objLayout = {};
                            objLayout['hLineWidth'] = function(i) {
                                return 0.5;
                            };
                            objLayout['vLineWidth'] = function(i) {
                                return 0.5;
                            };
                            objLayout['hLineColor'] = function(i) {
                                return '#aaa';
                            };
                            objLayout['vLineColor'] = function(i) {
                                return '#aaa';
                            };
                            objLayout['paddingLeft'] = function(i) {
                                return 4;
                            };
                            objLayout['paddingRight'] = function(i) {
                                return 4;
                            };
                            objLayout['paddingTop'] = function(i) {
                                return 4;
                            };
                            objLayout['paddingBottom'] = function(i) {
                                return 4;
                            };
                            objLayout['fillColor'] = function(i) {
                                return (i % 2 === 0) ? '#F0F0F0' : null;
                            };
                            doc.content[1].layout = objLayout;

                            doc.styles.tableHeader.alignment = 'center';
                            doc.styles.tableBodyEven.alignment = 'center';
                            doc.styles.tableBodyOdd.alignment = 'center';
                        }
                    }
                ]
            });
        });
    </script>
@endpush
