define([
	'text!ressources/js/userprofile/RecentTemplate.html',
	'knockout',
	'komapping'
], function(template, ko, komapping) {
	'use strict';

	$('#page-top').append(template);

	var Review = function (options) {
		var self = this;

		self.text = "Review";

		self.name = ko.observable('Anonymous');
		self.description = ko.observable('This is a review. The description can be more or less long depending on the review. Most of the time, a review will be about one or two paragraphs long.');
		self.rating = ko.observable(5);
		self.id = ko.observable(-1);
		self.update = false;
		if (!!options) {
			if (options.name) {self.name(options.name);}
			if (options.reviewdescription) {self.description(options.reviewdescription);}
			if (options.reviewrating) {
				self.rating(options.reviewrating);
				if (typeof self.rating() === 'string') {
					self.rating(parseInt(self.rating()));
				}
			}
			if (options.reviewid) {self.id(options.reviewid);}
			if (options.update) {self.update = options.update;}
		}

		self.changeRating = function (a) {
			var rating = self.rating();
			rating += a;
			if (rating > 5) {rating = 5; }
			if (rating < 0) {rating = 0; }
			self.rating(rating);
		};
	};

	return Review;

});