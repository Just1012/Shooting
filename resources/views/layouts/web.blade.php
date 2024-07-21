<!DOCTYPE html>
<html lang="en" data-layout="twocolumn" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none"
    data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('web/assets/images/favicon.ico') }}">


    <!-- jsvectormap css -->
    <link href="{{ asset('web/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ asset('web/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="{{ asset('web/assets/js/layout.js') }}"></script>

    <!-- Icons Css -->
    <link href="{{ asset('web/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    @if (App::getLocale() == 'ar')
        <link href="{{ asset('web/assets/css/app-rtl.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('web/assets/css/custom-rtl.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('web/assets/css/bootstrap-rtl.min.css') }}" rel="stylesheet" type="text/css" />
    @else
        <link href="{{ asset('web/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('web/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('web/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    @endif
    <!-- custom Css-->
    <link rel="stylesheet" href="https://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        * {
            font-family: 'cairo' !important;
        }
    </style>
    @stack('css')
</head>

<body dir="{{ App::getLocale() == 'ar' ? 'rtl' : '' }}">
    <div id="layout-wrapper">
        @auth


            @include('layouts.web_ex.header')
            @include('layouts.web_ex.notavcation')
            @include('layouts.web_ex.menu')
        @endauth

        <div class="vertical-overlay"></div>
        @yield('content')

    </div>
    @auth
        @include('layouts.web_ex.preloader')
        @include('layouts.web_ex.customizer')
        @include('layouts.web_ex.thems')
    @endauth


    <!-----------
<script async>
    if (document.addEventListener) {
        document.addEventListener('contextmenu', function(e) {
            // alert("This function has been disabled to prevent you from stealing my code!");
            e.preventDefault();
        }, false);
    } else {
        document.attachEvent('oncontextmenu', function() {
            //  alert("This function has been disabled to prevent you from stealing my code!");
            window.event.returnValue = false;
        });
    }

    document.addEventListener('keydown', function(event) {
        if (event.keyCode == 123) {
            //    alert("This function has been disabled to prevent you from stealing my code!");
            window.event.returnValue = false;
            return false;
        } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) {
            //  alert("This function has been disabled to prevent you from stealing my code!");
            window.event.returnValue = false;
            return false;
        } else if (event.ctrlKey && event.keyCode == 85) {
            ///  alert("This function has been disabled to prevent you from stealing my code!");
            window.event.returnValue = false;
            return false;
        }
    }, false);
</script>
  ------------>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- JAVASCRIPT -->
    <script src="{{ asset('web/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('web/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('web/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('web/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('web/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('web/assets/js/plugins.js') }}"></script>

    <!-- apexcharts -->
    <script src="{{ asset('web/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <!-- Vector map-->
    <script src="{{ asset('web/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>

    <script src="{{ asset('web/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!--Swiper slider js-->
    <script src="{{ asset('web/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Dashboard init -->
    <script src="{{ asset('web/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>


    <!-- App js -->
    <script src="{{ asset('web/assets/js/app.js') }}"></script>
    <script src="https://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>

    <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: 'textarea#myeditorinstance',
            plugins: 'code table lists textcolor', // Include the textcolor plugin
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | forecolor backcolor | code | table', // Add forecolor and backcolor options
            toolbar_drawer: 'floating', // Optional: Change toolbar style to floating for better visibility
        });
    </script>

    <script>
        @if (Session::has('toastr'))
            {!! Session::get('toastr') !!}
        @endif
    </script>
    @stack('js')

</body>

</html>
