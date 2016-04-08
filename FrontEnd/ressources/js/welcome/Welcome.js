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
		self.signupUser = ko.observable(new User());
		self.user = ko.observable(null);
		/*self.user = ko.observable(new User({
			username: 'Abigael',
			password: '1234',
			email: 'abigael.tremblay@gmail.com'
		}));*/

		self.page = ko.observable(new HomePage(self.user()));

		/*================================
					Functions
		================================*/
		self.login = function () {

			$.ajax({
				url: "http://localhost/DatabaseProject/BackEnd/ajax/login.php",
				method: "POST",
				data: {
					email: self.email(),
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

		self.isEmpty = function(str) {
			return !(!!str && str != '');
		};

		self.computeEmpty = function (user, str) {
			return ko.computed (function() {
				a = user[str]();
				return self.isEmpty(a);
		}, self)};

		self.signup = function () {
			var user = ko.toJS(self.signupUser());
			if  (!(self.isEmpty(user.username) || self.isEmpty(user.email) || self.isEmpty(user.password))) {
				console.log('Yy');

				$.ajax({
					url: "http://localhost/DatabaseProject/BackEnd/ajax/signup.php",
					method: "POST",
					data: user
				}).done(function (rep) {
					if (rep.status === 'OK') {
						self.user(user);
					}
				});
			} else {
				console.log('Fill in the required fields')
			}
		};

		self.hasUser = ko.computed(function () {
			return self.user() !== null;
		}, self);
	};

	return WelcomeSreen;

});