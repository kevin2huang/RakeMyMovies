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
		self.user = ko.observable(new User({
			username: 'Abigael',
			password: '1234',
			email: 'abigael.tremblay@gmail.com'
		}));

		self.page = ko.observable(new HomePage(self.user()));

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
			self.page(new UserProfilePage(self.user()));
		};

		self.setHomePage = function () {
			self.page(new HomePage(self.user()));
		};

		self.watchLater = function (movie) {
			if (self.user() !== null) {
				$.ajax({
					url: "http://localhost/DatabaseProject/BackEnd/ajax/addToWishList.php",
					method: "POST",
					data: {
						userId: self.user().userId,
						movieId: movie.movieId
					}
				}).done(function (rep) {
					if (rep.status === 'OK') {
						self.user().watchLater().push({
							movie: movie,
							timestamp: 'Mon Mar 28 2016'
						});
					}
				});
			}
		};

		self.saveProfile = function () {
			$.ajax({
				url: "http://localhost/DatabaseProject/BackEnd/ajax/saveProfile.php",
				method: "POST",
				data: self.user()
			});
		};

		self.hasUser = ko.computed(function () {
			return self.user() !== null;
		}, self);
	};

	return WelcomeSreen;

});