@extends('layouts.front')
@section('title')
    Our Works
@endsection
@section('content')
    <div class="our-business-bg">
        <div class="container">
            <div class="heading">
                <h3>أعمالنا</h3>
                <hr>
            </div>
            <div class="text">
                <h3>هي مولودنا الجديد</h3>
                <span>الذي نحظي به مع العميل طوال مسيرتنا</span>
            </div>
            <div class="info">
                <div class="left">
                    <p>
                        فريقنا قبل ان يمون لديهم مهارات العمل العادية
                        <br>
                        تميزوا بصفة الموهبة وثقلها وتفرها
                    </p>
                </div>
                <div class="right">
                    <p>
                        لنا تاريخنا القديم الذي يلعب دور مهم في أن يترك
                        <br>
                        أثر في أذهان عملائكم
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!--start Our business -->

    <section class="all_our_business">
        <div class="container">
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
            <div class="projects d-flex justify-content-start align-items-center flex-wrap gap-3">

            </div>
        </div>
    </section>
    <!--end Our business -->
@endsection
