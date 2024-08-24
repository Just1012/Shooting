@extends('layouts.front')
@section('title')
    Home Page
@endsection
@section('content')
    <!-- strat swiper -->
    <swiper-container class="mySwiper" pagination="true" pagination-clickable="true">
        <swiper-slide><img src="{{ asset('front/images/wEb Photo-01.png') }}"></swiper-slide>
        <swiper-slide><img src="{{ asset('front/images/Web Shooting-01.png') }}"></swiper-slide>
    </swiper-container>
    <!-- end swiper -->
    <!-- start section start  -->
    <section class="start">
        <div class="container">
            <div class="text">
                <h3>
                    إبدأ مشروعك الأن و أستفد
                    <strong>بأستشــارة مجـانية</strong>
                    <br>
                    مع نخبة من أفضل خبراء و إداره المشاريـــــــــع و التسويــــــــق
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
                <li class="item">
                    <span><span class="dash">| </span>التسويق و الإعلان<span class="dash"> |</span></span>
                </li>
                <li class="item">
                    <span>التصوير و الإنتاج<span class="dash"> |</span></span>
                </li>
                <li class="item">
                    <span>تصميم المواقع الإلكترونية و المتاجر و برمجتها <span class="dash"> | </span></span> <!-- 3 -->
                </li>
                <li class="item">
                    <span>بناء الهوية المكانية و المعارض <span class="dash"> | </span> </span> <!-- 2 -->
                </li>
                <li class="item">
                    <span>بناء العلامة التجارية</span> <!-- 1 -->
                </li>
            </ul>
            <ul class="items pt-4">
                <li class="item">
                    <span> الطباعة <span class="dash"> | </span></span>
                </li>
                <li class="item">
                    <span> الصناعة <span class="dash"> | </span></span>
                </li>
                <li class="item">
                    <span>إدارة وسائل التواصل الإجتماعي</span>
                </li>
            </ul>
        </div>
        <div class="container">
            <div class="projects d-flex justify-content-start align-items-center flex-wrap gap-3">
                <a href="#" class="project">
                    <div class="image">
                        <img src="./images/Web Shooting 2-03.jpg" alt="">
                    </div>
                    <div class="info">
                        <h5>Lavida Clothing Brand</h5>
                        <p>
                            <span>العلامة التجارية - </span>
                            <span>التصوير الفوتوغرافي - </span>
                            <span>وسائل التواصل الأجتماعي - </span>
                            <span>المتجر الإلكتروني </span>
                        </p>
                    </div>
                </a>
                <a href="" class="project">
                    <div class="image">
                        <img src="./images/Web Shooting 2-02.jpg" alt="">
                    </div>
                    <div class="info">
                        <h5>Piano Perfums</h5>
                        <p>
                            <span>العلامة التجارية - </span>
                            <span>التصوير الفوتوغرافي - </span>
                            <span>وسائل التواصل الأجتماعي </span>
                        </p>
                    </div>
                </a>
                <a href="./project_details.html" class="project">
                    <div class="image">
                        <img src="./images/Web Shooting 2-01.jpg" alt="">
                    </div>
                    <div class="info">
                        <h5>AI-Shabout Seafood Restaurant</h5>
                        <p>
                            <span>العلامات التجارية - </span>
                            <span>التصوير الفوتوغرافي - </span>
                            <span>وسائل التواصل الأجتماعي </span>
                        </p>
                    </div>
                </a>
                <a href="" class="project">
                    <div class="image">
                        <img src="./images/Web Shooting 2-06.jpg" alt="">
                    </div>
                    <div class="info">
                        <h5>Mayala Shop For Clothes</h5>
                        <p>
                            <span>العلامات التجارية</span>
                        </p>
                    </div>
                </a>
                <a href="" class="project">
                    <div class="image">
                        <img src="./images/Web Shooting 2-05.jpg" alt="">
                    </div>
                    <div class="info">
                        <h5>Mademoiselle Personal Care</h5>
                        <p>
                            <span>العلامات التجارية - </span>
                            <span>التصوير الفوتوغرافي - </span>
                            <span>وسائل التواصل الأجتماعي </span>
                        </p>
                    </div>
                </a>
                <a href="" class="project">
                    <div class="image">
                        <img src="./images/Web Shooting 2-04.jpg" alt="">
                    </div>
                    <div class="info">
                        <h5>AI-Hyatt Medical Laboratory</h5>
                        <p>
                            <span>التصوير الفوتوغرافي - </span>
                            <span>وسائل التواصل الأجتماعي </span>
                        </p>
                    </div>
                </a>
                <a href="" class="project">
                    <div class="image">
                        <img src="./images/Web Shooting 2-07.jpg" alt="">
                    </div>
                    <div class="info">
                        <h5>Almrjan Oil</h5>
                        <p>
                            <span>العلامات التجارية - </span>
                            <span>التصوير الفوتوغرافي </span>
                        </p>
                    </div>
                </a>
                <a href="" class="project">
                    <div class="image">
                        <img src="./images/Web Shooting 2-08.jpg" alt="">
                    </div>
                    <div class="info">
                        <h5>Bella Makeup</h5>
                        <p>
                            <span>العلامات التجارية</span>
                        </p>
                    </div>
                </a>
                <a href="" class="project">
                    <div class="image">
                        <img src="./images/Web Shooting 2-09.jpg" alt="">
                    </div>
                    <div class="info">
                        <h5>Salah AI-Juhani Medical Est</h5>
                        <p>
                            <span>العلامات التجارية</span>
                        </p>
                    </div>
                </a>
                <a href="" class="project">
                    <div class="image">
                        <img src="./images/Web Shooting 2-12.jpg" alt="">
                    </div>
                    <div class="info">
                        <h5>Velvet Chocolate</h5>
                        <p>
                            <span>العلامات التجارية</span>
                        </p>
                    </div>
                </a>
                <a href="" class="project">
                    <div class="image">
                        <img src="./images/Web Shooting 2-11.jpg" alt="">
                    </div>
                    <div class="info">
                        <h5>Legacy Perfumes</h5>
                        <p>
                            <span>العلامات التجارية - </span>
                            <span>التصوير الفوتوغرافي - </span>
                            <span>وسائل التواصل الأجتماعي - </span>
                            <span>المتجر الإلكتروني </span>
                        </p>
                    </div>
                </a>
                <a href="" class="project">
                    <div class="image">
                        <img src="./images/Web Shooting 2-10.jpg" alt="">
                    </div>
                    <div class="info">
                        <h5>Moon Smell Perfumes</h5>
                        <p>
                            <span>العلامات التجارية - </span>
                            <span>التصوير الفوتوغرافي - </span>
                            <span>وسائل التواصل الأجتماعي </span>
                        </p>
                    </div>
                </a>
                <a href="" class="project">
                    <div class="image">
                        <img src="./images/Web Shooting 2-13.jpg" alt="">
                    </div>
                    <div class="info">
                        <h5>Mayala Shop For Clothes</h5>
                        <p>
                            <span>العلامات التجارية</span>
                        </p>
                    </div>
                </a>
                <a href="" class="project">
                    <div class="image">
                        <img src="./images/Web Shooting 2-14.jpg" alt="">
                    </div>
                    <div class="info">
                        <h5>Dar Vintage Oud & Bakhour</h5>
                        <p>
                            <span>العلامات التجارية - </span>
                            <span>التصوير الفوتوغرافي - </span>
                            <span>وسائل التواصل الأجتماعي </span>
                        </p>
                    </div>
                </a>
                <a href="" class="project">
                    <div class="image">
                        <img src="{{ asset('front/images/Web Shooting 2-15.jpg') }}" alt="">
                    </div>
                    <div class="info">
                        <h5>Rose Mond Perfums</h5>
                        <p>
                            <span>العلامات التجارية - </span>
                            <span>التصوير الفوتوغرافي - </span>
                            <span>وسائل التواصل الأجتماعي - </span>
                            <span>المتجر الإلكتروني </span>
                        </p>
                    </div>
                </a>
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
            <h3>أهدافنا</h3>
            <hr>
        </div>
        <div class="container">
            <div class="content d-flex justify-content-between align-items-center flex-wrap">
                <div class="image">
                    <img src="{{ asset('front/images/goals.jpg') }}" alt="">
                </div>
                <div class="info">
                    <ul class="mt-4">
                        <li>خلق منتج غير تقلـــــيدي يستطيع المنــــــــافسة</li>
                        <li>بناء علامتكم التجــارية بطريقة مختلـة و إحترافية</li>
                        <li>التسويـق بالمحتوي لإحراز أهــــدافكم الرقمـــية</li>
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
            <h3>رؤيتنا</h3>
            <hr>
        </div>
        <div class="container">
            <div class="info">
                <p class="mt-5">
                    تعزيز المنتج أو الخدمة لوصولها إلي رؤيتك
                </p>
            </div>
        </div>
    </section>
    <!-- end vision -->
    <!-- start our_journey-->
    <section class="our_journey">
        <div class="container">
            <div class="heading">
                <h3>مسيرتنا</h3>
                <hr>
            </div>
            <div class="content d-flex align-items-center flex-wrap">
                <div class="image">
                    <div id="splide1" class="splide" aria-labelledby="carousel-heading">
                        <div class="splide__track">
                            <ul class="splide__list">
                                <li class="splide__slide"><img src="{{ asset('front/images/journey.jpg') }}" alt=""></li>
                                <li class="splide__slide"><img src="{{ asset('front/images/journey.jpg') }}" alt=""></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="info">
                    <div class="desc">
                        <p>
                            نحن شوت انج لنـــا تـــاريخ قديم في تـــأسيس الشركـــات
                            <br>
                            الناشئـــة و التسويق الرقمـــي و الميديـــا لأكثر من 150
                            <br>
                            براند واجهتنا أكبر الصعوبـــات و التحديـــات و استطعنـــا
                            <br>
                            حلها بل وسجلنا أرقام و نتائج كبيرة برحله لتحول الرقمي
                        </p>
                    </div>
                    <div class="desc">
                        <p>
                            لنا بصمتنا الخـــاصة و الأولـــي بالسوق التي أستطعنــــا
                            <br>
                            من خلالهـــــــــــا <span>طرح مشـــــــــــاريع تصنيــــــــــع المنتج</span>
                            <br>
                            بصورة مختلفة وجودة تنــافسيـة لدعم المنتج السعودي
                            <br>
                            ممـــا يسهل علينــا تسويق المنتج وفق معــايير النجـــاح
                            <br>
                            و الصناعة تفاديا للمشــاريع المقلدة و أستنســاخ المنتج
                        </p>
                    </div>
                    <div class="desc">
                        <p>
                            المشاريع المدعمة لدينا <span>(العطور - مستحضرات التجميل <br> الملابس - المطاعم -
                                الكافيهات)</span>
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
                        <li class="splide__slide"><img src="{{ asset('front/images/hl-46115193300.png') }}" alt=""></li>
                        <li class="splide__slide"><img src="{{ asset('front/images/hl-46115193301.png') }}" alt=""></li>
                        <li class="splide__slide"><img src="{{ asset('front/images/hl-46115193305.png') }}" alt=""></li>
                        <li class="splide__slide"><img src="{{ asset('front/images/hl-46115193305.png') }}" alt=""></li>
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
                    <h2>فريـــــق شـــــــــوت انج</h2>
                    <img src="{{ asset('front/images/icon1.svg') }}" alt="">
                    <img src="{{ asset('front/images/icon2.svg') }}" alt="">
                </div>
                <p class="text-center lab">
                    فريق من الخبراء المتخصصين في التسويق وتحسين محركات
                    <!-- <br> -->
                    وإنشــــاء البحث والمحتوي و وســــائل التواصل الإجتمـــاعي
                    <br>
                    وإدارة المشــــاريع نتقن نبدع نطور نحقق نجـــــــاح مشروعك
                </p>
                <p class="text-center mob">
                    فريق من الخبراء المتخصصين في التسويق وتحسين محركات
                    <br>
                    وإنشــــاء البحث والمحتوي و وســــائل التواصل الإجتمـــاعي
                    <br>
                    وإدارة المشــــاريع نتقن نبدع نطور نحقق نجـــــــاح مشروعك
                </p>
            </div>
        </div>
    </section>
    <!-- end team-->
    <section class="shooting d-flex justify-content-center align-items-center">
        <img src="{{ asset('front/images/shooting.GIF') }}" alt="">
    </section>
@endsection
