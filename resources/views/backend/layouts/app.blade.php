<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Dashboard Pondok Bahrul Ulum Al-Hamid">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link rel="shortcut icon" href="{{ Vite::asset('resources/backend/img/logo.ico') }}" />

    <title>{{ $attributes->get('title') ? $attributes->get('title') . ' | Dashboard' : 'Dashboard' }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&amp;display=swap" rel="stylesheet">

    @php
    $lightCss = Vite::asset('resources/backend/css/light.css');
    $darkCss = Vite::asset('resources/backend/css/dark.css');
    @endphp

    <script>
    window.themeUrls = {
        light: "{{ $lightCss }}",
        dark: "{{ $darkCss }}"
    };
    </script>

    <link class="js-stylesheet" href="{{ $lightCss }}" data-light="{{ $lightCss }}" data-dark="{{ $darkCss }}" rel="stylesheet">
    @vite([
    'resources/backend/js/settings.js',
    'resources/backend/js/vite.theme.js'
    ])
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
    <div class="wrapper">

        @include('backend.components.sidebar')

        <div class="main">

            @include('backend.components.navbar')

            @if (Route::currentRouteName() !== 'dashboard')
                {{-- @include('backend.components.breadcrumbs') --}}
                {{-- <p>DEBUG: {{ $title }}</p>  --}}
                @include('backend.components.breadcrumbs', ['title' => $attributes->get('title')])
            @endif

            <main class="content pt-4">
                <div class="container-fluid">
                    {{ $slot }}
                </div>
            </main>



            @include('backend.components.footer')
        </div>
    </div>

    <script src="{{ Vite::asset('resources/backend/js/app.js') }}"></script>
    @if(session('success'))
        <script>
            window.onload = function() {
                Swal.fire({
                    title: "Login Berhasil!",
                    text: "Selamat datang di Dashboard!",
                    icon: "success",
                    timer: 5000
                });
            };
        </script>
    @endif
</body>

</html>