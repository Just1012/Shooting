@extends('layouts.web')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
@endpush

@section('title')
    Dashboard
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Welcome To Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                {{-- <li class="breadcrumb-item active">Job Dashboard</li> --}}
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-12">
                    <div class="d-flex flex-column h-100">
                        <div class="row">
                            <div class="col-xl-6 col-md-6">
                                <div class="card card-animate overflow-hidden">
                                    <div class="position-absolute start-0" style="z-index: 0;">
                                        <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120"
                                            width="200" height="120">
                                            <style>
                                                .s0 {
                                                    opacity: .05;
                                                    fill: var(--vz-success)
                                                }
                                            </style>
                                            <path id="Shape 8" class="s0"
                                                d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z" />
                                        </svg>
                                    </div>
                                    @php
                                        $total_brand = App\Models\OurWork::count();
                                    @endphp
                                    <div class="card-body" style="z-index:1 ;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                    Total Brands</p>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
                                                        data-target="{{ $total_brand }}">0</span></h4>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div id="total_jobs" data-colors='["--vz-success"]' class="apex-charts"
                                                    dir="ltr"></div>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!--end col-->
                            <div class="col-xl-6 col-md-6">
                                <!-- card -->
                                <div class="card card-animate overflow-hidden">
                                    <div class="position-absolute start-0" style="z-index: 0;">
                                        <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120"
                                            width="200" height="120">
                                            <style>
                                                .s0 {
                                                    opacity: .05;
                                                    fill: var(--vz-success)
                                                }
                                            </style>
                                            <path id="Shape 8" class="s0"
                                                d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z" />
                                        </svg>
                                    </div>
                                    @php
                                        $total_partner = App\Models\Partner::count();
                                    @endphp
                                    <div class="card-body" style="z-index:1 ;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                    Total Partner</p>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
                                                        data-target="{{ $total_partner }}">0</span></h4>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div id="apply_jobs" data-colors='["--vz-success"]' class="apex-charts"
                                                    dir="ltr"></div>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                            <div class="col-xl-6 col-md-6">
                                <!-- card -->
                                <div class="card card-animate overflow-hidden">
                                    <div class="position-absolute start-0" style="z-index: 0;">
                                        <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120"
                                            width="200" height="120">
                                            <style>
                                                .s0 {
                                                    opacity: .05;
                                                    fill: var(--vz-success)
                                                }
                                            </style>
                                            <path id="Shape 8" class="s0"
                                                d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z" />
                                        </svg>
                                    </div>
                                    @php
                                        $total_hiring = App\Models\Hiring::count();
                                    @endphp
                                    <div class="card-body" style="z-index:1 ;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                   Total User Hiring</p>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
                                                        data-target="{{ $total_hiring }}">0</span></h4>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div id="new_jobs_chart" data-colors='["--vz-success"]' class="apex-charts"
                                                    dir="ltr"></div>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                            <div class="col-xl-6 col-md-6">
                                <!-- card -->
                                <div class="card card-animate overflow-hidden">
                                    <div class="position-absolute start-0" style="z-index: 0;">
                                        <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120"
                                            width="200" height="120">
                                            <style>
                                                .s0 {
                                                    opacity: .05;
                                                    fill: var(--vz-success)
                                                }
                                            </style>
                                            <path id="Shape 8" class="s0"
                                                d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z" />
                                        </svg>
                                    </div>
                                    @php
                                        $total_register = App\Models\UserRegister::count();
                                    @endphp
                                    <div class="card-body" style="z-index:1 ;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                    Total User Register</p>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span
                                                        class="counter-value" data-target="{{ $total_register }}">0</span></h4>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div id="interview_chart" data-colors='["--vz-danger"]'
                                                    class="apex-charts" dir="ltr"></div>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                            <div class="col-xl-6 col-md-6">
                                <div class="card card-animate overflow-hidden">
                                    <div class="position-absolute start-0" style="z-index: 0;">
                                        <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120"
                                            width="200" height="120">
                                            <style>
                                                .s0 {
                                                    opacity: .05;
                                                    fill: var(--vz-success)
                                                }
                                            </style>
                                            <path id="Shape 8" class="s0"
                                                d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z" />
                                        </svg>
                                    </div>
                                    @php
                                        $total_blog = App\Models\Blog::count();
                                    @endphp
                                    <div class="card-body" style="z-index:1 ;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                    Total Blogs</p>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span
                                                        class="counter-value" data-target="{{ $total_blog }}">0</span></h4>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div id="hired_chart" data-colors='["--vz-success"]' class="apex-charts"
                                                    dir="ltr"></div>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!--end col-->
                            <div class="col-xl-6 col-md-6">
                                <!-- card -->
                                <div class="card card-animate overflow-hidden">
                                    <div class="position-absolute start-0" style="z-index: 0;">
                                        <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120"
                                            width="200" height="120">
                                            <style>
                                                .s0 {
                                                    opacity: .05;
                                                    fill: var(--vz-success)
                                                }
                                            </style>
                                            <path id="Shape 8" class="s0"
                                                d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z" />
                                        </svg>
                                    </div>
                                    @php
                                        $total_published_blog = App\Models\Blog::where('status', 1)->count();
                                    @endphp
                                    <div class="card-body" style="z-index:1 ;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                    Total Published Blog</p>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span
                                                        class="counter-value" data-target="{{ $total_published_blog }}">0</span></h4>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div id="rejected_chart" data-colors='["--vz-danger"]'
                                                    class="apex-charts" dir="ltr"></div>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                        </div><!--end row-->
                    </div>
                </div><!--end col-->

            </div><!--end row-->
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
            toastr.success('أعد المحاولة', 'خطأ !');
        @endif
    </script>
@endpush
