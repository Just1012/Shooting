@extends('layouts.web')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endpush
@section('title')
    Brand Detals
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
                        <h4 class="card-title mb-0">Brand Detals</h4>
                        <div class="card-body ">
                            <div class="listjs-table" id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a class="btn btn-success add-btn" id="create-btn"
                                                href="{{ route('brand.index') }}">Back</a>
                                        </div>
                                    </div>
                                </div>

                                <form action="{{ route('brandDetailsUpdate', ['id' => $brand->id]) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="imageInput" class="form-label">Main Image</label>
                                                <input type="file"
                                                    data-default-file="{{ $brand ? asset('images/' . $brand->main_image) : '' }}"
                                                    class="form-control dropify" data-height="100" id="imageInput"
                                                    accept="image/*" name="main_image">
                                            </div>
                                        </div>
                                        @php
                                            // Define the default color as white (#ffffff)
                                            $defaultColor = '#ffffff';
                                        @endphp
                                        <!-- Title and Color Fields -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="title_color" class="form-label">Title Color</label>
                                                <input type="color"
                                                    value="{{ old('title_color', $brand->title_color ?? '#fff') }}"
                                                    class="form-control" name="title_color" id="title_color">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="title_back_color" class="form-label">Title Background
                                                    Color</label>
                                                <input type="color"
                                                    value="{{ old('title_back_color', $brand->title_back_color ?? $defaultColor) }}"
                                                    class="form-control" name="title_back_color" id="title_back_color">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="details_color" class="form-label">Details Color</label>
                                                <input type="color"
                                                    value="{{ old('details_color', $brand->details_color ?? '#fff') }}"
                                                    class="form-control" name="details_color" id="details_color">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="details_back_color" class="form-label">Details Background
                                                    Color</label>
                                                <input type="color"
                                                    value="{{ old('details_back_color', $brand->details_back_color ?? $defaultColor) }}"
                                                    class="form-control" name="details_back_color" id="details_back_color">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="imageInput" class="form-label">Image 1</label>
                                                <input type="file"
                                                    data-default-file="{{ $brand ? asset('images/' . $brand->image_1) : '' }}"
                                                    class="form-control dropify" data-height="100" id="imageInput"
                                                    accept="image/*" name="image_1">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="imageInput" class="form-label">Image 2</label>
                                                <input type="file"
                                                    data-default-file="{{ $brand ? asset('images/' . $brand->image_2) : '' }}"
                                                    class="form-control dropify" data-height="100" id="imageInput"
                                                    accept="image/*" name="image_2">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="imageInput" class="form-label">Image 3</label>
                                                <input type="file"
                                                    data-default-file="{{ $brand ? asset('images/' . $brand->image_3) : '' }}"
                                                    class="form-control dropify" data-height="100" id="imageInput"
                                                    accept="image/*" name="image_3">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="imageInput" class="form-label">Image 4</label>
                                                <input type="file"
                                                    data-default-file="{{ $brand ? asset('images/' . $brand->image_4) : '' }}"
                                                    class="form-control dropify" data-height="100" id="imageInput"
                                                    accept="image/*" name="image_4">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="imageInput" class="form-label">Image 5</label>
                                                <input type="file"
                                                    data-default-file="{{ $brand ? asset('images/' . $brand->image_5) : '' }}"
                                                    class="form-control dropify" data-height="100" id="imageInput"
                                                    accept="image/*" name="image_5">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="imageInput" class="form-label">Image 6</label>
                                                <input type="file"
                                                    data-default-file="{{ $brand ? asset('images/' . $brand->image_6) : '' }}"
                                                    class="form-control dropify" data-height="100" id="imageInput"
                                                    accept="image/*" name="image_6">
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
