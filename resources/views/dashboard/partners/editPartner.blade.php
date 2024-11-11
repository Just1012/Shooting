@extends('layouts.web')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endpush
@section('title')
    Edit Partner
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="col-md-9 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Edit Partner</h4>
                        <div class="card-body ">
                            <div class="listjs-table" id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a class="btn btn-success add-btn" id="create-btn"
                                                href="{{ route('partner.index') }}">Back</a>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('partner.update', $partner->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <h6 class="fw-semibold">Brand</h6>
                                                <select class="js-example-basic-multiple" id="brand_id" name="brand_id">
                                                    <optgroup label="Brand Name">
                                                        <option value="" disabled selected>-- Select Brand Name --
                                                        </option>
                                                        @foreach ($brands as $val)
                                                            <option value="{{ $val->id }}"
                                                                @if ($val->id == $partner->brand_id) selected @endif>
                                                                {{ $val->{App::getLocale() == 'ar' ? 'brand_name_ar' : 'brand_name_en'} }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <h6 class="fw-semibold">Section</h6>
                                                <select class="js-example-basic-multiple" id="section" name="section">
                                                    <optgroup label="Section Name">
                                                        <option value="" disabled selected>-- Select Section  --</option>
                                                        @foreach ($section as $sectionId)
                                                            <option value="{{ $sectionId }}"
                                                                @if ($sectionId == $partner->section) selected @endif>
                                                                {{ __('Section') . ' ' . $sectionId }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div><!--end col-->
                                    </div>


                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Partner Image</label>

                                            <input type="file" class="form-control dropify" name="image" id="image"
                                                data-default-file="{{ asset('images/' . $partner->image) }}">
                                        </div>
                                    </div><!--end col-->


                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">Save</button>
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
