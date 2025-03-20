<footer class="bg-dark pt-5">
	<div class="container">
		<!-- About and Newsletter START -->
		<div class="row pt-3 pb-4">
			<div class="col-md-3">
				<img src="{{ Vite::asset('resources/images/logo-bu.png') }}" alt="footer logo" style="height: 84px;">
			</div>
			<div class="col-md-5">
				<p class="text-body-secondary">Pondok Sawah adalah sebutan dari Pondok Pesantren Bahrul Ulum Al-Hamid Gondanglegi Malang</p>
				<p class="text-body-secondary pt-1" >Jl. Sumber Agung, Ganjaran Selatan, Ganjaran, Kec. Gondanglegi, Kabupaten Malang, Jawa Timur 65174</p>
			</div>
			<div class="col-md-4">
				<!-- Form -->
				<form class="row row-cols-lg-auto g-2 align-items-center justify-content-end">
					<div class="col-12">
						<input type="email" class="form-control" placeholder="Enter your email address">
					</div>
					<div class="col-12">
						<button type="submit" class="btn btn-primary m-0">Subscribe</button>
					</div>
					<div class="form-text mt-2">By subscribing you agree to our 
						<a href="#" class="text-decoration-underline text-reset">Privacy Policy</a>
					</div>
				</form>
			</div>
		</div>

		<!-- Divider -->
		<hr>

		<!-- Widgets START -->
		<div class="row pt-5">
			<!-- Footer Widget -->
			<div class="col-md-6 col-lg-3 mb-4">
				<h5 class="mb-4 text-white">Recent post</h5>
				<!-- Item -->
				<div class="mb-4 position-relative">
					<div><a href="#" class="badge text-bg-danger mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>Business</a></div>
					<a href="post-single-3.html" class="btn-link text-white fw-normal">Up-coming business bloggers, you need to watch</a>
					<ul class="nav nav-divider align-items-center small mt-2 text-body-secondary">
						<li class="nav-item position-relative">
							<div class="nav-link">by <a href="#" class="stretched-link text-reset btn-link">Dennis</a>
							</div>
						</li>
						<li class="nav-item">Apr 06, 2022</li>
					</ul>
				</div>
				<!-- Item -->
				<div class="mb-4 position-relative">
					<div><a href="#" class="badge text-bg-info mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>Marketing</a></div>
					<a href="post-single-3.html" class="btn-link text-white fw-normal">How did we get here? The history of the business told through tweets</a>
					<ul class="nav nav-divider align-items-center small mt-2 text-body-secondary">
						<li class="nav-item position-relative">
							<div class="nav-link">by <a href="#" class="stretched-link text-reset btn-link">Larry</a>
							</div>
						</li>
						<li class="nav-item">May 29, 2022</li>
					</ul>
				</div>
			</div>

			<!-- Footer Widget -->
			<div class="col-md-6 col-lg-3 mb-4">
				<h5 class="mb-4 text-white">Navigation</h5>
				<div class="row">
					<div class="col-6">
						<ul class="nav flex-column text-primary-hover">
							<li class="nav-item"><a class="nav-link pt-0" href="#">Features</a></li>
							<li class="nav-item"><a class="nav-link" href="#">Style Guide</a></li>
							<li class="nav-item"><a class="nav-link" href="#">Contact us</a></li>
							<li class="nav-item"><a class="nav-link" href="#">Get Theme</a></li>
							<li class="nav-item"><a class="nav-link" href="#">Support</a></li>
							<li class="nav-item"><a class="nav-link" href="#">Privacy Policy</a></li>
							<li class="nav-item"><a class="nav-link" href="#">Newsletter</a></li>
						</ul>
					</div>
 					<div class="col-6">
						<ul class="nav flex-column text-primary-hover">
							<li class="nav-item"><a class="nav-link pt-0" href="#">News</a></li>
							<li class="nav-item"><a class="nav-link" href="#">Career <span class="badge text-bg-danger ms-2">2 Job</span></a></li>
							<li class="nav-item"><a class="nav-link" href="#">Technology</a></li>
							<li class="nav-item"><a class="nav-link" href="#">Startups</a></li>
							<li class="nav-item"><a class="nav-link" href="#">Gadgets</a></li>
							<li class="nav-item"><a class="nav-link" href="#">Inspiration</a></li>
						</ul>
					</div>
				</div>
			</div>

			<!-- Footer Widget -->
			<div class="col-sm-6 col-lg-3 mb-4">
				<h5 class="mb-4 text-white">Get Regular Updates</h5>
				<ul class="nav flex-column text-primary-hover">
					<li class="nav-item"><a class="nav-link pt-0" href="#"><i class="fab fa-whatsapp fa-fw me-2"></i>WhatsApp</a></li>
					<li class="nav-item"><a class="nav-link" href="#"><i class="fab fa-youtube fa-fw me-2"></i>YouTube</a></li>
					<li class="nav-item"><a class="nav-link" href="#"><i class="far fa-bell fa-fw me-2"></i>Website Notifications</a></li>
					<li class="nav-item"><a class="nav-link" href="#"><i class="far fa-envelope fa-fw me-2"></i>Newsletters</a></li>
					<li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-headphones-alt fa-fw me-2"></i>Podcasts</a></li>
				</ul>
			</div>

			<!-- Footer Widget -->
			<div class="col-sm-6 col-lg-3 mb-4">
				<h5 class="mb-4 text-white">Our mobile App</h5>
				<p class="text-body-secondary">Download our App and get the latest Breaking News Alerts and latest headlines and daily articles near you.</p>
				<div class="row g-2">
					<div class="col">
						<a href="#"><img class="w-100" src="assets/images/app-store.svg" alt="app-store"></a>
					</div>
					<div class="col">
						<a href="#"><img class="w-100" src="assets/images/google-play.svg" alt="google-play"></a>
					</div>
				</div>
			</div>
		</div>
		<!-- Widgets END -->

		<!-- Hot topics START -->
		@if (!empty($mostSubCat))
		@php
			$btnColors = ['primary', 'danger', 'success', 'warning', 'info'];
			$lastColor = null;
		@endphp

		<div class="row">
			<ul class="list-inline lh-lg">
				<li class="list-inline-item h5">Trending tags:</li>
				@foreach ($mostSubCat as $msc)
					@php
						$randomColor = array_shift($btnColors);

						if ($randomColor === $lastColor) {
							$btnColors[] = $randomColor; 
							$randomColor = array_shift($btnColors); 
						}

						$btnColors[] = $randomColor; 
						$lastColor = $randomColor; 
					@endphp
					<li class="list-inline-item"><a href="#" class="btn btn-sm btn-{{ $randomColor }}-soft">{{ $msc }}</a></li>
				@endforeach
			</ul>
		</div>
		@endif
		<!-- Hot topics END -->
	</div>

	<!-- Footer copyright START -->
	<div class="bg-dark-overlay-3 mt-5">
		<div class="container">
			<div class="row align-items-center py-4">
				<div class="col-md-12">
					<!-- Copyright -->
					<div class="text-center text-primary-hover text-body-secondary">©2025 <a href="https://linktr.ee/AGADev" class="text-reset btn-link" target="_blank">AGA Dev</a>. All rights reserved
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>