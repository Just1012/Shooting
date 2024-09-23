@extends('layouts.front')
@section('title')
    Traning & Hiring Page
@endsection
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
@endpush
@section('content')
    <section class="recruitment_bg">
        <div class="container">
            <div class="text">
                <p>أسلوبنا لغة ونحن أحرفها وانت حرف بحضورك أكتملت معانينا</p>
            </div>
            <div class="heading">
                <h3>فأهلا ثم أهلا بكم</h3>
                <hr>
            </div>
            <div class="departements">
                <div class="training">
                    <h3>قسم التدريب</h3>
                    <p>
                        هو قسم مقدم لأصحــــــاب المواهب و الــــــرؤي فـي
                        <br>
                        المجال الفنـــي و التسويـــق ليــــكونوا ضمن فريقنـــا
                    </p>

                    <p>
                        <strong>يهدف القسم</strong> لتطويـــــر المعــــــارف و المهــــــــــارات
                        <br>
                        لإكتساب الخبــرات اللازمة للمشاركة في سوق العمــل
                    </p>
                </div>
                <div class="recruitment">
                    <h3>قسم التوظيف</h3>
                    <p>
                        لأن موظفين شوت انج يطلق عليهم تجار ذوق أي نتاجر
                        <br>
                        ونبيــع الذوق قبل ان يكون سلعة أو خدمة فــأننا نبحث
                        <br>
                        عن المتميزون أصحــاب الذوق الرفيع الذي لديــهم ثقل
                        <br>
                        الموهبة بالمجـــــال الفنـــي ودراية كــــــافية بتطورات
                        <br>
                        السوق والخبرات الإبداعية ليكونوا شركــائنا بالــمسيرة
                    </p>
                </div>
            </div>
            <div class="image">
                <img src="{{ asset('front/images/Banner 22 copy.jpg') }}" alt="">
            </div>

            <form action="">
                <div class="left">
                    <input type="text" name="" id="" placeholder="الأسم بالكامل">
                    <input type="email" name="" id="" placeholder="البريد الألكتروني">
                    <input type="tel" name="" id="phone" placeholder="رقم الهاتف">
                    <div class="portfilo">
                        <label for="portfilo">أرفق السيرة الذاتية أو البورتفوليو</label>
                        <input type="file" class="dropify" data-height="100" data-width="50" class="w-100"
                            name="" id="portfilo">
                    </div>
                    <p>pdf - txt - doc - docs :يجب اللا يزيد حجم الملف عن 10 ميجابايت | صيغة الملف المدعومة*</p>
                </div>
                <div class="right">
                    <select name="" id="">
                        <option value="أختيار قسم التقديم" selected disabled>أختير قسم التقديم</option>
                        <option value="قسم التدريب">قسم التدريب</option>
                        <option value="قسم التوظيف">قسم التوظيف</option>
                    </select>
                    <textarea name="" id="" placeholder="رسالتك"></textarea>
                    <input type="submit" value="إرسال">
                </div>
            </form>
        </div>
    </section>
    <section class="shooting d-flex justify-content-center align-items-center">
        <img src="{{ asset('images/' . $gif->footer_gif) }}" alt="">
    </section>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script>
        $('.dropify').dropify();
    </script>
    <script>
        const input = document.querySelector("#phone");

        const iti = window.intlTelInput(input, {
            initialCountry: "auto",
            geoIpLookup: function(callback) {
                fetch('https://ipinfo.io/json')
                    .then(response => response.json())
                    .then(data => callback(data.country))
                    .catch(() => callback('us'));
            },
            onlyCountries: ["ae", "eg", "iq", "jo", "kw", "lb", "om", "ps", "qa", "sa", "sy", "tr", "ye"],
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"
        });

        input.addEventListener("countrychange", function() {
            const dialCode = iti.getSelectedCountryData().dialCode;
            input.value = `+${dialCode} `;
        });

        input.addEventListener("focus", function() {
            if (input.value === `+` || input.value.trim() === '') {
                input.value = '';
                input.placeholder = '';
            }
        });

        // input.addEventListener("blur", function() {
        //     if (input.value.trim() === '') {
        //         input.placeholder = 'Your phone number';
        //     }
        // });
    </script>
@endpush
