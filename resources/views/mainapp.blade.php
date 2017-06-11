<!doctype html>
<html lang="{{ app()->getLocale() }}" ng-app="CredlyDisplayer">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Eli's Credly App</title>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="/css/app.css">

		<!-- TODO: CSS file -->
		<style>
			.columns {
				display: -ms-flex;
				display: -webkit-flex;
				display: flex;
			}
			.ui_column {
				width: 50%;
				box-sizing: border-box;
				padding: 10px;
			}
			.ui_column.badges_column {
				float: left;
				border-right: 1px solid #ccc;
			}
			.ui_column.contacts_column {
				float: right;
			}
			.avatar {
				display: block;
				height: 170px;
				width: 170px;
				border: 2px solid black;
				border-radius: 4px;
			}
			.avatar.non_member {
				/* TODO: Default avatar */
				background-color: #AAA;
			}
			.main-wrapper:not(.loggedIn),
			.login-form.loggedIn {
				display: none;
			}
		</style>
	</head>
	<body ng-controller="BadgesController as badgesController">
		{{-- verbatim to allow Angular interpolation --}}
		@verbatim
			<div class="login-form" ng-class="{'loggedIn': badgesController.isLoggedIn}">
				<!-- TODO: If made one attempt and failed, err -->
				<!-- <input type="text" name="username" placeholder="Email address"/>
				<input type="password" name="password" placeholder="*****"/>
				<div class="button" onclick="badgesController.signIn()">Sign In</div> -->
				<form name="form" ng-submit="badgesController.login(); return false" role="form">
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" name="username" id="username" class="form-control" ng-model="badgesController.username" required />
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" name="password" id="password" class="form-control" ng-model="badgesController.password" required />
					</div>
					<div class="form-actions">
						<button type="submit" class="btn btn-primary">Login</button>
						<!-- TODO
							<img ng-if="vm.dataLoading" src="data:image/gif;base64,R0lGODlhEAAQAPIAAP///wAAAMLCwkJCQgAAAGJiYoKCgpKSkiH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCgAAACwAAAAAEAAQAAADMwi63P4wyklrE2MIOggZnAdOmGYJRbExwroUmcG2LmDEwnHQLVsYOd2mBzkYDAdKa+dIAAAh+QQJCgAAACwAAAAAEAAQAAADNAi63P5OjCEgG4QMu7DmikRxQlFUYDEZIGBMRVsaqHwctXXf7WEYB4Ag1xjihkMZsiUkKhIAIfkECQoAAAAsAAAAABAAEAAAAzYIujIjK8pByJDMlFYvBoVjHA70GU7xSUJhmKtwHPAKzLO9HMaoKwJZ7Rf8AYPDDzKpZBqfvwQAIfkECQoAAAAsAAAAABAAEAAAAzMIumIlK8oyhpHsnFZfhYumCYUhDAQxRIdhHBGqRoKw0R8DYlJd8z0fMDgsGo/IpHI5TAAAIfkECQoAAAAsAAAAABAAEAAAAzIIunInK0rnZBTwGPNMgQwmdsNgXGJUlIWEuR5oWUIpz8pAEAMe6TwfwyYsGo/IpFKSAAAh+QQJCgAAACwAAAAAEAAQAAADMwi6IMKQORfjdOe82p4wGccc4CEuQradylesojEMBgsUc2G7sDX3lQGBMLAJibufbSlKAAAh+QQJCgAAACwAAAAAEAAQAAADMgi63P7wCRHZnFVdmgHu2nFwlWCI3WGc3TSWhUFGxTAUkGCbtgENBMJAEJsxgMLWzpEAACH5BAkKAAAALAAAAAAQABAAAAMyCLrc/jDKSatlQtScKdceCAjDII7HcQ4EMTCpyrCuUBjCYRgHVtqlAiB1YhiCnlsRkAAAOwAAAAAAAAAAAA==" />
						-->
					</div>
				</form>
			</div>
			<div class="main-wrapper container" ng-class="{'loggedIn': badgesController.isLoggedIn}">
				<div class="columns">
					<div
						class="badges_column ui_column"
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
					<div
						class="contacts_column ui_column"
						event-name="loadMoreContacts"
						ng-class="{'loading': badgesController.isLoading}"
						>
						<div
							class="member-image"
							ng-repeat="contact in badgesController.contacts"
							data-memberid="{{ contact.contact_member_id }}"
							data-id="{{ contact.id }}"
						>
							<div ng-switch on="contact.is_member" >
								<div ng-switch-when="true">
									<img class="avatar" src="{{ contact.member.avatar }}"/>
									<div>{{ contact.member.display_name }}</div>
								</div>
								<div ng-switch-default>
									<div class="avatar non_member"></div>
									<div>{{ contact.first_name }} {{ contact.last_name }}</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endverbatim

		<!-- TODO Authentication -->
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

		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-animate.min.js"></script>
		<script type="text/javascript" src="/js/app.js"></script>
	</body>
</html>
