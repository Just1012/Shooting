@extends('layouts.web')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endpush
@section('title')
    System Info
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
                        <h4 class="card-title mb-0">System Info</h4>
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

                                <form action="{{ route('updateSystemInfo') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Header Btn Link</label>
                                                <input type="text" class="form-control" name="header_btn_link"
                                                    value="{{ $systemInfo->header_btn_link ?? '' }}"
                                                    placeholder="Header Btn Link" id="titleEnTextarea" required>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Address Ar</label>
                                                <textarea class="form-control" name="address_ar" placeholder="Address Ar" rows="4" id="myeditorinstance">{{ $systemInfo->address_ar ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Address En</label>
                                                <textarea class="form-control" name="address_en" placeholder="Address En" rows="4" id="myeditorinstance">{{ $systemInfo->address_en ?? '' }}</textarea>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="phone" class="form-label">Phone</label>
                                                <input type="number" class="form-control" name="phone"
                                                    value="{{ $systemInfo->phone ?? '' }}"
                                                    placeholder="Phone No: +966557052333" id="phone" required>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="facebook" class="form-label">Facebook Link</label>
                                                <input type="text" class="form-control" name="facebook"
                                                    value="{{ $systemInfo->facebook ?? '' }}" placeholder="Facebook Link"
                                                    id="facebook" required>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="instagram" class="form-label">Instagram Link</label>
                                                <input type="text" class="form-control" name="instagram"
                                                    value="{{ $systemInfo->instagram ?? '' }}" placeholder="Instagram Link"
                                                    id="instagram" required>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="snapchat" class="form-label">Snapchat Link</label>
                                                <input type="text" class="form-control" name="snapchat"
                                                    value="{{ $systemInfo->snapchat ?? '' }}" placeholder="Snapchat Link"
                                                    id="snapchat" required>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="tiktok" class="form-label">Tiktok Link</label>
                                                <input type="text" class="form-control" name="tiktok"
                                                    value="{{ $systemInfo->tiktok ?? '' }}" placeholder="Tiktok Link"
                                                    id="tiktok" required>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="whatsapp" class="form-label">whatsapp Link</label>
                                                <input type="text" class="form-control" name="whatsapp"
                                                    value="{{ $systemInfo->whatsapp ?? '' }}" placeholder="Watsapp Link"
                                                    id="whatsapp" required>
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
