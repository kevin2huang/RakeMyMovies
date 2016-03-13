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

		self.recent = ko.observableArray([]);
		for (var i = 0; i < 10; i++) {
			self.recent().push(new Movie());
		}

		self.watchLater = ko.observableArray([]);

		self.reviewList = new ReviewList(self);

		self.subscription = new Subscription(self);
	};

	return User;

});