@extends('layouts.web')
@section('title')
    {{ $type_page == 'create' ? 'انشاء مستخدم' : 'تعديل مستخدم' }}
@endsection
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
@endpush
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex mx-1 align-items-center justify-content-between">
                        <h4 class="mb-sm-0"> {{ $type_page == 'create' ? 'انشاء مستخدم' : 'تعديل مستخدم' }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="#">المستخدمين</a></li>
                                <li class="breadcrumb-item active">
                                    {{ $type_page == 'create' ? 'انشاء مستخدم' : 'تعديل مستخدم' }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">{{ $type_page == 'create' ? 'انشاء المستخدم' : 'تعديل المستخدم' }}</h4>
                        <div class="card-body">
                            <div class="listjs-table" id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a class="btn btn-success add-btn" id="create-btn"
                                                href="{{ route('dashboard') }}">العودة</a>
                                        </div>
                                    </div>
                                </div>
                                <form
                                    action="@if ($type_page == '') {{ route('user.update') }}
                                @else
                                    {{ route('user.store') }} @endif"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <input type="hidden" name="id" value="{{ $data->id ?? '' }}">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">الاسم</label>
                                                <input type="text" class="form-control" name="name"
                                                    placeholder="الاسم"
                                                    value="{{ isset($data->name) ? $data->name : old('name') ?? '' }}"
                                                    id="firstNameinput">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">البريد الالكترونى</label>
                                                <input type="email" class="form-control" name="email"
                                                    placeholder="البريد الالكترونى"
                                                    value="{{ isset($data->email) ? $data->email : old('email') ?? '' }}"
                                                    id="firstNameinput">
                                            </div>
                                        </div><!--end col-->



                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">الرقم السرى</label>
                                                <input type="password" class="form-control" name="password"
                                                    placeholder="الرقم السرى" id="firstNameinput">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <h6 class="fw-semibold">القواعد</h6>
                                                <select class="js-example-basic-multiple" id="role_id" name="role_id">
                                                    <optgroup label="القواعد">
                                                        @foreach ($role as $val)
                                                            <option value="{{ $val->id }}"
                                                                @if ($type_page == '' && $val->id == $data->role_id) selected @endif>
                                                                {{ $val->name }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-lg-12">
                                            <div class="text-center">
                                                <button type="submit"
                                                    class="btn btn-primary">{{ $type_page == 'create' ? 'انشاء' : 'تعديل' }}</button>
                                            </div>
                                        </div><!--end col-->
                                    </div><!--end row-->
                                </form>
                            </div>
                        </div><!-- end card -->
                    </div><!--end col-->
                </div><!-- end col -->
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('web/assets/js/pages/select2.init.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Function to show/hide category selection based on role
            function toggleCategorySelection() {
                if ($('#role_id').val() == 3) {
                    $('#category_selection').show();
                } else {
                    $('#category_selection').hide();
                }
            }

            // Initial call to set the correct state on page load
            toggleCategorySelection();

            // Event listener for role selection change
            $('#role_id').change(function() {
                toggleCategorySelection();
            });
        });
    </script>
@endpush
