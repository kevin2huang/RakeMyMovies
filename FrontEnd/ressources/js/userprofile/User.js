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

		self.username = ko.observable('no username');
		self.password = ko.observable('no password');
		self.email = ko.observable('no email');
		self.country = ko.observable('no country');
		self.province = ko.observable('no province');
		self.city = ko.observable('no city');
		self.occupation = ko.observable('no occupation');
		self.gender = ko.observable('no gender');
		self.quote = ko.observable('');
		self.userId = ko.observable(-1);
		self.isadmin = ko.observable(false);

		if (!!options) {
			if (!!options.username) { self.username(options.username)};
			if (!!options.password) { self.password(options.password)};
			if (!!options.email) { self.email(options.email)};
			if (!!options.country) { self.country(options.country)};
			if (!!options.province) { self.province(options.province)};
			if (!!options.city) { self.city(options.city)};
			if (!!options.occupation) { self.occupation(options.occupation)};
			if (!!options.gender) { self.gender(options.gender)};
			if (!!options.quote) { self.quote(options.quote)};
			if (!!options.userId) { self.userId(options.userId)};
			if (!!options.isadmin) { self.isadmin(options.isadmin)};
		}
		self.recent = ko.observableArray([]);
		self.watchLater = ko.observableArray([]);
		self.reviewList = new ReviewList(self);
		self.subscription = new Subscription(self);

		var date = new Date().toDateString();

		$.ajax({
			url: "http://localhost/DatabaseProject/BackEnd/ajax/getMovies.php",
			method: "POST",
			data: {
				//movieIDs: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
				userId: self.userId,
				listType: 'watched'
			}
		}).done(function (rep) {
			var arr = [];
			for (var i = 0; i < rep.length; i++) {
				var mov = new Movie(rep[i].movie);
				arr.push({
					movie: mov,
					timestamp: rep[i].timestamp
				});
			}
			self.recent(arr);
		});

		$.ajax({
			url: "http://localhost/DatabaseProject/BackEnd/ajax/getMovies.php",
			method: "POST",
			data: {
				//movieIDs: [1, 2, 3, 4, 5, 6, 7, 8]
				userId: self.userId,
				listType: 'wish'
			}
		}).done(function (rep) {
			var arr = [];
			for (var i = 0; i < rep.length; i++) {
				var mov = new Movie(rep[i].movie);
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