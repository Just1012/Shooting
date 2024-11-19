@extends('layouts.web')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endpush

@section('title')
    Edit Image
@endsection

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="col-md-9 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Edit Image</h4>
                    </div>
                    <div class="card-body">
                        <div class="listjs-table" id="customerList">
                            <div class="row g-4 mb-3">
                                <div class="col-sm-auto">
                                    <a class="btn btn-success add-btn" id="create-btn"
                                        href="{{ route('photography.index') }}">Back</a>
                                </div>
                            </div>
                            <form action="{{ route('photography.update', $photography->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('Post')
                                <div class="row">
                                    <!-- Image Upload -->
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Image</label>
                                            <input type="file" class="form-control dropify" name="image" id="image"
                                                data-default-file="{{ asset('images/' . $photography->image) }}">
                                        </div>
                                    </div>
                                    <!-- Age -->
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="age" class="form-label">Age</label>
                                            <input type="number" class="form-control" name="age" id="age"
                                                value="{{ $photography->age }}" placeholder="Age">
                                        </div>
                                    </div>
                                    <!-- Weight -->
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="weight" class="form-label">Weight</label>
                                            <input type="number" class="form-control" name="weight" id="weight"
                                                value="{{ $photography->weight }}" placeholder="Weight">
                                        </div>
                                    </div>
                                    <!-- Height -->
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="height" class="form-label">Height</label>
                                            <input type="number" class="form-control" name="height" id="height"
                                                value="{{ $photography->height }}" placeholder="Height">
                                        </div>
                                    </div>
                                    <!-- Model Number -->
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="model_number" class="form-label">Model Number</label>
                                            <input type="number" class="form-control" name="model_number" id="model_number"
                                                value="{{ $photography->model_number }}" placeholder="Model Number">
                                        </div>
                                    </div>
                                    <!-- Submit Button -->
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
        $('.dropify').dropify({
            messages: {
                'default': 'Drag and drop a file here or click',
                'replace': 'Drag and drop or click to replace',
                'remove': 'Remove',
                'error': 'Oops, something went wrong.'
            }
        });
    </script>
@endpush
