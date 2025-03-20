
<!DOCTYPE html>
<html lang="id">
<head>

    <title>{{ $attributes->get('title') ? $attributes->get('title') . ' | Pondok Sawah | PP BU Al-Hamid' : 'Pondok Sawah | PP BU Al-Hamid' }}</title>


	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="Webestica.com">
	<meta name="description" content="Pondok Sawah adalah sebutan dari Pondok Pesantren Bahrul Ulum Al-Hamid Gondanglegi Malang">

	<!-- Favicon -->
	<link rel="shortcut icon" href="{{ Vite::asset('resources/backend/img/logo.ico') }}">

	<!-- Google Font -->
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;700&family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">

	<!-- Plugins CSS -->
	<link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/vendor/font-awesome/css/all.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/vendor/bootstrap-icons/bootstrap-icons.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/vendor/tiny-slider/tiny-slider.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/vendor/plyr/plyr.css') }}">

	<!-- Theme CSS -->
	<link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/css/style.css') }}">
	<script src="{{ Vite::asset('resources/vendor/vanilla-lazyload/lazyload.min.js') }}"></script>
</head>

<body>

@include('frontend.components.header')

<main>

	@include('frontend.components.trending-top')

	@include('frontend.components.main-hero')

</main>

@include('frontend.components.footer')

<div class="back-top"><i class="bi bi-arrow-up-short"></i></div>

<!-- Bootstrap JS -->
<script src="{{ Vite::asset('resources/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

<!-- Vendors -->
<script src="{{ Vite::asset('resources/vendor/tiny-slider/tiny-slider.js') }}"></script>
<script src="{{ Vite::asset('resources/vendor/sticky-js/sticky.min.js') }}"></script>
<script src="{{ Vite::asset('resources/vendor/plyr/plyr.js') }}"></script>

<!-- Template Functions -->
<script src="{{ Vite::asset('resources/views/frontend/components/main.js') }}"></script>
<script src="{{ Vite::asset('resources/js/functions.js') }}"></script>
</body>
</html>