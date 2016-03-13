define([
	'../pages/UserProfilePage',
	'../pages/HomePage',
	'../userprofile/User',
	'knockout',
	'komapping'
], function(UserProfilePage, HomePage, User, ko, komapping) {
	'use strict';

	var WelcomeSreen = function () {
		var self = this;

		/*================================
					Variables
		================================*/

		self.username = ko.observable('');
		self.password = ko.observable('');
		self.user = ko.observable(new User());

		self.page = ko.observable(new HomePage());

		/*================================
					Functions
		================================*/
		self.signup = function () {
			//TODO Link with database. This is a placeholder
			var user = new User();
			if (self.username() === user.username && self.password() === user.password) {
				self.user(user);
			}
			//End of placeholder
		};

		self.logout = function() {
			self.setHomePage();
			self.user(null);
		};

		self.setProfilePage = function () {
			self.page(new UserProfilePage(self.user));
		};

		self.setHomePage = function () {
			self.page(new HomePage());
		};

		self.watchLater = function (movie) {
			if (self.user() !== null) {
				self.user().watchLater().push(movie);
			}
		};

		self.hasUser = ko.computed(function () {
			return self.user() !== null;
		}, self);
	};

	return WelcomeSreen;

});