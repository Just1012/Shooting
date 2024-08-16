@extends('layouts.web')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endpush
@section('title')
    service Page
@endsection
@section('content')
    <style>
        .dropify-wrapper .dropify-message p {
            font-size: 16px;
        }

        .dropify-wrapper .dropify-message .dropify-error {
            font-size: 16px;
        }

        .dropify-wrapper .dropify-clear,
        .dropify-wrapper .dropify-preview .dropify-render .dropify-infos .dropify-infos-inner .dropify-filename,
        .dropify-wrapper .dropify-preview .dropify-render .dropify-infos .dropify-infos-inner .dropify-infos-message {
            font-size: 16px;
        }

        textarea {
            height: 150px;
        }

        img {
            max-width: 200px;
        }
    </style>
    <div class="main-content">
        <div class="page-content">
            <div class="col-md-9 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title mb-0">service Page</h4>
                        <div class="card-body ">
                            <div class="listjs-table" id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a class="btn btn-success add-btn" id="create-btn"
                                                href="{{ route('dashboard') }}">Back</a>
                                        </div>
                                    </div>
                                </div>

                                <form action="{{ route('updateIndustry') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Main Title Ar</label>
                                                <input type="text" class="form-control" name="main_title_ar"
                                                    value="{{ $industry->main_title_ar ?? '' }}" placeholder="Main Title Ar"
                                                    id="titleEnTextarea" required>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Main Title En</label>
                                                <input type="text" class="form-control" name="main_title_en"
                                                    value="{{ $industry->main_title_en ?? '' }}" placeholder="Main Title En"
                                                    id="titleEnTextarea" required>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Description 1 Ar</label>
                                                <textarea class="form-control" name="desc_1_ar" placeholder="Description 1 Ar" rows="4" id="myeditorinstance">{{ $industry->desc_1_ar ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Description 2 En</label>
                                                <textarea class="form-control" name="desc_1_en" placeholder="Description 2 En" rows="4" id="myeditorinstance">{{ $industry->desc_1_en ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Description 2 Ar</label>
                                                <textarea class="form-control" name="desc_2_ar" placeholder="Description 2 Ar" rows="4" id="myeditorinstance">{{ $industry->desc_2_ar ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Description 2 En</label>
                                                <textarea class="form-control" name="desc_2_en" placeholder="Description 2 En" rows="4" id="myeditorinstance">{{ $industry->desc_2_en ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->



                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Secondary Title Ar</label>
                                                <input type="text" class="form-control" name="secondary_title_ar"
                                                    value="{{ $industry->secondary_title_ar ?? '' }}" placeholder="Secondary Title Ar"
                                                    id="titleEnTextarea" required>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Secondary Title En</label>
                                                <input type="text" class="form-control" name="secondary_title_en"
                                                    value="{{ $industry->secondary_title_en ?? '' }}" placeholder="Secondary Title En"
                                                    id="titleEnTextarea" required>
                                            </div>
                                        </div><!--end col-->


                                        @foreach (range(1, 5) as $i)
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="sector_{{ $i }}_ar" class="form-label">industry
                                                        {{ $i }} Ar</label>
                                                    <input type="text" class="form-control"
                                                        name="sector_{{ $i }}_ar"
                                                        value="{{ $industry->{'sector_' . $i . '_ar'} ?? '' }}"
                                                        id="sector_{{ $i }}_ar">
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="sector_{{ $i }}_en" class="form-label">industry
                                                        {{ $i }} En</label>
                                                    <input type="text" class="form-control"
                                                        name="sector_{{ $i }}_en"
                                                        value="{{ $industry->{'sector_' . $i . '_en'} ?? '' }}"
                                                        id="sector_{{ $i }}_en">
                                                </div>
                                            </div><!--end col-->
                                        @endforeach

                                        <div class="col-lg-12">
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div><!--end col-->
                                    </div>
                                </form>

                            </div>
                        </div><!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('web/assets/js/pages/select2.init.js') }}"></script>
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
@endpush
