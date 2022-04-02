<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="description" content="Recipes.">
		<meta name="keywords" content="recipes, baking, cookies, cake">
		<meta property="og:title" content="{{ !empty($metaTitle) ? $metaTitle . ' | ' : '' }}Magnolia">
		<meta property="og:description" content="Recipes.">
		<title>{{ !empty($metaTitle) ? $metaTitle . ' | ' : '' }}Magnolia</title>
		<link rel="icon" href="{{ url('/favicon.svg') }}">
		<link rel="stylesheet" href="{{ url('/assets/css/style.min.css?20220329') }}">
	</head>
	<body>
		<main id="main">
			<div id="side">
				<header id="header">
					<a href="/" id="title">Magnolia</a>
					<img alt="" id="img" src="/favicon.svg">
					@if (!empty($row))
						<button id="menu-button" type="button">Menu</button>
					@endif
				</header>
				<nav class="{{ empty($row) ? 'show' : '' }}" id="nav">
					<input autocomplete="off" data-filterable-input data-filterable-key="name" id="search" type="text">
					<ul id="nav-list" data-filterable-list>
						@foreach ($recipes as $recipe)
							<li data-filterable-item class="nav-list__item">
								<a
									class="nav-list__link{{ !empty($row->slug) && $row->slug === $recipe->slug ? ' nav-list__link--active' : '' }}"
									data-key="name"
									href="/recipes/{{ $recipe->slug }}"
								>
									{{ $recipe->title }}
								</a>
							</li>
						@endforeach
					</ul>
				</nav>
			</div>
			<article id="article">
				@yield('content')
			</article>
		</main>
		<script src="{{ url('/assets/js/functions.min.js?20220329') }}"></script>
	</body>
</html>
