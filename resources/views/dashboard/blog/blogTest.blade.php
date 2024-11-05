@extends('layouts.front')
@section('title')
    Blog
@endsection
@section('content')
    <section class="details-blog">
        <div class="content">

            <div class="title text-center">
                <a style="border-radius: 24px; background-color:#ec3237; border:#ec3237; padding:10px; "
                    href="{{ route('blog.index') }}"
                    class="btn btn-primary">{{ App::getLocale() == 'ar' ? 'العودة الي لوحة التحكم' : 'Back To Dashboard' }}</a>
                <h2 style="margin-top:10px;"> {{ App::getLocale() == 'ar' ? $blog->title_ar : $blog->title_en }} </h2>
            </div>
            <div class="banner">
                <div class="left">
                    <p>{{ App::getLocale() == 'ar' ? $blog->title_ar : $blog->title_en }}</p>
                </div>
                <div class="right">
                    <img src="{{ asset('images/' . $blog->main_image) }}" alt="">
                </div>
            </div>
            <div class="container">
                <div class="content" @if (App::getLocale() == 'ar') style="padding-right: 580px" @endif>
                    <div class="right">
                        <p>{!! App::getLocale() == 'ar' ? $blog->body_ar : $blog->body_en !!}</p>
                        <div class="next-prev">
                            <div class="next">
                                <a class="next-blog">
                                    <span>المقال التالي</span>
                                    <i class="ri-corner-up-right-fill"></i>
                                </a>
                                <h5>طرق التسويق المبتكرة</h5>
                            </div>
                            <div class="prev">
                                <a class="prev-blog">
                                    <span>المقال السابق</span>
                                    <i class="ri-corner-up-left-fill"></i>
                                </a>
                                <h5>طرق التسويق المبتكرة</h5>
                            </div>
                        </div>
                    </div>
                    <div class="left">
                        <form action="" class="search">
                            <input placeholder="Search">
                            <i class="ri-search-line"></i>
                        </form>
                        <div class="article-contents">
                            <h3>محتويات المقالة</h3>
                            <ul>
                                <li>الهوية التجارية</li>
                                <li>الهوية المكانية</li>
                                <li>الموقع الإلكتروني</li>
                                <li>التسويق و الإعلان</li>
                            </ul>
                        </div>
                        <div class="services-blog">
                            <h3>الخدمات</h3>
                            <ul>
                                <li>الهوية التجارية</li>
                                <li>الهوية المكانية</li>
                                <li>الموقع الإلكتروني</li>
                                <li>التسويق و الإعلان</li>
                                <li>التصوير و الإنتاج</li>
                                <li>وسائل التواصل الإجتماعي</li>
                                <li>الطباعة</li>
                                <li>مجالات دعم الصناعة</li>
                            </ul>
                        </div>
                        <div class="latest-articles">
                            <h3>أحدث المقالات</h3>
                            <ul>
                                <li>
                                    <i class="fa-solid fa-bookmark"></i>
                                    <span>الهوية التجارية</span>
                                </li>
                                <li>
                                    <i class="fa-solid fa-bookmark"></i>
                                    <span>الهوية التجارية</span>
                                </li>
                                <li>
                                    <i class="fa-solid fa-bookmark"></i>
                                    <span>الهوية التجارية</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <section class="shooting d-flex justify-content-center align-items-center">
        <img src="{{ asset('front//images/shooting.GIF') }}" alt="">
    </section> --}}
@endsection
