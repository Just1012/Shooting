<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('front/css/normalize.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css') }}" />
    @if (App::getLocale() == 'ar')
        <link rel="stylesheet" href="{{ asset('front/css/style_ar.css') }}" />
    @else
        <link rel="stylesheet" href="{{ asset('front/css/style.css') }}" />
        {{-- <link rel="stylesheet" href="{{ asset('front/css/style.css') }}" /> --}}
    @endif
    <link rel="icon" href="{{ asset('front/images/Web Shooting-04.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
    @stack('css')
</head>

<body>
    @include('layouts.front.header')
    @yield('content')
    @include('layouts.front.footer')
</body>
<script src="{{ asset('front/js/bootstrap.bundle.js') }}"></script>
<script src="{{ asset('front/js/main.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var splide = new Splide('#splide1', {
            type: 'loop',
        }).mount();

        var splide = new Splide('#splide2', {
            type: 'loop',
            perPage: 4,
            perMove: 1,
            breakpoints: {
                767: {
                    perPage: 2,
                },
                991: {
                    perPage: 3,
                },
            }
        }).mount();

    });
</script>
@stack('js')

</html>
