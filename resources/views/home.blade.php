@extends('layout')

@php ($ogImage = url('/uploads/cinnamon-rolls.jpg'))

@section('content')
	@if ($draftRecipes->isNotEmpty())
		<h2>Drafts</h2>
		@include('shared.list', ['recipes' => $draftRecipes])
		<hr>
	@endif
	<h2>
		Latest Recipes
		<a href="/feed.xml" id="rss">RSS feed</a>
	</h2>
	@if ($latestRecipes->isNotEmpty())
		@include('shared.list', ['recipes' => $latestRecipes])
	@else
		<p>No recipes found.</p>
	@endif
@stop
