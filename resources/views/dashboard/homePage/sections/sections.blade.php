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

                                <form action="{{ route('updateHomeSection') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Header Section Ar</label>
                                                <textarea class="form-control" name="header_section_ar" rows="4" id="myeditorinstance">{{ $sections->header_section_ar ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Header Section
                                                    En</label>
                                                <textarea class="form-control" name="header_section_en" rows="4" id="myeditorinstance">{{ $sections->header_section_en ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Goals Section Title
                                                    Ar</label>
                                                <input type="text" class="form-control" name="goals_title_ar"
                                                    value="{{ $sections->goals_title_ar ?? '' }}" id="titleEnTextarea"
                                                    required>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Goals Section Title
                                                    En</label>
                                                <input type="text" class="form-control" name="goals_title_en"
                                                    value="{{ $sections->goals_title_en ?? '' }}" id="titleEnTextarea"
                                                    required>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Goals Description Ar</label>
                                                <textarea class="form-control" name="goals_desc_ar" rows="4" id="myeditorinstance">{{ $sections->goals_desc_ar ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Goals Description
                                                    En</label>
                                                <textarea class="form-control" name="goals_desc_en" rows="4" id="myeditorinstance">{{ $sections->goals_desc_en ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="imageInput" class="form-label">Goals Section Image</label>
                                                <input type="file"
                                                    data-default-file="{{ $sections ? asset('images/' . $sections->goals_image) : '' }}"
                                                    class="form-control dropify" data-height="100" id="imageInput"
                                                    accept="image/*" name="goals_image">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Vision Section Title
                                                    Ar</label>
                                                <input type="text" class="form-control" name="vision_title_ar"
                                                    value="{{ $sections->vision_title_ar ?? '' }}" id="titleEnTextarea"
                                                    required>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Vision Section Title
                                                    En</label>
                                                <input type="text" class="form-control" name="vision_title_en"
                                                    value="{{ $sections->vision_title_en ?? '' }}" id="titleEnTextarea"
                                                    required>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Vision Description
                                                    Ar</label>
                                                <textarea class="form-control" name="vision_desc_ar" rows="4" id="myeditorinstance">{{ $sections->vision_desc_ar ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Vision Section Description
                                                    En</label>
                                                <textarea class="form-control" name="vision_desc_en" rows="4" id="myeditorinstance">{{ $sections->vision_desc_en ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="imageInput" class="form-label">Vision Section Image</label>
                                                <input type="file"
                                                    data-default-file="{{ $sections ? asset('images/' . $sections->vision_image) : '' }}"
                                                    class="form-control dropify" data-height="100" id="imageInput"
                                                    accept="image/*" name="vision_image">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Journey Section Title
                                                    Ar</label>
                                                <input type="text" class="form-control" name="journey_title_ar"
                                                    value="{{ $sections->journey_title_ar ?? '' }}" id="titleEnTextarea"
                                                    required>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Journey Section Title
                                                    En</label>
                                                <input type="text" class="form-control" name="journey_title_en"
                                                    value="{{ $sections->journey_title_en ?? '' }}" id="titleEnTextarea"
                                                    required>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Journey Description
                                                    Ar</label>
                                                <textarea class="form-control" name="journey_desc_ar" rows="4" id="myeditorinstance">{{ $sections->journey_desc_ar ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Journey Section
                                                    Description
                                                    En</label>
                                                <textarea class="form-control" name="journey_desc_en" rows="4" id="myeditorinstance">{{ $sections->journey_desc_en ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="imageInput" class="form-label">Journey Section Image</label>
                                                <input type="file"
                                                    data-default-file="{{ $sections ? asset('images/' . $sections->journey_image) : '' }}"
                                                    class="form-control dropify" data-height="100" id="imageInput"
                                                    accept="image/*" name="journey_image">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Team Section Title
                                                    Ar</label>
                                                <input type="text" class="form-control" name="team_title_ar"
                                                    value="{{ $sections->team_title_ar ?? '' }}" id="titleEnTextarea"
                                                    required>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Team Section Title
                                                    En</label>
                                                <input type="text" class="form-control" name="team_title_en"
                                                    value="{{ $sections->team_title_en ?? '' }}" id="titleEnTextarea"
                                                    required>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Team Description
                                                    Ar</label>
                                                <textarea class="form-control" name="team_desc_ar" rows="4" id="myeditorinstance">{{ $sections->team_desc_ar ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Team Section Description
                                                    En</label>
                                                <textarea class="form-control" name="team_desc_en" rows="4" id="myeditorinstance">{{ $sections->team_desc_en ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
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
