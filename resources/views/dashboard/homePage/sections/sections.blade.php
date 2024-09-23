@extends('layouts.web')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endpush
@section('title')
    {{ __('messages.sectionPage') }}
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
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">{{ __('messages.sectionPage') }}</h4>
                        <div class="card-body">
                            <div class="listjs-table" id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a class="btn btn-success add-btn" id="create-btn"
                                                href="{{ route('dashboard') }}">{{ __('messages.back') }}</a>
                                        </div>
                                    </div>
                                </div>

                                <form action="{{ route('updateHomeSection') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleArTextarea"
                                                    class="form-label">{{ __('messages.headerSectionAr') }}</label>
                                                <textarea class="form-control" name="header_section_ar" rows="4" id="myeditorinstance">{{ $sections->header_section_ar ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea"
                                                    class="form-label">{{ __('messages.headerSectionEn') }}</label>
                                                <textarea class="form-control" name="header_section_en" rows="4" id="myeditorinstance">{{ $sections->header_section_en ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="goalsTitleAr"
                                                    class="form-label">{{ __('messages.goalsTitleAr') }}</label>
                                                <input type="text" class="form-control" name="goals_title_ar"
                                                    value="{{ $sections->goals_title_ar ?? '' }}" id="goalsTitleAr"
                                                    required>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="goalsTitleEn"
                                                    class="form-label">{{ __('messages.goalsTitleEn') }}</label>
                                                <input type="text" class="form-control" name="goals_title_en"
                                                    value="{{ $sections->goals_title_en ?? '' }}" id="goalsTitleEn"
                                                    required>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="goalsDescAr"
                                                    class="form-label">{{ __('messages.goalsDescAr') }}</label>
                                                <textarea class="form-control" name="goals_desc_ar" rows="4" id="myeditorinstance">{{ $sections->goals_desc_ar ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="goalsDescEn"
                                                    class="form-label">{{ __('messages.goalsDescEn') }}</label>
                                                <textarea class="form-control" name="goals_desc_en" rows="4" id="myeditorinstance">{{ $sections->goals_desc_en ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="goalsImage"
                                                    class="form-label">{{ __('messages.goalsImage') }}</label>
                                                <input type="file"
                                                    data-default-file="{{ $sections ? asset('images/' . $sections->goals_image) : '' }}"
                                                    class="form-control dropify" data-height="100" id="goalsImage"
                                                    accept="image/*" name="goals_image">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="visionTitleAr"
                                                    class="form-label">{{ __('messages.visionTitleAr') }}</label>
                                                <input type="text" class="form-control" name="vision_title_ar"
                                                    value="{{ $sections->vision_title_ar ?? '' }}" id="visionTitleAr"
                                                    required>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="visionTitleEn"
                                                    class="form-label">{{ __('messages.visionTitleEn') }}</label>
                                                <input type="text" class="form-control" name="vision_title_en"
                                                    value="{{ $sections->vision_title_en ?? '' }}" id="visionTitleEn"
                                                    required>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="visionDescAr"
                                                    class="form-label">{{ __('messages.visionDescAr') }}</label>
                                                <textarea class="form-control" name="vision_desc_ar" rows="4" id="visionDescAr">{{ $sections->vision_desc_ar ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="visionDescEn"
                                                    class="form-label">{{ __('messages.visionDescEn') }}</label>
                                                <textarea class="form-control" name="vision_desc_en" rows="4" id="visionDescEn">{{ $sections->vision_desc_en ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="visionImage"
                                                    class="form-label">{{ __('messages.visionImage') }}</label>
                                                <input type="file"
                                                    data-default-file="{{ $sections ? asset('images/' . $sections->vision_image) : '' }}"
                                                    class="form-control dropify" data-height="100" id="visionImage"
                                                    accept="image/*" name="vision_image">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="journeyTitleAr"
                                                    class="form-label">{{ __('messages.journeyTitleAr') }}</label>
                                                <input type="text" class="form-control" name="journey_title_ar"
                                                    value="{{ $sections->journey_title_ar ?? '' }}" id="journeyTitleAr"
                                                    required>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="journeyTitleEn"
                                                    class="form-label">{{ __('messages.journeyTitleEn') }}</label>
                                                <input type="text" class="form-control" name="journey_title_en"
                                                    value="{{ $sections->journey_title_en ?? '' }}" id="journeyTitleEn"
                                                    required>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="journeyDescAr"
                                                    class="form-label">{{ __('messages.journeyDescAr') }}</label>
                                                <textarea class="form-control" name="journey_desc_ar" rows="4" id="myeditorinstance">{{ $sections->journey_desc_ar ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="journeyDescEn"
                                                    class="form-label">{{ __('messages.journeyDescEn') }}</label>
                                                <textarea class="form-control" name="journey_desc_en" rows="4" id="myeditorinstance">{{ $sections->journey_desc_en ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="journeyImage"
                                                    class="form-label">{{ __('messages.journeyImage') }}</label>
                                                <input type="file"
                                                    data-default-file="{{ $sections ? asset('images/' . $sections->journey_image) : '' }}"
                                                    class="form-control dropify" data-height="100" id="journeyImage"
                                                    accept="image/*" name="journey_image">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="teamTitleAr"
                                                    class="form-label">{{ __('messages.teamTitleAr') }}</label>
                                                <input type="text" class="form-control" name="team_title_ar"
                                                    value="{{ $sections->team_title_ar ?? '' }}" id="teamTitleAr"
                                                    required>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="teamTitleEn"
                                                    class="form-label">{{ __('messages.teamTitleEn') }}</label>
                                                <input type="text" class="form-control" name="team_title_en"
                                                    value="{{ $sections->team_title_en ?? '' }}" id="teamTitleEn"
                                                    required>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="teamDescAr"
                                                    class="form-label">{{ __('messages.teamDescAr') }}</label>
                                                <textarea class="form-control" name="team_desc_ar" rows="4" id="teamDescAr">{{ $sections->team_desc_ar ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="teamDescEn"
                                                    class="form-label">{{ __('messages.teamDescEn') }}</label>
                                                <textarea class="form-control" name="team_desc_en" rows="4" id="teamDescEn">{{ $sections->team_desc_en ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-lg-12">
                                            <div class="text-center">
                                                <button type="submit"
                                                    class="btn btn-primary">{{ __('messages.save') }}</button>
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
                'default': '{{ __('messages.dragDropDefault') }}',
                'replace': '{{ __('messages.dragDropReplace') }}',
                'remove': '{{ __('messages.dragDropRemove') }}',
                'error': '{{ __('messages.dragDropError') }}'
            }
        });
    </script>
@endpush
