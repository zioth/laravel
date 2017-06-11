<!DOCTYPE html>
<html lang="en" ng-app="CredlyDisplayer">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Credly Displayer</title>
		<link href='//fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="/css/app.css">
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
		<div class="main-wrapper container">
			<div
				class="row badges-main-wrapper"
				infinite-scroll
				event-name="loadMoreBadges"
				ng-class="{'loading': badgesController.isLoading}"
				>
				<a
					class="badge-image"
					href="https://credly.com/recipients/{{ badge.id }}"
					target="_blank"
					ng-repeat="badge in badgesController.badges">
					<div class="clearfix" ng-if="$index % 3 == 0"></div>
					<div class="col-xs-4">
						<div>{{ badge.title }}</div>
						<img ng-src="{{ badge.image_url | imageFilter: 13 }}" />
					</div>
				</a>
				<div class="loader loader--style2" title="1" ng-show="badgesController.isLoading">
				  <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					 width="40px" height="40px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
				  <path fill="#000" d="M25.251,6.461c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615V6.461z">
					<animateTransform attributeType="xml"
					  attributeName="transform"
					  type="rotate"
					  from="0 25 25"
					  to="360 25 25"
					  dur="0.6s"
					  repeatCount="indefinite"/>
					</path>
				  </svg>
				</div>
			</div>
		</div>
	</body>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-animate.min.js"></script>
	<script type="text/javascript" src="/js/app.js"></script>
</html>
