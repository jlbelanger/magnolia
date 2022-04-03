<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">
	<url><loc>{{ url('/') }}</loc></url>
	@foreach ($recipes as $recipe)
		<url><loc>{{ url($recipe->url()) }}</loc></url>
	@endforeach
</urlset>
