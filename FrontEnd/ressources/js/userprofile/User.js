define([
	'../movie/Movie',
	'ressources/js/userprofile/ReviewList',
	'ressources/js/userprofile/SubscriptionList',
	'knockout',
	'komapping'
], function(Movie, ReviewList, Subscription, ko, komapping) {
	'use strict';

	var User = function (options) {
		var self = this;

		self.username = ko.observable();
		self.password = ko.observable();
		self.email = ko.observable();
		self.country = ko.observable();
		self.province = ko.observable();
		self.city = ko.observable();
		self.occupation = ko.observable();
		self.gender = ko.observable();
		self.quote = ko.observable();
		self.userId = ko.observable();
		self.isadmin = ko.observable(false);
		self.dob = ko.observable();

		if (!!options && !!options.user && !!options.profile) {
			if (!!options.user.username) { self.username(options.user.username)};
			if (!!options.user.password) { self.password(options.user.password)};
			if (!!options.user.email) { self.email(options.user.email)};
			if (!!options.profile.country) { self.country(options.profile.country)};
			if (!!options.profile.province) { self.province(options.profile.province)};
			if (!!options.profile.city) { self.city(options.profile.city)};
			if (!!options.profileoccupation) { self.occupation(options.profile.occupation)};
			if (!!options.user.gender) { self.gender(options.user.gender)};
			if (!!options.profile.quote) { self.quote(options.profile.quote)};
			if (!!options.user.userid) { self.userId(options.user.userid)};
			if (!!options.user.isadmin) { self.isadmin(options.user.isadmin)};
			if (!!options.user.dob) { self.dob(options.user.dob)};
		}
		self.recent = ko.observableArray([]);
		self.watchLater = ko.observableArray([]);
		self.reviewList = new ReviewList(self);
		self.subscription = new Subscription(self);

		var date = new Date().toDateString();

		$.ajax({
			url: "http://localhost:8888/DatabaseProject/BackEnd/ajax/getMovies.php",
			method: "POST",
			data: {
				//movieIDs: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
				userId: self.userId(),
				listType: 'watched'
			}
		}).done(function (rep) {
			rep = JSON.parse(rep);
			if (!!rep.movies) {rep = rep.movies;}
			var arr = [];
			for (var i = 0; i < rep.length; i++) {
				var mov = new Movie(rep[i]);
				arr.push({
					movie: mov,
					timestamp: rep[i].timestamp
				});
			}
			self.recent(arr);
		});

		$.ajax({
			url: "http://localhost:8888/DatabaseProject/BackEnd/ajax/getMovies.php",
			method: "POST",
			data: {
				//movieIDs: [1, 2, 3, 4, 5, 6, 7, 8]
				userId: self.userId(),
				listType: 'wish'
			}
		}).done(function (rep) {
			rep = JSON.parse(rep);
			if (!!rep.movies) {rep = rep.movies;}
			var arr = [];
			for (var i = 0; i < rep.length; i++) {
				var mov = new Movie(rep[i]);
				arr.push({
					movie: mov,
					timestamp: rep[i].timestamp
				});
			}
			self.watchLater(arr);
		});

		self.removeWatchLater = function (m) {
			self.watchLater.remove(m);
		};
	};

	return User;

});