define([
	'text!ressources/js/pages/SearchPageTemplate.html',
	'../movie/Movie',
	'knockout',
	'komapping'
], function(template, Movie, ko, komapping) {
	'use strict';

	$('#page-top').append(template);

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

	var SearchPage = function (searchBars) {
		var self = this;

		self.text = "SearchPage";

		self.searchBars = searchBars;

		self.modalMovie = ko.observable();
		self.modalReview = ko.observable();

		self.movieDisplay = ko.observableArray([]);
		/*================================
					Functions
		================================*/

		self.setModalMovie = function (movie) {
			self.modalMovie(movie);
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

		self.refresh = function () {
			var bars = self.searchBars;
			if (bars.movie() === bars.movieList()[0] &&
				bars.director() === bars.directorList()[0] &&
				bars.genre() === bars.genreList()[0]) {
				return;
			}
			var search = {};
			if (bars.movie() !== bars.movieList()[0]) {search['movieId'] = bars.movie().id; }
			else if (bars.genre() !== bars.genreList()[0]) {search['genreId'] = bars.genre().id; }
			else if (bars.director() !== bars.directorList()[0]) {search['directorId'] = bars.director().id; }

			$.ajax({
				url: "http://localhost/DatabaseProject/BackEnd/ajax/getMovies.php",
				method: "POST",
				data: search
			}).done(function (rep) {
				self.movieDisplay([]);
				rep = JSON.parse(rep);
				if (!$.isArray(rep) && $.isArray(rep.movies)) {rep = rep.movies;}
				if ($.isArray(rep)){
					$.each(rep, function(index, value) {
						self.movieDisplay.push(new Movie(rep[index]));
					})
				}
			});
		};
		self.refresh();

	};

	return SearchPage;

});