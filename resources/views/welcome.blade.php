@extends('layouts.front')
@section('title')
    Home Page
@endsection
@section('content')
    <!-- strat swiper -->
    <swiper-container class="mySwiper" pagination="true" pagination-clickable="true">
        @foreach ($slider as $image)
            <swiper-slide><img
                    src="{{ asset('images/' . $image->{App::getLocale() == 'ar' ? 'image_ar' : 'image_en'}) }}"></swiper-slide>
        @endforeach
    </swiper-container>
    <!-- end swiper -->
    <!-- start section start  -->
    <section class="start">
        <div class="container">
            <div class="text">
                <h3>
                    @if (isset($content))
                        {!! $content->{App::getLocale() == 'ar' ? 'header_section_ar' : 'header_section_en'} !!}
                    @endif
                </h3>
                <a href="#" class="btn">
                    أحجز موعدك الأن
                </a>
            </div>
        </div>
    </section>
    <!-- end start  -->
    <!-- start take Coffee  -->
    <section class="take-coffee position-relative">
        <div class="content position-absolute">
            <p>
                أستمتع بقهوتك الصباحية أو المسائية معانا
                <br>
                بمنتزة شركتنا الراقي أعلي قمة أبراج المملكة
            </p>
        </div>
    </section>
    <!-- end take Coffee  -->
    <!--start Our business -->
    <style>
        .item span {
            &.dash {
                color: #ec3237;
            }

            &:nth-of-type(2) {
                padding-top: 21px;
            }
        }
    </style>
    <section class="our_business">
        <div class="all">
            <ul class="items">
                @foreach ($category as $key => $cate)
                    <li class="item" data-category-id="{{ $cate->id }}">
                        <span>
                            {{ $cate->{App::getLocale() == 'ar' ? 'name_ar' : 'name_en'} }}
                        </span>
                        <!-- Add the separator unless it's the last category -->
                        @if ($key < count($category) - 1)
                            <span class="dash"> | </span>
                        @endif
                    </li>
                @endforeach
                <!-- 'All' Category Item -->
                <li class="item" data-category-id="all">
                    <span class="dash"> | </span>
                    <span>{{ App::getLocale() == 'ar' ? 'الكل' : 'All' }}</span>
                </li>
            </ul>
        </div>
        <div class="container">
            <div class="projects d-flex justify-content-start align-items-center flex-wrap gap-3">
                @foreach ($brands as $brand)
                    <a href="#" class="project">
                        <div class="image">
                            <img src="{{ asset('images/' . $brand->image) }}" alt="">
                        </div>
                        <div class="info">
                            <h5>{{ $brand->{App::getLocale() == 'ar' ? 'brand_name_ar' : 'brand_name_en'} }}</h5>
                            <p>
                                @foreach (json_decode($brand->category_id) as $cate_id)
                                    <!-- assuming category_id is stored as JSON array -->
                                    @php
                                        $category = App\Models\Category::find($cate_id); // Fetch the category using the ID
                                    @endphp
                                    @if ($category)
                                        @if (App::getLocale() == 'en')
                                            <span>{{ $category->name_en }} - </span>
                                        @else
                                            <span>{{ $category->name_ar }} - </span>
                                        @endif
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
            <a href="./Our_business.html" class="btn">
                إبداعتنا
            </a>
        </div>
    </section>
    <!--end Our business -->
    <!-- start goals -->
    <section class="goals">
        <div class="heading">
            <h3>
                @if (isset($content))
                    {{ $content->{App::getLocale() == 'ar' ? 'goals_title_ar' : 'goals_title_en'} }}
                @endif
            </h3>
            <hr>
        </div>
        <div class="container">
            <div class="content d-flex justify-content-between align-items-center flex-wrap">
                <div class="image">
                    @if (isset($content))
                        <img src="{{ asset('images/' . $content->goals_image) }}" alt="">
                    @endif
                </div>
                <div class="info">
                    <ul class="mt-4">
                        @if (isset($content))
                            {!! $content->{App::getLocale() == 'ar' ? 'goals_desc_ar' : 'goals_desc_en'} !!}
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- end goals -->
    <!-- start vision -->
    <section class="vision">
        <img src="{{ asset('front/images/Web Shooting-08.png') }}" class="lap-image" width="100%">
        <img src="{{ asset('front/images/Photo For Mob copy.jpg') }}" class="mob-image">
        <div class="heading">
            <h3>
                @if (isset($content))
                    {{ $content->{App::getLocale() == 'ar' ? 'vision_title_ar' : 'vision_title_en'} }}
                @endif
            </h3>
            <hr>
        </div>
        <div class="container">
            <div class="info">
                <p class="mt-5">
                    @if (isset($content))
                        {{ $content->{App::getLocale() == 'ar' ? 'vision_desc_ar' : 'vision_desc_en'} }}
                    @endif
                </p>
            </div>
        </div>
    </section>
    <!-- end vision -->
    <!-- start our_journey-->
    <section class="our_journey">
        <div class="container">
            <div class="heading">
                <h3>
                    @if (isset($content))
                        {{ $content->{App::getLocale() == 'ar' ? 'journey_title_ar' : 'journey_title_en'} }}
                    @endif
                </h3>
                <hr>
            </div>
            <div class="content d-flex align-items-center flex-wrap">
                <div class="image">
                    <div id="splide1" class="splide" aria-labelledby="carousel-heading">
                        <div class="splide__track">
                            <ul class="splide__list">
                                @foreach ($journeySectionImage as $image)
                                    <li class="splide__slide"><img src="{{ asset('images/' . $image->image) }}"
                                            alt="">
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="info">
                    <div class="desc">
                        <p>
                            @if (isset($content))
                                {!! $content->{App::getLocale() == 'ar' ? 'journey_desc_ar' : 'journey_desc_en'} !!}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end our_journey-->
    <!-- start partners -->
    <section class="partners">
        <div class="container">
            <div class="heading text-center">
                <h3>شركاء المسيرة</h3>
                <hr>
            </div>
            <div id="splide2" class="splide" aria-labelledby="carousel-heading">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($partner as $value)
                            <li class="splide__slide"><img src="{{ asset('images/' . $value->image) }}" alt="">
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <a href="#" class="btn">
                أكتشف عملائنا
            </a>
        </div>
    </section>
    <!-- end partners -->
    <!-- start team-->
    <section class="team">
        <div class="container">
            <div class="text">
                <div class="title">
                    <h2>
                        @if (isset($content))
                            {{ $content->{App::getLocale() == 'ar' ? 'team_title_ar' : 'team_title_en'} }}
                        @endif
                    </h2>
                    <img src="{{ asset('front/images/icon1.svg') }}" alt="">
                    <img src="{{ asset('front/images/icon2.svg') }}" alt="">
                </div>
                <p class="text-center lab">
                    @if (isset($content))
                        {{ $content->{App::getLocale() == 'ar' ? 'team_desc_ar' : 'team_desc_en'} }}
                    @endif
                </p>
                <p class="text-center mob">
                    @if (isset($content))
                        {{ $content->{App::getLocale() == 'ar' ? 'team_desc_ar' : 'team_desc_en'} }}
                    @endif
                </p>
            </div>
        </div>
    </section>
    <!-- end team-->
    <section class="shooting d-flex justify-content-center align-items-center">
        @if (isset($gif))
            <img src="{{ asset('images/' . $gif->footer_gif) }}" alt="">
        @endif

    </section>
@endsection
