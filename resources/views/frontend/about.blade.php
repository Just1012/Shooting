@extends('layouts.front')
@section('title')
    About Us
@endsection
@section('content')
    <section class="about-us">
        <div class="container">
            <div class="heading">
                <h3>{{ $aboutContent->{App::getLocale() == 'ar' ? 'main_title_ar' : 'main_title_en'} }}</h3>
                <hr>
            </div>
            <div class="info">
                <div class="left">
                    {!! $aboutContent->{App::getLocale() == 'ar' ? 'desc_1_ar' : 'desc_1_en'} !!}
                </div>
                <div class="right">
                    {!! $aboutContent->{App::getLocale() == 'ar' ? 'desc_2_ar' : 'desc_2_en'} !!}
                </div>
            </div>
        </div>
    </section>
    <section class="shooting d-flex justify-content-center align-items-center">
        <img src="{{ asset('images/' . $gif->footer_gif) }}" alt="">
    </section>
@endsection
