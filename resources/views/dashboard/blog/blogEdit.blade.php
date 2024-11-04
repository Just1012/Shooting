@extends('layouts.web')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush
@section('title')
    Edit Blog
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="col-md-9 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Edit Blog</h4>
                        <div class="card-body ">
                            <div class="listjs-table" id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a class="btn btn-success add-btn" id="create-btn"
                                                href="{{ route('blog.index') }}">Back</a>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('blog.update', $id->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <!-- Title Ar -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="title_ar" class="form-label">Title Ar</label>
                                                <input type="text" class="form-control" name="title_ar"
                                                    value="{{ $id->title_ar }}" placeholder="Title Ar" id="title_ar">
                                            </div>
                                        </div><!-- end col -->

                                        <!-- Title En -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="title_en" class="form-label">Title En</label>
                                                <input type="text" class="form-control" name="title_en"
                                                    value="{{ $id->title_en }}" placeholder="Title En" id="title_en">
                                            </div>
                                        </div><!-- end col -->

                                        <!-- Created At -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="created_at" class="form-label">Created At</label>
                                                <input type="text" class="form-control" name="created_at" id="created_at"
                                                    placeholder="Select date and time">
                                            </div>
                                        </div><!-- end col -->

                                        <!-- Categories -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <h6 class="fw-semibold">Categories</h6>
                                                <select class="js-example-basic-multiple" multiple name="categories_id[]">
                                                    <optgroup label="Select Category">
                                                        @foreach ($categories as $val)
                                                            <option value="{{ $val->id }}"
                                                                @if (is_array(json_decode($id->categories_id)) && in_array($val->id, json_decode($id->categories_id))) selected @endif>
                                                                {{ $val->{App::getLocale() == 'ar' ? 'name_ar' : 'name_en'} }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div><!--end col-->

                                        <!-- Body Ar -->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="body_ar" class="form-label">Body Ar</label>
                                                <textarea class="form-control" name="body_ar" placeholder="Body Ar" rows="4" id="myeditorinstance">{{ $id->body_ar }}</textarea>
                                            </div>
                                        </div><!-- end col -->

                                        <!-- Body En -->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="body_en" class="form-label">Body En</label>
                                                <textarea class="form-control" name="body_en" placeholder="Body En" rows="4" id="myeditorinstance">{{ $id->body_en }}</textarea>
                                            </div>
                                        </div><!-- end col -->

                                        <!-- Thumbnail Image -->
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="thumbnail" class="form-label">Thumbnail Image</label>
                                                <input type="file" class="form-control dropify" name="thumbnail"
                                                    data-default-file="{{ asset('images/' . $id->thumbnail) }}"
                                                    id="thumbnail">
                                            </div>
                                        </div><!-- end col -->

                                        <!-- Main Image -->
                                        <div class="col-md-9">
                                            <div class="mb-3">
                                                <label for="main_image" class="form-label">Main Image</label>
                                                <input type="file" class="form-control dropify" name="main_image"
                                                    data-default-file="{{ asset('images/' . $id->main_image) }}"
                                                    id="main_image">
                                            </div>
                                        </div><!-- end col -->

                                        <!-- SEO Section -->
                                        <div class="col-md-12">
                                            <hr>
                                            <h5>SEO Section</h5>
                                        </div>

                                        <!-- Meta Title and Description -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="meta_title" class="form-label">Meta Title</label>
                                                <input type="text" class="form-control" name="meta_title"
                                                    placeholder="Meta Title" id="meta_title"
                                                    value="{{ $id->meta_title }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="meta_description" class="form-label">Meta Description</label>
                                                <textarea class="form-control" name="meta_description" placeholder="Meta Description" rows="3"
                                                    id="meta_description">{{ $id->meta_description }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="keywords" class="form-label">Keywords</label>
                                                <input class="form-control" name="keywords[]"
                                                    id="choices-text-remove-button" data-choices data-choices-removeItem
                                                    type="text" placeholder="Add keywords"
                                                    value="{{ is_array(json_decode($id->keywords)) ? implode(',', json_decode($id->keywords)) : '' }}" />
                                            </div>
                                        </div><!-- end col -->

                                        <!-- Meta Image -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="meta_image" class="form-label">Meta Image</label>
                                                <input type="file" class="form-control dropify" name="meta_image"
                                                    id="meta_image"
                                                    data-default-file="{{ asset('images/' . $id->meta_image) }}">
                                            </div>
                                        </div><!-- end col -->

                                        <!-- Update Button -->
                                        <div class="col-lg-12">
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </div><!-- end col -->
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
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#created_at", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                defaultDate: "{{ $id->created_at ? $id->created_at->format('Y-m-d H:i') : '' }}",
            });
        });
    </script>

    <script>
        $('.dropify').dropify({
            messages: {
                'default': 'Drag and drop a file here or click',
                'replace': 'Drag and drop or click to replace',
                'remove': 'Remove',
                'error': 'Ooops, something wrong happended.'
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const choices = new Choices('#choices-text-remove-button', {
                removeItemButton: true,
            });
        });
    </script>
@endpush
