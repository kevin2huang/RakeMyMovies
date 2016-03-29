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

		if (!!options) {
			self.username = options.username;
			self.password = options.password;
			self.email = options.email;
			self.country = options.country;
			self.province = options.province;
			self.city = options.city;
			self.occupation = options.occupation;
			self.gender = options.gender;
			self.quote = options.quote;
			self.userId = options.userId;
			//Show me this
		}
		self.recent = ko.observableArray([]);
		self.watchLater = ko.observableArray([]);

		var date = new Date().toDateString();

		$.ajax({
			url: "http://localhost/DatabaseProject/BackEnd/ajax/getMovies.php",
			method: "POST",
			data: {
				movieIDs: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
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
			self.recent(rep);
		});

		$.ajax({
			url: "http://localhost/DatabaseProject/BackEnd/ajax/getMovies.php",
			method: "POST",
			data: {
				movieIDs: [1, 2, 3, 4, 5, 6, 7, 8]
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
			self.watchLater(rep);
		});

		self.reviewList = new ReviewList(self);

		self.subscription = new Subscription(self);

		self.removeWatchLater = function (m) {
			self.watchLater.remove(m);
		};
	};

	return User;

});