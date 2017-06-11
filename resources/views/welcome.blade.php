<!doctype html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Eli's Credly App</title>

		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
		<!--
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="/css/app.css">
		-->

		<!-- Styles -->
		<style>
			html, body {
				background-color: #fff;
				color: #636b6f;
				font-family: 'Raleway', sans-serif;
				font-weight: 100;
				height: 100vh;
				margin: 0;
			}

			.full-height {
				height: 100vh;
			}

			.flex-center {
				align-items: center;
				display: flex;
				justify-content: center;
			}

			.position-ref {
				position: relative;
			}

			.top-right {
				position: absolute;
				right: 10px;
				top: 18px;
			}

			.content {
				text-align: center;
			}

			.title {
				font-size: 84px;
			}

			.links > a {
				color: #636b6f;
				padding: 0 25px;
				font-size: 12px;
				font-weight: 600;
				letter-spacing: .1rem;
				text-decoration: none;
				text-transform: uppercase;
			}

			.m-b-md {
				margin-bottom: 30px;
			}
		</style>
	</head>
	<body ng-controller="BadgesController as badgesController">
		<nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
			<div class="container">
				<p class="navbar-text">Credly Displayer</p>
				<form class="navbar-form navbar-right">
					<div class="form-group">
					  <input type="text" class="form-control" placeholder="Search">
					</div>
					<button type="submit" class="btn btn-default">Submit</button>
				</form>
			</div>
		</nav>



		<div class="flex-center position-ref full-height">
			@if (Route::has('login'))
				<div class="top-right links">
					@if (Auth::check())
						<a href="{{ url('/home') }}">Home</a>
					@else
						<a href="{{ url('/login') }}">Login</a>
						<a href="{{ url('/register') }}">Register</a>
					@endif
				</div>
			@endif

			<div class="content">
				<div class="title m-b-md">
					Laravel
				</div>
			</div>
		</div>

		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-animate.min.js"></script>
		<!-- <script type="text/javascript" src="/js/app.js"></script> -->
	</body>
</html>
