<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<atom:link href="{{ url('/feed.xml') }}" rel="self" type="application/rss+xml" />
		<title>Magnolia</title>
		<description>Recipes.</description>
		<link>{{ url('/') }}</link>
		@foreach ($recipes as $recipe)
			<item>
				<title>{{ $recipe->title }}</title>
				<pubDate>{{ date('r', strtotime($recipe->published_at)) }}</pubDate>
				<guid>{{ url($recipe->url()) }}</guid>
				<description><![CDATA[
					@if ($recipe->filename)
						<p><img alt="" height="405" id="recipe-image" src="{{ url('/uploads/' . $recipe->filename) }}" width="720" /></p>
					@endif
					{!! $recipe->summary() !!}
				]]></description>
			</item>
		@endforeach
	</channel>
</rss>
