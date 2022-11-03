<!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta name="description" content="Recipes.">
		<meta name="keywords" content="recipes, baking, cookies, cake">
		<meta property="og:title" content="{{ !empty($metaTitle) ? $metaTitle . ' | ' : '' }}Magnolia">
		<meta property="og:description" content="Recipes.">
		<meta property="og:image" content="{{ !empty($row->filename) ? url('/uploads/' . $row->filename) : url('/uploads/cinnamon-rolls.jpg') }}">
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
		<title>{{ !empty($metaTitle) ? $metaTitle . ' | ' : '' }}Magnolia</title>
		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
		<link rel="icon" href="/favicon.png">
		<link rel="stylesheet" href="/assets/css/style.min.css?20221031">
		<link rel="manifest" href="/manifest.json">
		<link rel="alternate" type="application/rss+xml" href="/feed.xml">
		<script>document.documentElement.classList.remove('no-js');</script>
	</head>
	<body>
		<a class="button" href="#article" id="skip">Skip to content</a>
		<main id="main">
			@if (!empty($recipes))
				<div class="{{ Request::is('/') ? 'show' : '' }}" id="side">
					<header id="header">
						<a href="/" id="site-title">Magnolia</a>
						<img alt="" id="img" src="/favicon.svg">
						@if (!Request::is('/'))
							<button data-toggleable="#nav" id="menu-button" type="button">Menu</button>
						@endif
					</header>
					<nav class="{{ Request::is('/') ? 'show' : '' }}" id="nav">
						<div id="auth">
							@if (Auth::user())
								<form action="/logout" method="post">
									@csrf
									<button type="submit">Logout</button>
								</form>
								<a class="link" href="/profile">Profile</a>
								<a class="link" href="/recipes/create">Add Recipe</a>
							@else
								<a class="link" href="/login">Login</a>
								<a class="link" href="https://github.com/jlbelanger/magnolia/">GitHub</a>
							@endif
						</div>
						@if ($recipes->isNotEmpty())
							<input aria-label="Search recipes" autocomplete="off" data-filterable-input data-filterable-key="name" id="search" type="text">
						@endif
						<p id="no-results" style="{{ $recipes->isNotEmpty() ? 'display:none' : '' }}">No recipes found.</p>
						@if ($recipes->isNotEmpty())
							<ul id="nav-list" data-filterable-list>
								@foreach ($recipes as $recipe)
									<li data-filterable-item class="nav-list__item">
										<a
											class="nav-list__link{{ !empty($row->slug) && $row->slug === $recipe->slug ? ' nav-list__link--active' : '' }}"
											data-key="name"
											href="{{ $recipe->url() }}"
										>
											{{ $recipe->title . ($recipe->is_private ? ' *' : '') }}
										</a>
									</li>
								@endforeach
							</ul>
						@endif
					</nav>
				</div>
			@endif
			<article class="{{ !empty($articleClass) ? $articleClass : '' }}" id="article">
				<div id="article-inner">
					@yield('content')
				</div>
			</article>
		</main>
		<script src="/assets/js/functions.min.js?20221015"></script>
	</body>
</html>
