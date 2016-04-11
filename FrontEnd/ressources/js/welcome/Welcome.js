define([
	'../pages/UserProfilePage',
	'../pages/HomePage',
	'../pages/SearchPage',
	'../userprofile/User',
	'knockout',
	'komapping'
], function(UserProfilePage, HomePage, SearchPage, User, ko, komapping) {
	'use strict';

	var SearchDropDowns = function () {
		self = this;

		self.movie = ko.observable();
		self.director = ko.observable();
		self.genre = ko.observable();

		self.movieList = ko.observableArray([{name:'--movies--'}]);
		self.directorList = ko.observableArray([{name:'--directors--'}]);
		self.genreList = ko.observableArray([{name:'--genres--'}]);

		$.ajax({
			url: "http://localhost/DatabaseProject/BackEnd/ajax/getAllNamesAndIds.php",
			method: "POST",
			data: {}
		}).done(function (rep) {
			if (typeof rep === 'string') {
				rep = JSON.parse(rep);
			}
			if (!!rep && !!rep.movies && $.isArray(rep.movies)) {
				$.each(rep.movies, function (index, value) {
					self.movieList.push(value);	
				});
			}
			if (!!rep && !!rep.directors && $.isArray(rep.directors)) {
				$.each(rep.directors, function (index, value) {
					self.directorList.push(value);	
				});
			}
			if (!!rep && !!rep.genres && $.isArray(rep.genres)) {
				$.each(rep.genres, function (index, value) {
					self.genreList.push(value);	
				});
			}
		});
	};

	var WelcomeSreen = function () {
		var self = this;

		/*================================
					Variables
		================================*/

		self.username = ko.observable('');
		self.password = ko.observable('');
		self.signupUser = ko.observable(new User());
		self.user = ko.observable(null);

		self.page = ko.observable(new HomePage(self.user()));
		self.searchBar = new SearchDropDowns();

		self.day = ko.observable();
		self.month = ko.observable();
		self.year = ko.observable();

		self.dayList = ko.observableArray([1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
			11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31]);
		self.monthList = ko.observableArray(['January', 'February', 'Mars', 'April', 'May', 
			'June', 'July', 'August', 'September', 'October', 'November', 'December']);
		self.yearList = ko.observableArray([]);
		for (var i = 0; i < 100; i++) {
			self.yearList.push(2016 - i);
		}

		/*================================
					Functions
		================================*/
		self.login = function () {

			$.ajax({
				url: "http://localhost/DatabaseProject/BackEnd/ajax/login.php",
				method: "POST",
				data: {
					email: self.username(),
					password: self.password()
				}
			}).done(function (rep) {
				rep = JSON.parse(rep);
				var user = new User(rep);
				self.user(user);
				if (self.page().text === 'HomePage') {
					self.page().getChannels(user);
				} else if (self.page().text === 'SearchPage') {
					self.page(new SearchPage(self.searchBar, self.user()));
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
			var date = new Date().toDateString();
			if (self.user() !== null) {
				$.ajax({
					url: "http://localhost/DatabaseProject/BackEnd/ajax/addToWishList.php",
					method: "POST",
					data: {
						userId: self.user().userId(),
						movieId: movie.movieId(),
						listType: 'wish'
					}
				}).done(function (rep) {
					if (rep === 'OK') {
						self.user().watchLater().push({
							movie: movie,
							timestamp: date
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
			var user = {
				username : self.signupUser().username(),
				password : self.signupUser().password(),
				email : self.signupUser().email(),
				country : self.signupUser().country(),
				province : self.signupUser().province(),
				city : self.signupUser().city(),
				occupation : self.signupUser().occupation(),
				gender : self.signupUser().gender(),
				quote : self.signupUser().quote(),
				userId : self.signupUser().userId(),
				isadmin : self.signupUser().isadmin(),
				dob : self.day() + ' ' + self.month() + ' ' + self.year()

			};
			if  (!(self.isEmpty(user.username) || self.isEmpty(user.email) || 
				self.isEmpty(user.password))) {

				$.ajax({
					url: "http://localhost/DatabaseProject/BackEnd/ajax/signup.php",
					method: "POST",
					data: user
				}).done(function (rep) {
					if (rep === 'OK') {
						self.user(user);
					}
				});
			} else {
				console.log('Fill in the required fields')
			}
		};

		self.search = function () {
			if (self.page().text !== 'SearchPage') {
				self.page(new SearchPage(self.searchBar, self.user()));
			} else {
				self.page().refresh();
			}
		};

		self.hasUser = ko.computed(function () {
			return self.user() !== null;
		}, self);
	};

	return WelcomeSreen;

});