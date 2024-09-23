@extends('layouts.front')
@section('title')
    Industry
@endsection
@section('content')
    <section class="industry">
        <div class="container">
            <div class="heading">
                <h3>الصناعة</h3>
                <hr>
            </div>
            <div class="info">
                <div class="left">
                    <p>
                        أنفردت شوت انج كـأول وكـــالة تدعم المــنتج من
                        <br />
                        الصناعة إالي التسويق بإعتبارها تستخدم سلاحها
                        <br />
                        الأول وهو التسويـق بالمحتوي فإن حودة المنتج
                        <br />
                        هو هدفهـــــــا الأول يــبني عليـــــه استراتـــيجية
                        <br>
                        التسويق الناجحة
                    </p>
                </div>
                <div class="right">
                    <p>
                        ونظرا لخبرات شوت انج بالصناعة ومعايير الجودة
                        <br />
                        فــإنها تساعد أصحـاب المشـاريع القـادمة بضبط
                        <br />
                        معــــايير الجودة واختيــار الحرف الجديـــدة الــتي
                        <br />
                        تستطيـع أن تقدم لهم أفضل قيم الصنــاعة التي
                        <br />
                        تدعمهــــا من التعمق بالتفاصيـــل الدقيقـة إلي
                        <br>
                        جودة وإحترافية الشكل الخارجي
                    </p>
                </div>
            </div>

            <h3 class="title">مجالات الصناعة</h3>
            <div class="boxes">
                <div class="box">
                    <h3>الكافيهات</h3>
                    <a href="#">
                        أستكشف
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <img src="{{ asset('front/images/Pages inside-11.png') }}" alt="">
                    <div class="icon">
                        <img src="{{ asset('front/images/icon web-09.png') }}" style="top: 0;" alt="">
                    </div>
                </div>
                <div class="box">
                    <a href="#">
                        أستكشف
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <h3>المطاعم</h3>
                    <img src="{{ asset('front/images/Pages inside-12.png') }}" alt="">
                    <div class="icon">
                        <img src="{{ asset('front/images/icon web-13.png') }}" style="top: 0;" alt="">
                    </div>
                </div>
                <div class="box">
                    <h3>الملابس</h3>
                    <a href="#">
                        أستكشف
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <img src="{{ asset('front/images/Pages inside-11.png') }}" alt="">
                    <div class="icon">
                        <img src="{{ asset('front/images/icon web-10.png') }}" style="top: 0;" alt="">
                    </div>
                </div>
                <div class="box">
                    <a href="#">
                        أستكشف
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <h3>مستحضرات التجميــــــل</h3>
                    <img src="{{ asset('front/images/Pages inside-12.png') }}" alt="">
                    <div class="icon">
                        <img src="{{ asset('front/images/icon web-13.png') }}" style="top: 0;" alt="">
                    </div>
                </div>
                <div class="box">
                    <h3>العطور</h3>
                    <a href="#">
                        أستكشف
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <img src="{{ asset('front/images/Pages inside-11.png') }}" alt="">
                    <div class="icon">
                        <img src="{{ asset('front/images/icon web-12.png') }}" style="top: 0;" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="shooting d-flex justify-content-center align-items-center">
        <img src="{{ asset('images/' . $gif->footer_gif) }}" alt="">
    </section>
@endsection
