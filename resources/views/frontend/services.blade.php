@extends('layouts.front')
@section('title')
    Services
@endsection
@section('content')
    <section class="services">
        <div class="container">
            <div class="heading">
                <h3>الخدمات</h3>
                <hr>
            </div>
            <div class="info">
                <div class="left">
                    <p>
                        إنشاء ورسخ وتسليط الضوء علي العلامة التجارية
                        <br />
                        لتمييــــز الشركـــات الناشئــــة وإبـــراز جوهرهـــــا
                        <br />
                        عبــر مجموعة من القيــم والخصائص والرموز التي
                        <br />
                        يمكن أن تمنحها المكانة المميزة في المنـــافسة
                        <br>
                        مـــع الشركـــات الأخـــري
                    </p>
                </div>
                <div class="right">
                    <p>
                        نبـــدأ مشروعـــك بدخولـــة غرف العمليـــات لدينـــا
                        <br />
                        وهو مكاننــــــا الخـــاص المكــــــون من عـدة غرف
                        <br />
                        استديـــو شــــــوت انــــــج - غرفـــة ولادة الأفكــار)
                        <br />
                        (والمحتــــــوي - غرفـــــة إجتمـــاعــــات الفـــريـــق
                        <br />
                        ومن هنا ينطلق المشروع بإبداعة الفني
                    </p>
                </div>
            </div>
            <div class="boxes">
                <div class="box">
                    <a href="#">
                        أستكشف
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <h3>الطباعة</h3>
                    <img src="{{ asset('front/images/Pages inside-12.png') }}" alt="">
                    <div class="icon">
                        <img src="{{ asset('front/images/icon web-04.png') }}" style="top: 0;" alt="">
                    </div>
                </div>
                <div class="box">
                    <h3>مجالات دعم <br>الصناعة</h3>
                    <a href="#">
                        أستكشف
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <img src="{{ asset('front/images/Pages inside-11.png') }}" alt="">
                    <div class="icon">
                        <img src="{{ asset('front/images/icon web-03.png') }}" style="top: 0;" alt="">
                    </div>
                </div>
                <div class="box social">
                    <a href="#">
                        أستكشف
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <h3>وسائل التواصل الإجتمــــــــاعي</h3>
                    <img src="{{ asset('front/images/Pages inside-12.png') }}" alt="">
                    <div class="icon">
                        <img src="{{ asset('front/images/icon web-02.png') }}" style="top: 0;" alt="">
                    </div>
                </div>
                <div class="box">
                    <h3>التصوير والإنتاج</h3>
                    <a href="#">
                        أستكشف
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <img src="{{ asset('front/images/Pages inside-11.png') }}" alt="">
                    <div class="icon">
                        <img src="{{ asset('front/images/icon web-01.png') }}" style="top: 0;" alt="">
                    </div>
                </div>
            </div>
            <div class="boxes">
                <div class="box">
                    <a href="#">
                        أستكشف
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <h3 class="shopping">التسويق والإعـلان</h3>
                    <img src="{{ asset('front/images/Pages inside-12.png') }}" alt="">
                    <div class="icon">
                        <img src="{{ asset('front/images/icon web-05.png') }}" style="bottom: 0;" alt="">
                    </div>
                </div>
                <div class="box">
                    <h3>المـواقـــع الألكترونية</h3>
                    <a href="#">
                        أستكشف
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <img src="{{ asset('front/images/Pages inside-11.png') }}" alt="">
                    <div class="icon">
                        <img src="{{ asset('front/images/icon web-06.png') }}" style="top: 0;" alt="">
                    </div>
                </div>
                <div class="box">
                    <a href="#">
                        أستكشف
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <h3 class="identity">الـهويــة المكانية</h3>
                    <img src="{{ asset('front/images/Pages inside-12.png') }}" alt="">
                    <div class="icon">
                        <img src="{{ asset('front/images/icon web-07.png') }}" style="bottom: 0;" alt="">
                    </div>
                </div>
                <div class="box">
                    <h3>الهويــة التجارية</h3>
                    <a href="#">
                        أستكشف
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <img src="{{ asset('front/images/Pages inside-11.png') }}" alt="">
                    <div class="icon">
                        <img src="{{ asset('front/images/icon web-08.png') }}" style="top: 0;" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="shooting d-flex justify-content-center align-items-center">
        <img src="{{ asset('images/' . $gif->footer_gif) }}" alt="">
    </section>
@endsection
