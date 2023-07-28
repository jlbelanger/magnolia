<!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta name="description" content="Recipes.">
		<meta name="keywords" content="recipes, baking, cookies, cake">
		<meta property="og:title" content="{{ !empty($metaTitle) ? $metaTitle . ' | ' : '' }}{{ config('app.name') }} Recipes">
		<meta property="og:description" content="Recipes.">
		@if (!empty($ogImage))
			<meta property="og:image" content="{{ $ogImage }}">
		@endif
		<meta name="apple-mobile-web-app-capable" content="yes">
		<link rel="apple-touch-startup-image" href="{{ url('/assets/img/splash/apple-splash-2048-2732.png') }}" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
		<link rel="apple-touch-startup-image" href="{{ url('/assets/img/splash/apple-splash-1668-2388.png') }}" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
		<link rel="apple-touch-startup-image" href="{{ url('/assets/img/splash/apple-splash-1536-2048.png') }}" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
		<link rel="apple-touch-startup-image" href="{{ url('/assets/img/splash/apple-splash-1668-2224.png') }}" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
		<link rel="apple-touch-startup-image" href="{{ url('/assets/img/splash/apple-splash-1620-2160.png') }}" media="(device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
		<link rel="apple-touch-startup-image" href="{{ url('/assets/img/splash/apple-splash-1290-2796.png') }}" media="(device-width: 430px) and (device-height: 932px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
		<link rel="apple-touch-startup-image" href="{{ url('/assets/img/splash/apple-splash-1179-2556.png') }}" media="(device-width: 393px) and (device-height: 852px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
		<link rel="apple-touch-startup-image" href="{{ url('/assets/img/splash/apple-splash-1284-2778.png') }}" media="(device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
		<link rel="apple-touch-startup-image" href="{{ url('/assets/img/splash/apple-splash-1170-2532.png') }}" media="(device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
		<link rel="apple-touch-startup-image" href="{{ url('/assets/img/splash/apple-splash-1125-2436.png') }}" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
		<link rel="apple-touch-startup-image" href="{{ url('/assets/img/splash/apple-splash-1242-2688.png') }}" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
		<link rel="apple-touch-startup-image" href="{{ url('/assets/img/splash/apple-splash-828-1792.png') }}" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
		<link rel="apple-touch-startup-image" href="{{ url('/assets/img/splash/apple-splash-1242-2208.png') }}" media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
		<link rel="apple-touch-startup-image" href="{{ url('/assets/img/splash/apple-splash-750-1334.png') }}" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
		<link rel="apple-touch-startup-image" href="{{ url('/assets/img/splash/apple-splash-640-1136.png') }}" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
		<title>{{ !empty($metaTitle) ? $metaTitle . ' | ' : '' }}{{ config('app.name') }} Recipes</title>
		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
		<link rel="icon" href="/favicon.svg">
		<link rel="stylesheet" href="{{ mix('/assets/css/style.min.css') }}">
		@if (Auth::user())
			<link rel="stylesheet" href="{{ mix('/assets/css/admin.min.css') }}">
		@endif
		<link rel="manifest" href="/manifest.json">
		<link rel="alternate" type="application/rss+xml" href="/feed.xml">
		<script integrity="sha256-tuKyZn/3ycw/MNMDii/kvSPrelo6SCsJSecqb1n2neg=">document.documentElement.classList.remove('no-js');</script>
	</head>
	<body class="{{ Auth::user() ? 'auth' : '' }}">
		<a class="button" href="#article" id="skip">Skip to content</a>
		<main id="main">
			<header id="header">
				<div class="contain" id="header-inner">
					<a href="/" id="site-title">{{ config('app.name') }} Recipes</a>
					<button
						aria-controls="menu"
						aria-expanded="false"
						class="button--icon"
						id="nav-show"
						title="Show Menu"
						type="button"
					>
						Show Menu
					</button>
					<div id="menu">
						<div id="menu-top">
							<nav id="nav">
								<ul id="nav-list">
									<li class="nav-list__item">
										<a
											class="nav-list__link{{ Request::is('categories/cakes') ? ' nav-list__link--active' : '' }}"
											href="/categories/cakes"
										>
											Cakes
										</a>
									</li>
									<li class="nav-list__item">
										<a
											class="nav-list__link{{ Request::is('categories/cookies') ? ' nav-list__link--active' : '' }}"
											href="/categories/cookies"
										>
											Cookies
										</a>
									</li>
									<li class="nav-list__item">
										<a
											class="nav-list__link{{ Request::is('categories/desserts') ? ' nav-list__link--active' : '' }}"
											href="/categories/desserts"
										>
											Desserts
										</a>
									</li>
									<li class="nav-list__item">
										<a
											class="nav-list__link{{ Request::is('categories/toppings') ? ' nav-list__link--active' : '' }}"
											href="/categories/toppings"
										>
											Toppings
										</a>
									</li>
									<li class="nav-list__item">
										<a
											class="nav-list__link{{ Request::is('categories/other') ? ' nav-list__link--active' : '' }}"
											href="/categories/other"
										>
											Other
										</a>
									</li>
								</ul>
							</nav>
							<form action="/search" id="search" method="get">
								<input aria-label="Search recipes" autocomplete="off" class="prefix" id="search-input" name="q" type="text" value="{{ request()->query('q') }}">
								<button class="postfix" id="search-submit" type="submit">Search</button>
							</form>
						</div>
						@if (Auth::user())
							<section id="admin">
								<a class="button admin__button{{ Request::is('recipes/create') ? ' admin__button--active' : '' }}" href="/recipes/create">Add Recipe</a>
								<a class="button admin__button{{ Request::is('categories/create') ? ' admin__button--active' : '' }}" href="/categories/create">Add Category</a>
								@if (!empty($row) && (Request::is('recipes/*') || Request::is('categories/*')))
									@if (Request::is('*/edit'))
										<a class="button admin__button" href="{{ $row->url() }}">
											View {{ $row->type() }}
										</a>
									@else
										<a class="button admin__button" href="{{ $row->editUrl() }}">
											Edit {{ $row->type() }}
										</a>
									@endif
								@endif
								<div class="flex-grow"></div>
								<a class="button admin__button{{ Request::is('profile') ? ' admin__button--active' : '' }}" href="/profile">Profile</a>
								<form action="/logout" method="post">
									@csrf
									<button data-confirmable="Are you sure you want to log out?" type="button">Logout</button>
								</form>
							</section>
						@endif
					</div>
				</div>
			</header>
			<article class="{{ !empty($articleClass) ? $articleClass : '' }}" id="article-outer">
				<div class="contain" id="article">
					@yield('content')
				</div>
			</article>
			<footer id="footer">
				<div class="contain" id="footer-inner">
					@if (!Auth::user())
						<a class="link" href="/login">Login</a>
					@endif
					<a class="link" href="https://github.com/jlbelanger/magnolia/">GitHub</a>
				</div>
			</footer>
		</main>
		<script src="{{ mix('/assets/js/app.min.js') }}"></script>
		@if (Auth::user())
			<script src="{{ mix('/assets/js/admin.min.js') }}"></script>
		@endif
	</body>
</html>
