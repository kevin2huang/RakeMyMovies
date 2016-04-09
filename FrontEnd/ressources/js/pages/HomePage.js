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
				self.movies.push(new Movie(options.movies[i]));
			}
		}
	};

	var HomePage = function (user) {
		var self = this;

		self.text = "HomePage";

		self.user = user;

		self.channels = ko.observableArray([]);

		self.modalMovie = ko.observable(null);

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
				url: "http://localhost:8888/DatabaseProject/BackEnd/ajax/getChannels.php",
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

		self.getChannels();
	};

	return HomePage;

});