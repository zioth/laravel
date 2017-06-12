/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
//require('./bootstrap');

//window.Vue = require('vue');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
/*
Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
	el: '#app'
});
*/


(function() {
	'use strict';

	angular.module('CredlyDisplayer', ['ngAnimate'])
		.filter('imageFilter', _imageFilter)

		// Send an API request to the Credly proxy.
		.factory('ApiRequest',  ['$http', _apiRequestFactory])

		// Main controller
		.controller('UIController', ['$scope', 'ApiRequest', _uiController]
	);


	/**
	 * Main controller
	 *
	 * @param {Object} $scope - Angular scope
	 * @param {ApiRequest} API - Api request factory
	 */
	function _uiController($scope, API) {
		var vm = this;

		/**
		 * Initialize data, and fetch JSON to render UI.
		 * This function is kept inline to make it clear which members are available in the uiController object
		 */
		function _init() {
			vm.isLoggedIn = true; // innocent until proven guilty.
			vm.loginFailed = false; // The last login attempt failed.
			vm.username = '';
			vm.password = '';
			vm.isLoading = false;
			vm.badges = [];
			vm.contacts = [];
			vm.memberBadges = {};
			vm.getBadges();
			vm.getContacts();
		}

		// This was copied from Alex's interview demo, but I did not have time to reimplement the infinite scroll code.
		var page = 1;
		$scope.$on('loadMoreBadges', function() {
			vm.getBadges();
		});

		vm.getBadges = _getBadges.bind(vm, $scope, API);
		vm.getContacts = _getContacts.bind(vm, API);
		vm.showBadges = _showBadges.bind(vm, API);
		$scope.login = _login.bind(vm, API);

		_init();
	}


	/**
	 * Factory to generate Credly API request code.
	 *
	 * @param {Object} $http - Angular HTTP object
	 */
	function _apiRequestFactory($http) {
		return {
			/**
			 * Send an API request to the Credly proxy.
			 *
			 * @param {String} action - The API action. For example, /contacts
			 * @param {String} method - 'GET' or 'POST'
			 * @param {Object=|null} - URL parameters as name:value pairs
			 */
			get: function(action, method, data) {
				var params = {
					method: method,
					url: action,
					params: data || {}
				};
				if (method == 'POST') {
					params.headers = {'Content-Type': 'application/x-www-form-urlencoded'}
				}
				return $http(params);
			}
		}
	}


	/**
	 * Get the badges created by the logged-in user
	 *
	 * @param {Object) $scope - Angular scope
	 * @param {ApiRequest) API - The Credly API request object.
	 *
	 * Scope: uiController
	 */
	function _getBadges($scope, API) {
		var vm = this;

		if ($scope.noMore) {
			return;
		}

		//TODO: Need seperate loading states for each action. Shared just results in a flickering UI
		vm.isLoading = true;

		API.get('/me/badges/created', 'GET', {
			order_direction: 'ASC',
			page: page,
			per_page: 20
		}).then(
			function(res) {
				vm.isLoading = false;
				vm.isLoggedIn = !res.data || !res.data.meta || res.data.meta.status_code != 401;
				if (res.data.data) {
					vm.badges = vm.badges.concat(res.data.data);
				}
				if (res.data && res.data.paging) {
					$scope.noMore = vm.badges.length >= res.data.paging.total_results;
				}
			},
			function(err) {
				vm.isLoading = false;
			}
		);
	}


	/**
	 * Get the logged-in user's contacts
	 *
	 * @param {ApiRequest) API - The Credly API request object.
	 *
	 * Scope: uiController
	 */
	function _getContacts(API) {
		var vm = this;
		vm.isLoading = true;

		API.get('/me/contacts', 'GET', {
			order_direction: 'ASC',
			page: page,
			per_page: 20
		}).then(
			function(res) {
				vm.isLoading = false;
				vm.isLoggedIn = !res.data || !res.data.meta || res.data.meta.status_code != 401;
				if (res.data.data) {
					vm.contacts = vm.contacts.concat(res.data.data);
				}
				if (res.data && res.data.paging) {
					$scope.noMore = vm.contacts.length >= res.data.paging.total_results;
				}
			},
			function(err) {
				vm.isLoading = false;
			}
		);
	}


	/**
	 * Get a sample set of badges for a member. No need to get all of them.
	 *
	 * @param {ApiRequest) API - The Credly API request object.
	 *
	 * Scope: uiController
	 */
	function _showBadges(API, memberid) {
		var vm = this;
		//TODO: Add a loading state

		API.get('/members/' + memberid + '/badges', 'GET', {
			order_direction: 'ASC',
			page: 1,
			per_page: 10
		}).then(
			function(res) {
				vm.isLoggedIn = !res.data || !res.data.meta || res.data.meta.status_code != 401;
				if (res.data.data && res.data.data.length) {
					var obj = vm.memberBadges[res.data.data[0].member_id] = [];
					for (var x=0; x<res.data.data.length; x++) {
						var badge = res.data.data[x].badge;
						obj.push({
							src: badge.image_url,
							title: badge.title,
							short_description: badge.short_description
						});
					}
				}
			},
			function(err) {
				vm.isLoading = false;
			}
		);
	}


	/**
	 * Authenticate the user
	 *
	 * @param {ApiRequest) API - The Credly API request object.
	 *
	 * Scope: uiController
	 */
	function _login(API) {
		var vm = this;
		//TODO BUG: Why do username&password get appended to the URL? Angular docs say that $http() doesn't work like that.
		API.get('/authenticate', 'POST', {username:vm.username, password:vm.password}).then(function(res) {
			if (res.data && res.data.isLoggedIn) {
				// Reset the app, including the logged in state.
				_init();
			}
			else {
				vm.isLoggedIn = false;
				vm.loginFailed = true;
			}
		}, function(err) {
			vm.isLoggedIn = false;
			vm.loginFailed = true;
		});
	}


	/**
	 * Image filter (taken from Alex's interview demo)
	 */
	function _imageFilter() {
		return function(input, size) {
			var ret = input.replace(/(_\d+)\./, '.');
			var endIndex = ret.lastIndexOf('.');
			return ret.substring(0, endIndex) + '_' + size + ret.substring(endIndex);
		};
	}
})();
