<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">

        <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />      

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script> --}}
    </head>
    <body>
        <div class="container-scroller">
            @include('elements.header')
            
            <div class="container-fluid page-body-wrapper">
                @include('elements.configView')
                @include('elements.menu')
                
                {{-- Sidebar --}}
                @include('elements.sidebar')
                
                <div class="main-panel">
                    <div class="content-wrapper">
                        @isset($breadcumps)
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    {{ $breadcumps }}
                                </div>
                            </div>
                        @endisset
                        
                        {{ $header }}

                        @if (Session::has('message'))
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-success" role="alert">
                                        {{ Session::get('message') }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{ $slot }}
                    </div>

                    {{-- Footer --}}
                    @include('elements.footer')
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
        
        <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
        <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
        <script src="{{ asset('assets/js/template.js') }}"></script>
        <script src="{{ asset('assets/js/settings.js') }}"></script>
        <script src="{{ asset('assets/js/todolist.js') }}"></script>

        <script src="{{ asset('assets/js/sweetalert.js') }}"></script>

        @isset($scripts)
            {{ $scripts }}
        @endisset
    </body>
</html>
