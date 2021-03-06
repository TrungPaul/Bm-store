<!DOCTYPE html>
<html lang="en">

    <!-- begin::Head -->
    <head>
        <base href="">
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('page_title')</title>
        <meta name="description" content="Updates and statistics">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!--begin::Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">
        <!--end::Fonts -->

        <!--begin::Global Theme Styles(used by all pages) -->
        <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        <!--end::Global Theme Styles -->

        <!--begin::Layout Skins(used by all pages) -->
        <link href="{{ asset('assets/css/skins/header/base/light.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/skins/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/skins/brand/dark.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/skins/aside/dark.css') }}" rel="stylesheet" type="text/css" />
        <!--end::Layout Skins -->

        <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />

        <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" />

        @yield('styles')

        <script>
            const baseUrl = "{{ config('app.url') }}"
            const currentLang = "{{ app()->getLocale() }}"
            // console.log(currentLang);
        </script>
    </head>
    <!-- end::Head -->

<!-- begin::Body -->

<body id="loading" class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
    @yield('body')
    <!-- begin::Global Config(global config for global JS sciprts) -->
    <script>
        var KTAppOptions = {
            "colors": {
                "state": {
                    "brand": "#5d78ff",
                    "dark": "#282a3c",
                    "light": "#ffffff",
                    "primary": "#5867dd",
                    "success": "#34bfa3",
                    "info": "#36a3f7",
                    "warning": "#ffb822",
                    "danger": "#fd3995"
                },
                "base": {
                    "label": [
                        "#c5cbe3",
                        "#a1a8c3",
                        "#3d4465",
                        "#3e4466"
                    ],
                    "shape": [
                        "#f0f3ff",
                        "#d9dffa",
                        "#afb4d4",
                        "#646c9a"
                    ]
                }
            }
        };
    </script>
    <!-- end::Global Config -->

    <!--begin::Global Theme Bundle(used by all pages) -->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/lodash.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/jquery.loading.min.js') }}" type="text/javascript"></script>
    <!--end::Global Theme Bundle -->
    <script src="{{ asset('assets/js/toastr.min.js') }}" type="text/javascript"></script>
    <!--end::Global Theme Bundle -->
    <script type="module">
        @if (Session::get('success'))
        toastr.success("{{ Session::get('success') }}");
        @elseif(Session::get('warning'))
        toastr.warning("{{ Session::get('warning') }}");
        @elseif(Session::get('error'))
        toastr.error("{{ Session::get('error') }}");
        @endif
    </script>
    @yield('scripts')
    @stack('multiple_scripts')
</body>
<!-- end::Body -->
</html>
