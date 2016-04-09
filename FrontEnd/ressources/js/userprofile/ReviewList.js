define([
	'text!ressources/js/userprofile/ReviewListTemplate.html',
	'knockout',
	'komapping'
], function(template, ko, komapping) {
	'use strict';

	$('#page-top').append(template);

	var Review = function (options) {
		var self = this;

		if (!!options) {
			self.name = options.name;
			self.description = options.description;
			self.rating = options.rating;
		} else {
			self.name = 'Anonymous';
			self.description = 'This is a review. The description can be more or less long depending on the review.\
			Most of the time, a review will be about one or two paragraphs long.';
			self.rating = 5;
		}
	};

	var ReviewList = function (user) {
		var self = this;

		self.text = "Reviews";

		self.user = user;

		self.reviews = ko.observableArray([]);

		$.ajax({
			url: "http://localhost:8888/DatabaseProject/BackEnd/ajax/getReviews.php",
			method: "POST",
			data: {
				userId: self.user.userId,
			}
		}).done(function (rep) {
			if ($.isArray(rep)) {
				$.each(rep, function (index, value) {
					self.reviews.push(new Review(value))
				})
			}
		});

		self.deleteReview = function(review) {
			self.reviews.remove(review);
		};

	};

	return ReviewList;

});