@extends('layout')

@php ($ogImage = url('/uploads/cinnamon-rolls.jpg'))

@section('content')
	@if ($draftRecipes->isNotEmpty())
		<h1>Drafts</h1>
		@include('shared.list', ['recipes' => $draftRecipes])
		<hr>
	@endif
	<h1>
		Latest Recipes
		<a href="/feed.xml" id="rss">RSS feed</a>
	</h1>
	@if ($latestRecipes->isNotEmpty())
		@include('shared.list', ['recipes' => $latestRecipes])
	@else
		<p>No recipes found.</p>
	@endif
@stop
