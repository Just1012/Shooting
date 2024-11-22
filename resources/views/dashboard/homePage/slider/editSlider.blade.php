@extends('layouts.web')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endpush
@section('title')
    {{ __('messages.editSlider') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="col-md-9 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">{{ __('messages.editSlider') }}</h4>
                        <div class="card-body">
                            <div class="listjs-table" id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a class="btn btn-success add-btn" id="create-btn"
                                                href="{{ route('slider.index') }}">{{ __('messages.back') }}</a>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('slider.update', $slider->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <!-- Arabic File -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="image_ar"
                                                    class="form-label">{{ __('messages.imageAr') }}</label>
                                                <input type="file" class="form-control dropify" name="image_ar"
                                                    id="image_ar"
                                                    data-default-file="{{ asset('images/' . $slider->image_ar) }}"
                                                    accept="image/*,video/*">
                                            </div>
                                        </div><!--end col-->

                                        <!-- English File -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="image_en"
                                                    class="form-label">{{ __('messages.imageEn') }}</label>
                                                <input type="file" class="form-control dropify" name="image_en"
                                                    id="image_en"
                                                    data-default-file="{{ asset('images/' . $slider->image_en) }}"
                                                    accept="image/*,video/*">
                                            </div>
                                        </div><!--end col-->

                                        <!-- Save Button -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <button type="submit"
                                                    class="btn btn-primary">{{ __('messages.save') }}</button>
                                            </div>
                                        </div><!--end col-->
                                    </div><!--end row-->
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
        // Initialize Dropify
        $('.dropify').dropify({
            messages: {
                'default': '{{ __('messages.dragDropDefault') }}',
                'replace': '{{ __('messages.dragDropReplace') }}',
                'remove': '{{ __('messages.dragDropRemove') }}',
                'error': '{{ __('messages.dragDropError') }}'
            }
        });

        // Handle Video Preview
        $('.dropify').on('change', function() {
            const file = this.files[0];
            const fileType = file.type;
            const dropifyWrapper = $(this).closest('.dropify-wrapper');

            if (fileType.startsWith('video/')) {
                const videoPreview = `<video controls style="width: 100%; height: auto;">
                                        <source src="${URL.createObjectURL(file)}" type="${fileType}">
                                        {{ __('messages.videoNotSupported') }}
                                      </video>`;
                dropifyWrapper.find('.dropify-preview').html(videoPreview).fadeIn();
            }
        });

        // Handle Preloaded Files (Images/Videos)
        $('.dropify').each(function() {
            const filePath = $(this).attr('data-default-file');
            const dropifyWrapper = $(this).closest('.dropify-wrapper');

            if (filePath && /\.(mp4|avi|mov)$/i.test(filePath)) {
                const videoPreview = `<video controls style="width: 100%; height: auto;">
                                        <source src="${filePath}">
                                        {{ __('messages.videoNotSupported') }}
                                      </video>`;
                dropifyWrapper.find('.dropify-preview').html(videoPreview).fadeIn();
            }
        });
    </script>
@endpush
