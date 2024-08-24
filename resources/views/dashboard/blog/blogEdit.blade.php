@extends('layouts.web')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
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
                                <form action="{{ route('blog.update', $id->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Title Ar</label>
                                                <input type="text" class="form-control" name="title_ar"
                                                    value="{{ $id->title_ar }}" placeholder="Title Ar" id="firstNameinput">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Title En</label>
                                                <input type="text" class="form-control" name="title_en"
                                                    value="{{ $id->title_en }}" placeholder="Title En" id="firstNameinput">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Body Ar</label>
                                                <textarea class="form-control" name="body_ar" placeholder="Body Ar" rows="4" id="myeditorinstance">{{ $id->body_ar }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Body En</label>
                                                <textarea class="form-control" name="body_en" placeholder="Body En" rows="4" id="myeditorinstance">{{ $id->body_en }}</textarea>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="address1ControlTextarea" class="form-label">Thumbnail Image</label>
                                                <input type="file" class="form-control dropify"
                                                    data-default-file="{{ asset('images/' . $id->thumbnail) }}"
                                                    name="thumbnail" id="address1ControlTextarea">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-9">
                                            <div class="mb-3">
                                                <label for="main_image" class="form-label">Main Image</label>
                                                <input type="file" class="form-control dropify"
                                                    data-default-file="{{ asset('images/' . $id->main_image) }}"
                                                    name="main_image" id="main_image">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-lg-12">
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Update</button>
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
@endpush
