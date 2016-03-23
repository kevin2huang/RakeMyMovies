define([
	'text!ressources/js/userprofile/ReviewListTemplate.html',
	'knockout',
	'komapping'
], function(template, ko, komapping) {
	'use strict';

	$('#page-top').append(template);

	var Review = function (user) {
		var self = this;

		self.name = 'Anonymous';
		self.description = 'This is a review. The description can be more or less long depending on the review.\
		Most of the time, a review will be about one or two paragraphs long.';
		self.rating = 5;
	};

	var ReviewList = function (user) {
		var self = this;

		self.text = "Reviews";

		self.user = user;

		self.reviews = ko.observableArray([]);

		for(var i = 0; i < 5; i++) {
			self.reviews().push(new Review());
		}

		self.deleteReview = function(review) {
			self.reviews.remove(review);
		};

	};

	return ReviewList;

});