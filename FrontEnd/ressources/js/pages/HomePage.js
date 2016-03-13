define([
	'text!ressources/js/pages/HomePageTemplate.html',
	'../movie/Movie',
	'knockout',
	'komapping'
], function(template, Movie, ko, komapping) {
	'use strict';

	$('#page-top').append(template);

	var Channel = function () {
		self = this;

		self.name = "Some Channel";

		self.movies = ko.observableArray([]);

		for (var i = 0; i < 6; i++ ){
			self.movies().push(new Movie());
		}
	};

	var HomePage = function (user) {
		var self = this;

		self.text = "HomePage";

		self.user = user;

		self.channels = ko.observableArray([]);

		for(var i = 0; i < 5; i++) {
			self.channels().push(new Channel())
		}

		self.modalMovie = ko.observable(null);

		/*================================
					Functions
		================================*/

		self.setModalMovie = function (movie) {
			self.modalMovie(movie);
		};
	};

	return HomePage;

});