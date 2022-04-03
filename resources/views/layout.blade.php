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
		<link rel="icon" href="/favicon.svg">
		<link rel="stylesheet" href="/assets/css/style.min.css?20220329">
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
							<button id="menu-button" type="button">Menu</button>
						@endif
					</header>
					<nav class="{{ Request::is('/') ? 'show' : '' }}" id="nav">
						<div id="auth">
							@if (Auth::user())
								<form action="/logout" method="post">
									@csrf
									<button type="submit">Logout</button>
								</form>
								<a class="link" href="/recipes/create">Add Recipe</a>
							@else
								<a class="link" href="/login">Login</a>
							@endif
						</div>
						@if ($recipes->isNotEmpty())
							<input autocomplete="off" data-filterable-input data-filterable-key="name" id="search" type="text">
							<ul id="nav-list" data-filterable-list>
								@foreach ($recipes as $recipe)
									<li data-filterable-item class="nav-list__item">
										<a
											class="nav-list__link{{ !empty($row->slug) && $row->slug === $recipe->slug ? ' nav-list__link--active' : '' }}"
											data-key="name"
											href="{{ $recipe->url() }}"
										>
											{{ $recipe->title }}
										</a>
									</li>
								@endforeach
							</ul>
						@endif
						<p id="no-results" style="{{ $recipes->isNotEmpty() ? 'display:none' : '' }}">No recipes found.</p>
					</nav>
				</div>
			@endif
			<article class="{{ !empty($recipes) ? 'article--recipe' : 'article--auth' }}" id="article">
				@yield('content')
			</article>
		</main>
		<script src="/assets/js/functions.min.js?20220329"></script>
	</body>
</html>
