@extends('layouts.web')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endpush
@section('title')
    System SetUp
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
                        <h4 class="card-title mb-0">System SetUp</h4>
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

                                <form action="{{ route('updateSystemSetup') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="imageInput" class="form-label">Header Logo</label>
                                                <input type="file"
                                                    data-default-file="{{ $systemSetup ? asset('images/' . $systemSetup->header_logo) : '' }}"
                                                    class="form-control dropify" data-height="100" id="imageInput"
                                                    accept="image/*" name="header_logo">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="imageInput" class="form-label">Footer Gif </label>
                                                <input type="file"
                                                    data-default-file="{{ $systemSetup ? asset('images/' . $systemSetup->footer_gif) : '' }}"
                                                    class="form-control dropify" data-height="100" id="imageInput"
                                                    accept="image/*" name="footer_gif">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="imageInput" class="form-label">Footer Logo</label>
                                                <input type="file"
                                                    data-default-file="{{ $systemSetup ? asset('images/' . $systemSetup->footer_logo) : '' }}"
                                                    class="form-control dropify" data-height="100" id="imageInput"
                                                    accept="image/*" name="footer_logo">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Footer Quote Ar</label>
                                                <textarea class="form-control" name="footer_quote_ar" placeholder="Footer Quote Ar" rows="4"
                                                    id="myeditorinstance">{{ $systemSetup->footer_quote_ar ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Footer Quote En</label>
                                                <textarea class="form-control" name="footer_quote_en" placeholder="Footer Quote En" rows="4"
                                                    id="myeditorinstance">{{ $systemSetup->footer_quote_en ?? '' }}</textarea>
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
