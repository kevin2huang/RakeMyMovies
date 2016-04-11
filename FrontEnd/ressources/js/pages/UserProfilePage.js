define([
	'../userprofile/Profile',
	'../userprofile/Recent',
	'../userprofile/ReviewList',
	'../userprofile/SubscriptionList',
	'../userprofile/WatchLater',
	'../userprofile/Administrator',
	'text!ressources/js/pages/UserProfilePageTemplate.html',
	'../userprofile/Review',
	'knockout',
	'komapping',
	'jquery'
], function(Profile, Recent, ReviewList, SubscriptionList, WatchLater, Administrator, template, Review, ko, komapping, $) {
	'use strict';

	$('#page-top').append(template);

	var UserProfilePage = function (user) {
		var self = this;

		self.text = "UserProfilePage";

		self.user = user;

		self.profiletabs = ko.observableArray([]);
		self.profiletabs().push(new WatchLater(self.user));
		self.profiletabs().push(new Recent(self.user));
		self.profiletabs().push(new ReviewList(self.user));
		self.profiletabs().push(new Profile(self.user));
		self.profiletabs().push(new SubscriptionList(self.user));
		self.profiletabs().push(new Administrator(self.user));

		self.profiletabsActive = ko.observable(self.profiletabs()[0]);

		self.modalMovie = ko.observable();
		self.modalReview = ko.observable();
		self.getReview = function() {
			self.modalReview(new Review())
			$.ajax({
				url: "http://localhost/DatabaseProject/BackEnd/ajax/reviews.php",
				method: "GET",
				data: {
					userId: self.user.userId(),
					movieId: self.modalMovie().movieId()
				}
			}).done(function (rep) {
				rep = JSON.parse(rep);
				if (!!rep.review) {rep = rep.review;}
				if (rep === 'EMPTY') {
					self.modalReview(new Review());
				} else {
					rep['update'] = true;
					self.modalReview(new Review(rep))
				}
			});
		};

		self.sendReview = function() {
			$.ajax({
				url: "http://localhost/DatabaseProject/BackEnd/ajax/reviews.php",
				method: "POST",
				data: {
					userId: self.user.userId(),
					movieId: self.modalMovie().movieId(),
					rating: self.modalReview().rating(),
					text: self.modalReview().description(),
					update: self.modalReview().update
				}
			}).done(function (rep) {
				self.modalReview(null);
			});
		};

		self.setModalMovie = function (movie) {
			self.modalMovie(movie);
		};

		self.setActiveTab = function (tab) {
			self.profiletabsActive(tab);
		};

		self.onReviewClick = function (movie) {
			self.modalMovie(movie);
			self.getReview();
		};
	};

	return UserProfilePage;

});