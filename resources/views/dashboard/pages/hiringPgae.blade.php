@extends('layouts.web')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endpush
@section('title')
    Hiring & Training Page
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
                        <h4 class="card-title mb-0">Hiring & Training Page</h4>
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

                                <form action="{{ route('updateHiringPage') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Head Sentence Ar</label>
                                                <input type="text" class="form-control" name="head_sentence_ar"
                                                    value="{{ $hiringPage->head_sentence_ar ?? '' }}"
                                                    placeholder="Head Sentence Ar" id="titleEnTextarea" required>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Head Sentence En</label>
                                                <input type="text" class="form-control" name="head_sentence_en"
                                                    value="{{ $hiringPage->head_sentence_en ?? '' }}"
                                                    placeholder="Head Sentence En" id="titleEnTextarea" required>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Welcome Title Ar</label>
                                                <input type="text" class="form-control" name="welcome_title_ar"
                                                    value="{{ $hiringPage->welcome_title_ar ?? '' }}"
                                                    placeholder="Welcome Title Ar" id="titleEnTextarea" required>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Welcome Title En</label>
                                                <input type="text" class="form-control" name="welcome_title_en"
                                                    value="{{ $hiringPage->welcome_title_en ?? '' }}"
                                                    placeholder="Welcome Title En" id="titleEnTextarea" required>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Hiring Title Ar</label>
                                                <input type="text" class="form-control" name="hiring_title_ar"
                                                    value="{{ $hiringPage->hiring_title_ar ?? '' }}"
                                                    placeholder="Hiring Title Ar" id="titleEnTextarea" required>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Hiring Title En</label>
                                                <input type="text" class="form-control" name="hiring_title_en"
                                                    value="{{ $hiringPage->hiring_title_en ?? '' }}"
                                                    placeholder="Hiring Title En" id="titleEnTextarea" required>
                                            </div>
                                        </div><!--end col-->


                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Hiring Description
                                                    Ar</label>
                                                <textarea class="form-control" name="hiring_desc_ar" placeholder="Hiring Description Ar" rows="4"
                                                    id="myeditorinstance">{{ $hiringPage->hiring_desc_ar ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Hiring Description
                                                    Ar</label>
                                                <textarea class="form-control" name="hiring_desc_en" placeholder="Hiring Description Ar" rows="4"
                                                    id="myeditorinstance">{{ $hiringPage->hiring_desc_en ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Training Title Ar</label>
                                                <input type="text" class="form-control" name="training_title_ar"
                                                    value="{{ $hiringPage->training_title_ar ?? '' }}"
                                                    placeholder="Training Title Ar" id="titleEnTextarea" required>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Training Title En</label>
                                                <input type="text" class="form-control" name="training_title_en"
                                                    value="{{ $hiringPage->training_title_en ?? '' }}"
                                                    placeholder="Training Title En" id="titleEnTextarea" required>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Training Description
                                                    Ar</label>
                                                <textarea class="form-control" name="training_desc_ar" placeholder="Training Description Ar" rows="4"
                                                    id="myeditorinstance">{{ $hiringPage->training_desc_ar ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Training Description
                                                    Ar</label>
                                                <textarea class="form-control" name="training_desc_en" placeholder="Training Description Ar" rows="4"
                                                    id="myeditorinstance">{{ $hiringPage->training_desc_en ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="imageInput" class="form-label">Image</label>
                                                <input type="file"
                                                    data-default-file="{{ $hiringPage ? asset('images/' . $hiringPage->image) : '' }}"
                                                    class="form-control dropify" data-height="100" id="imageInput"
                                                    accept="image/*" name="image">
                                            </div>
                                        </div>

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
