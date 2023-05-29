<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<title>500 Server Error | {{ config('app.name') }} Recipes</title>
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
		</style>
	</head>
	<body>
		<h1>Server Error</h1>
		<p>Something went wrong. Please try again later.</p>
		<p><a href="/">{{ config('app.name') }} Recipes</a></p>
	</body>
</html>
