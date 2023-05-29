<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<title>404 Not Found | {{ config('app.name') }} Recipes</title>
		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
		<link rel="icon" href="/favicon.svg">
		<style>
			body {
				background: #c9eaff;
				color: #000;
				display: flex;
				flex-direction: column;
				font-family: sans-serif;
				height: 100vh;
				justify-content: center;
				margin: 0;
			}
			h1 {
				color: #325165;
				font-family: georgia, sans-serif;
				font-weight: normal;
				font-size: 36px;
				margin: 0;
				text-align: center;
			}
			p {
				line-height: 1.5;
				margin: 24px 0 0;
				text-align: center;
			}
			a {
				color: #264ce0;
			}
			a:hover,
			a:active,
			a:focus {
				text-decoration: none;
			}
			button,
			input {
				border-color: #000;
				border-style: solid;
				border-width: 1px;
				font-family: sans-serif;
				font-size: 18px;
				margin: 0;
				padding: 12px 10px 10px;
			}
			input {
				border-radius: 6px 0 0 6px;
				border-width: 0;
			}
			input:focus {
				position: relative;
				z-index: 1;
			}
			button {
				background: #325165;
				border-radius: 0 6px 6px 0;
				border-width: 0;
				color: #fff;
				cursor: pointer;
			}
			button:hover,
			button:active,
			button:focus {
				text-decoration: underline;
			}
			:focus {
				box-shadow: 0 0 0 4px plum;
				outline: none !important;
			}
		</style>
	</head>
	<body>
		<h1>Not Found</h1>
		<p>The requested URL was not found on this server.</p>
		<form action="/search" method="get" role="search">
			<p>
				<input aria-label="Search" name="q" type="text"><button type="submit">Search</button>
			</p>
		</form>
		<p><a href="/">{{ config('app.name') }} Recipes</a></p>
	</body>
</html>
