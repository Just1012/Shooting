@extends('layouts.web')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
@endpush
@section('title')
    Create New Blog
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="col-md-9 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Create New Blog</h4>
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
                                <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Title Ar</label>
                                                <input type="text" class="form-control" name="title_ar"
                                                    placeholder="Title Ar" id="firstNameinput">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Title En</label>
                                                <input type="text" class="form-control" name="title_en"
                                                    placeholder="Title En" id="firstNameinput">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <h6 class="fw-semibold">Categories</h6>
                                                <select class="js-example-basic-multiple" multiple name="categories_id[]">
                                                    <optgroup label= "Select Category">
                                                        @foreach ($categories as $val)
                                                            <option value="{{ $val->id }}">
                                                                {{ $val->{App::getLocale() == 'ar' ? 'name_ar' : 'name_en'} }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Body Ar</label>
                                                <textarea class="form-control" name="body_ar" placeholder="Body Ar" rows="4" id="myeditorinstance"></textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Body En</label>
                                                <textarea class="form-control" name="body_en" placeholder="Body En" rows="4" id="myeditorinstance"></textarea>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="address1ControlTextarea" class="form-label">Thumbnail
                                                    Image</label>
                                                <input type="file" class="form-control dropify" name="thumbnail"
                                                    id="address1ControlTextarea">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-9">
                                            <div class="mb-3">
                                                <label for="main_image" class="form-label">Main Image</label>
                                                <input type="file" class="form-control dropify" name="main_image"
                                                    id="main_image">
                                            </div>
                                        </div><!--end col-->

                                        <!-- Blog Headings (Repeatable) -->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <h5 class="fw-semibold">Blog Headings</h5>
                                                <div id="headingRepeater">
                                                    <div class="d-flex mb-2 heading-group">
                                                        <input type="text" name="headings[]" class="form-control"
                                                            placeholder="Enter heading" required>
                                                    </div>
                                                </div>
                                                <!-- Place the "+" button under the heading inputs -->
                                                <button type="button" class="btn btn-success btn-sm mt-2"
                                                    onclick="addHeading()">+ {{ App::getLocale() == 'ar' ? 'إضافة' : 'Add' }}</button>
                                            </div>
                                        </div>

                                        <!-- SEO Section -->
                                        <div class="col-md-12">
                                            <hr>
                                            <h5>SEO Section</h5>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="meta_title" class="form-label">Meta Title</label>
                                                <input type="text" class="form-control" name="meta_title"
                                                    placeholder="Meta Title" id="meta_title">
                                            </div>
                                            <div class="mb-3">
                                                <label for="meta_description" class="form-label">Meta Description</label>
                                                <textarea class="form-control" name="meta_description" placeholder="Meta Description" rows="3"
                                                    id="meta_description"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="choices-text-remove-button" class="form-label text-muted">
                                                    Kye Words</label>
                                                <input class="form-control" name="keywords[]"
                                                    id="choices-text-remove-button" data-choices data-choices-removeItem
                                                    type="text" />
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="meta_image" class="form-label">Meta Image</label>
                                                <input type="file" class="form-control dropify" name="meta_image"
                                                    id="meta_image">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-lg-12">
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div><!--end col-->
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
    <script>
        function addHeading() {
            // Create a new input group div
            const headingGroup = document.createElement('div');
            headingGroup.classList.add('d-flex', 'mb-2', 'heading-group');
            headingGroup.innerHTML = `
                <input type="text" name="headings[]" class="form-control" placeholder="Enter heading" required>
                <button type="button" class="btn btn-danger btn-sm ms-2" onclick="removeHeading(this)">-</button>
            `;

            // Append the new input group above the "+" button
            const headingRepeater = document.getElementById('headingRepeater');
            headingRepeater.appendChild(headingGroup);
        }

        function removeHeading(button) {
            // Remove the clicked heading input group
            button.parentElement.remove();
        }
    </script>
@endpush
