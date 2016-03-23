define([
	'../movie/Movie',
	'ressources/js/userprofile/ReviewList',
	'ressources/js/userprofile/SubscriptionList',
	'knockout',
	'komapping'
], function(Movie, ReviewList, Subscription, ko, komapping) {
	'use strict';

	var User = function () {
		var self = this;

		self.username = "Abigael";
		self.password = "1234";
		self.email = 'abigael.tremblay@gmail.com';
		self.country = 'Canada';
		self.province = 'Ontario';
		self.city = 'Ottawa';
		self.occupation = 'Student';
		self.gender = '--';
		self.quote = 'Today is such a nice day!';

		var date = new Date().toDateString();

		self.recent = ko.observableArray([]);
		for (var i = 0; i < 10; i++) {
			self.recent().push({
				movie: new Movie(),
				timestamp: date
			});
		}

		self.watchLater = ko.observableArray([]);
		for (var i = 0; i < 8; i++) {
			self.watchLater().push({
				movie: new Movie(),
				timestamp: date
			});
		}

		self.reviewList = new ReviewList(self);

		self.subscription = new Subscription(self);

		self.removeWatchLater = function (m) {
			self.watchLater.remove(m);
		};
	};

	return User;

});