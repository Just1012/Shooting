@extends('layouts.web')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endpush
@section('title')
    Brand Details
@endsection
@section('content')
    <style>
        .dropify-wrapper .dropify-message p,
        .dropify-wrapper .dropify-message .dropify-error,
        .dropify-wrapper .dropify-clear,
        .dropify-wrapper .dropify-preview .dropify-render .dropify-infos .dropify-infos-inner .dropify-filename,
        .dropify-wrapper .dropify-preview .dropify-render .dropify-infos .dropify-infos-inner .dropify-infos-message {
            font-size: 16px;
        }
        textarea { height: 150px; }
        img { max-width: 200px; }
    </style>

    <div class="main-content">
        <div class="page-content">
            <div class="col-md-9 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Brand Details</h4>
                    </div>
                    <div class="card-body">
                        <a class="btn btn-success add-btn mb-3" href="{{ route('brand.index') }}">Back</a>
                        <form action="{{ route('brandDetailsUpdate', ['id' => $brandExists->our_work_id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                @php
                                    $defaultColor = '#ffffff';
                                @endphp

                                <!-- Title and Color Fields -->
                                @foreach(['title_color', 'title_back_color', 'details_color', 'details_back_color'] as $field)
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="{{ $field }}" class="form-label">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                                            <input type="color"
                                                value="{{ old($field, $brandExists->$field ?? $defaultColor) }}"
                                                class="form-control" name="{{ $field }}" id="{{ $field }}">
                                        </div>
                                    </div>
                                @endforeach
                                <!-- Display Existing Images -->
                                @if ($brand)
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Existing Images</label>
                                        <div class="row">
                                            @foreach ($brand as $image)
                                                <div class="col-md-3 mb-2">
                                                    <div class="image-item">
                                                        <input type="file" name="images[{{ $image->id }}]"
                                                               class="form-control dropify"
                                                               data-default-file="{{ asset('storage/' . $image->image) }}"
                                                               data-height="100" accept="image/*">
                                                        <!-- Remove Image Checkbox -->
                                                        <div class="form-check mt-1">
                                                            <input type="checkbox" class="form-check-input" name="remove_images[]"
                                                                   value="{{ $image->id }}" id="remove_image_{{ $image->id }}">
                                                            <label class="form-check-label" for="remove_image_{{ $image->id }}">
                                                                Remove this image
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Add New Images -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Add New Images</label>
                                        <div id="image-repeater">
                                            <div class="image-item">
                                                <input type="file" name="images[]" class="form-control dropify"  multiple accept="image/*" data-height="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Save Button -->
                                <div class="col-lg-12">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
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
        $(document).ready(function() {
            // Initialize Dropify
            $('.dropify').dropify({
                messages: {
                    'default': 'Drag and drop a file here or click',
                    'replace': 'Drag and drop or click to replace',
                    'remove': 'Remove',
                    'error': 'Ooops, something wrong happened.'
                }
            });

            // Add new image input
            // $('#add-image').click(function() {
            //     $('#image-repeater').append(`
            //         <div class="image-item mt-2">
            //             <input type="file" name="images[]" class="form-control dropify" accept="image/*" data-height="100">
            //         </div>
            //     `);
            //     // Reinitialize Dropify for new elements
            //     $('.dropify').dropify();
            // });
        });
    </script>
@endpush
