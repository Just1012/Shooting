@extends('layouts.front')
@section('title')
    Our Works
@endsection
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
@endpush
@section('content')
    <section class="register">
        <div class="container">
            <div class="heading">
                <h3>سجل الأن</h3>
                <hr>
            </div>
            <div class="text">
                <p>
                    سجل الأن واستفد بخدمتك المطلوبة او المشروعك المراد البدء به
                    <br>
                    مع نخبة من أفضل خبراء إنشاء وإدارة المشاريــــــع و التسويــــــق
                </p>
            </div>
            <form action="">
                <div class="d-flex">
                    <div class="map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d927767.3403739077!2d47.481990752489494!3d24.723749996522752!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e2f03890d489399%3A0xba974d1c98e79fd5!2z2KfZhNix2YrYp9i2INin2YTYs9i52YjYr9mK2Kk!5e0!3m2!1sar!2seg!4v1722787660855!5m2!1sar!2seg"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="formInputs">
                        <h2>التسجيل</h2>
                        <div class="inputs">
                            <div class="input">
                                <label for="name">الأسم بالكامل</label>
                                <input type="text" id="name" placeholder="الأسم بالكامل" required>
                            </div>
                            <div class="email-phone">
                                <div class="labels">
                                    <label for="phone">الجوال/</label>
                                    <label for="email">الأيميل</label>
                                </div>
                                <div class="inputs-email-phone">
                                    <input type="email" id="email" placeholder="الإيميل" required>
                                    <input type="number" placeholder="رقم الجوال" id="phone" required>
                                </div>
                            </div>
                        </div>
                        <div class="textarea-date-time">
                            <div class="textarea">
                                <label for="message">الرسالة أو الخدمة</label>
                                <textarea name="" id="message" placeholder="رسالتك" required></textarea>
                            </div>
                            <div class="date-time">
                                <label for="dateTime">التاريخ / الوقت</label>
                                <input type="datetime" placeholder="حدد التاريخ و الوقت" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-alert">
                        <p>
                            أختر يومك المنـاسب وسيتم التواصل معك لتأكـيد موعدك
                            <br>
                            سعداء بإنضمامك لمجموعه شوت انج كفرد من أفرد عائلتها
                        </p>
                    </div>
                </div>
                <input type="submit" value="تسجيل" id="">
            </form>
        </div>
    </section>
    <section class="shooting d-flex justify-content-center align-items-center">
        <img src="{{ asset('images/' . $gif->footer_gif) }}" alt="">
    </section>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script>
        config = {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            altInput: true,
            altFormat: "F j, Y (H:i K)",
            // noCalendar: true,
            dateFormat: "",
        }
        flatpickr("input[type=datetime]", config);
    </script>
@endpush
