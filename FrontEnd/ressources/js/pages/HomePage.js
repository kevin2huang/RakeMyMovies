define([
	'text!ressources/js/pages/HomePageTemplate.html',
	'../movie/Movie',
	'knockout',
	'komapping'
], function(template, Movie, ko, komapping) {
	'use strict';

	$('#page-top').append(template);

	var Channel = function (options) {
		self = this;

		self.name = "Some Channel";

		self.movies = ko.observableArray([]);

		if (!!options && !!options.movies && $.isArray(options.movies)) {
			for (var i = 0; i < 6 || i < options.movies.length; i++ ){
				self.movies.push(new Movie(options[i]));
			}

			if (!!options.name) {self.name(options.name);}
		}
	};

	var Review = function (options) {
		var self = this;

		self.description = ko.observable('');
		self.rating = ko.observable(0);
		self.update = false;

		if (!!options) {
			if (!!options.description) {self.description(options.description); update = true; }
			if (!!options.rating) {self.rating(options.rating); update = true;}
		}

		self.changeRating = function (a) {
			var rating = self.rating();
			rating += a;
			if (rating > 5) {rating = 5; }
			if (rating < 0) {rating = 0; }
			self.rating(rating);
		};
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
			if (!!self.user && self.user.userId) {
				userId = self.user.userId;
			}
			$.ajax({
				url: "http://localhost/DatabaseProject/BackEnd/ajax/getChannels.php",
				method: "POST",
				data: {
					userId: userId
				}
			}).done(function (rep) {
				if (!!rep && !!rep.channels && $.isArray(rep.channels)) {
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
				if (rep === 'EMPTY') {
					self.modalReview(new Review());
				} else {

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