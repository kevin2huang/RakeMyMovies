define([
	'text!ressources/js/pages/HomePageTemplate.html',
	'../movie/Movie',
	'../userprofile/Review',
	'knockout',
	'komapping'
], function(template, Movie, Review, ko, komapping) {
	'use strict';

	$('#page-top').append(template);

	var Channel = function (options) {
		self = this;

		self.name = ko.observable("Some Channel");

		self.movies = ko.observableArray([]);

		if (!!options && !!options.movies && $.isArray(options.movies)) {
			for (var i = 0; i < 6 && i < options.movies.length; i++ ){
				self.movies.push(new Movie(options.movies[i]));
			}

			if (!!options.name) {self.name(options.name);}
		}
	};

	var HomePage = function (user) {
		var self = this;

		self.text = "HomePage";

		self.user = user;

		self.channels = ko.observableArray([]);

		self.modalMovie = ko.observable(null);
		self.modalReview = ko.observable(null);

		/*================================
					Functions
		================================*/

		self.setModalMovie = function (movie) {
			self.modalMovie(movie);
		};

		self.getChannels = function (user) {
			if (!!user) {
				self.user = user;
			}

			var userId;
			if (!!self.user && self.user.userId()) {
				userId = self.user.userId();
			}
			$.ajax({
				url: "http://localhost/DatabaseProject/BackEnd/ajax/getChannels.php",
				method: "POST",
				data: {
					userId: userId
				}
			}).done(function (rep) {
				rep = JSON.parse(rep);
				if (!!rep && !!rep.channels && $.isArray(rep.channels)) {
					self.channels([]);
					for(var i = 0; i < rep.channels.length; i++) {
						self.channels.push(new Channel(rep.channels[i]))
					}
				}
			});
		};


		self.getReview = function () {
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

		self.sendReview = function () {
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

		self.getChannels();
	};

	return HomePage;

});