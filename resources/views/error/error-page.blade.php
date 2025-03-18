<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Dashboard Pondok Bahrul Ulum Al-Hamid">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link rel="shortcut icon" href="{{ Vite::asset('resources/backend/img/logo.ico') }}" />

    <title>{{ $title }}</title>

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
</head>

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
	<main class="d-flex w-100 h-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center">
							<h1 class="display-1 fw-bold">{{ $code }}</h1>
							<p class="h2">{!! $message !!}</p>
							<p class="lead fw-normal mt-3 mb-4">{{ $message2 }}</p>
							<a class='btn btn-primary btn-lg' href='javascript:history.back()'>Kembali</a>
						</div>

					</div>
				</div>
			</div>
		</div>
	</main>

    <script src="{{ Vite::asset('resources/backend/js/app.js') }}"></script>
    @if(session('success'))
        <script>
            window.onload = function() {
                window.location.href = "/dashboard";
            };
        </script>
    @endif
</body>

</html>