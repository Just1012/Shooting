@extends('layouts.web')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endpush
@section('title')
    Edit Brand
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="col-md-9 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Edit Brand</h4>
                        <div class="card-body">
                            <div class="listjs-table" id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a class="btn btn-success add-btn" id="create-btn"
                                                href="{{ route('brand.index') }}">Back</a>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('brand.update', $id->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                              
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="brandNameAr" class="form-label">Brand Name Ar</label>
                                                <input type="text" class="form-control" name="brand_name_ar"
                                                    placeholder="Brand Name Ar" id="brandNameAr"
                                                    value="{{ $id->brand_name_ar }}">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="brandNameEn" class="form-label">Brand Name En</label>
                                                <input type="text" class="form-control" name="brand_name_en"
                                                    placeholder="Brand Name En" id="brandNameEn"
                                                    value="{{ $id->brand_name_en }}">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <h6 class="fw-semibold">Categories</h6>
                                                <select class="js-example-basic-multiple" multiple name="category_id[]">
                                                    <optgroup label="Select Category">
                                                        @foreach ($category as $val)
                                                            <option value="{{ $val->id }}"
                                                                @if (in_array($val->id, json_decode($id->category_id))) selected @endif>
                                                                {{ $val->{App::getLocale() == 'ar' ? 'name_ar' : 'name_en'} }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="yearInput" class="form-label">Year</label>
                                                <input type="text" class="form-control" name="year" placeholder="Year"
                                                    id="yearInput" value="{{ $id->year }}">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="imageInput" class="form-label">Thumbnail</label>
                                                <input type="file" class="form-control dropify" name="image"
                                                    id="imageInput"
                                                    data-default-file="{{ asset('images/' . $id->image) }}">
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
