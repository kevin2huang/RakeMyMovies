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
		self.user = ko.observable(null);

		self.page = ko.observable(new HomePage());

		/*================================
					Functions
		================================*/
		self.login = function () {

			$.ajax({
				url: "http://localhost/DatabaseProject/BackEnd/ajax/login.php",
				method: "POST",
				data: {
					username: self.username(),
					password: self.password()
				}
			}).done(function (rep) {
				var user = new User(rep);
				self.user(user);
				if (self.page.text === 'HomePage') {
					self.page.getChannels(user);
				}
			});
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