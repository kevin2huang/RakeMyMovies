define([
	'text!ressources/js/userprofile/ReviewListTemplate.html',
	'./Review',
	'knockout',
	'komapping'
], function(template, Review, ko, komapping) {
	'use strict';

	$('#page-top').append(template);

	var ReviewList = function (user) {
		var self = this;

		self.text = "Reviews";

		self.user = user;

		self.reviews = ko.observableArray([]);

		$.ajax({
			url: "http://localhost/DatabaseProject/BackEnd/ajax/reviews.php",
			method: "GET",
			data: {
				userId: self.user.userId(),
			}
		}).done(function (rep) {
			rep = JSON.parse(rep);
			if (!!rep.reviews) {rep = rep.reviews;}
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