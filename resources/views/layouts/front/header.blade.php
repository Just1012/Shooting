 <!-- start header  -->
 @php
     $data = App\Models\SystemSetup::first();
     $systemData = App\Models\SystemInfo::first();
 @endphp
 <header>
     <div class="container">
         <div class="content d-flex flex-wrap justify-content-between align-items-center">
             <div class="left">
                 <div class="icons d-flex align-items-center">
                     <a href="{{ $systemData->snapchat }}" class="icon">
                         <i class="fa-brands fa-snapchat"></i>
                     </a>
                     <a href="{{ $systemData->facebook }}" class="icon">
                         <i class="fa-brands fa-facebook-f"></i>
                     </a>
                     <a href="{{ $systemData->instagram }}" class="icon">
                         <i class="fa-brands fa-instagram"></i>
                     </a>
                     <a href="{{ $systemData->whatsapp }}" class="icon">
                         <i class="fa-brands fa-whatsapp"></i>
                     </a>
                     <a class="lang">
                         <button id="langButton" onclick="toggleLanguage()">
                             {{ app()->getLocale() === 'en' ? 'العربية' : 'English' }}
                         </button>
                     </a>
                 </div>
             </div>
             <div class="right">
                 <!-- <a class="singup" href="./register.html">
            <p class="m-0">تسجيل الدخول</p>
            <i class="fa-regular fa-user"></i>
          </a> -->
                 <div class="email">
                     <p class="m-0">{{ $systemData->email }}</p>
                 </div>
             </div>
         </div>
     </div>
 </header>
 <!-- end header  -->
 <script>
     function toggleLanguage() {
         var currentLocale = '{{ app()->getLocale() }}';
         var selectedLocale = currentLocale === 'en' ? 'ar' : 'en';
         var currentUrl = window.location.href;
         var url = new URL(currentUrl);
         var pathParts = url.pathname.split('/').filter(Boolean);

         // Identify the position of the current locale in the path
         var localeIndex = pathParts.findIndex(part => part === 'en' || part === 'ar');

         // Replace the current locale with the selected locale
         if (localeIndex !== -1) {
             pathParts[localeIndex] = selectedLocale;
         } else {
             // If no locale is found in the path, add the selected locale at the start
             pathParts.unshift(selectedLocale);
         }

         // Construct the new URL path
         var localizedPath = '/' + pathParts.join('/');
         var localizedUrl = url.origin + localizedPath;

         // Preserve query parameters
         if (url.search) {
             localizedUrl += url.search;
         }

         // Redirect to the appropriate URL based on the selected language
         window.location.href = localizedUrl;
     }
 </script>
 <!-- start nav  -->
 <nav>
     <div class="container">
         <div class="content d-flex justify-content-between align-items-center flex-wrap">
             <div class="logo">
                 <img src="{{ asset('images/' . $data->header_logo) }}" alt="">
             </div>
             <ul class="links">
                 <a href="./index.html">
                     <span>01</span>
                     الرئيسية
                 </a>
                 <a href="./about_us.html">
                     <span>02</span>
                     من نحن
                 </a>
                 <a href="./services.html">
                     <span>03</span>
                     الخدمات
                 </a>
                 <a href="./Our_business.html">
                     <span>04</span>
                     أعمالنا
                 </a>
                 <a href="./Our_customers.html">
                     <span>05</span>
                     عملائنا
                 </a>
                 <a href="./Industry.html">
                     <span>06</span>
                     الصناعة
                 </a>
                 <a href="./recruitment.html">
                     <span>07</span>
                     التدريب و التوظيف
                 </a>
                 <div class="Btn-phone">
                     <a href="./register.html" class="btn">تواصل معانا</a>
                 </div>
                 <!-- <a href="" class="Btn"></a> -->
             </ul>
             <div class="Btn">
                 <a href="./register.html" class="btn m-0">تواصل معانا</a>
             </div>
             <!-- <div class="menu">
          <div>
            <span></span>
            <span></span>
            <span></span>
          </div>
        </div> -->
             <div class="icon">
                 <i class="fa-solid fa-bars"></i>
             </div>
         </div>
     </div>
 </nav>
 <!-- end nav  -->
