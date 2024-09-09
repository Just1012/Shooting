<footer>
    @php
        $data = App\Models\SystemSetup::first();
        $systemData = App\Models\SystemInfo::first();
    @endphp
    <div class="container">
        <div class="image">
            <img src="{{ asset('images/' . $data->footer_logo) }}" alt="">
        </div>
        <p class="text-center m-sm-0">{{ $data->{App::getLocale() == 'ar' ? 'footer_quote_ar' : 'footer_quote_en'} }}</p>

        <div class="boxes d-flex justify-content-between align-items-start flex-wrap">
            <div class="box small">
                <h3>وسائل التواصل</h3>
                <div class="icons d-flex justify-content-start align-items-center">
                    <a href="{{ $systemData->facebook }}" class="icon">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="{{ $systemData->instagram }}" class="icon">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="{{ $systemData->snapchat }}" class="icon">
                        <i class="fa-brands fa-snapchat"></i>
                    </a>
                    <a href="{{ $systemData->tiktok }}" class="icon">
                        <i class="fa-brands fa-tiktok"></i>
                    </a>
                    <a href="{{ $systemData->whatsapp }}" class="icon">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                </div>
            </div>
            <div class="box ">
                <h3 style="text-align: right;">تواصل معانا</h3>
                <div class="phone">
                    <div class="icon">
                        <i class="fa-solid fa-mobile"></i>
                    </div>
                    <p>{{ $systemData->phone }}</p>
                </div>
                <div class="email">
                    <div class="icon">
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                    <p>{{ $systemData->email }}</p>
                </div>
            </div>
            <div class="box">
                <h3 style="text-align: right;">العنوان</h3>
                <div class="location">
                    <div class="icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <p>{!! $systemData->{App::getLocale() == 'ar' ? 'address_ar' : 'address_en'} !!}</p>
                </div>
            </div>
        </div>
    </div>
</footer>
