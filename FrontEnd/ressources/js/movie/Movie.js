define([
	'knockout',
	'komapping'
], function(ko, komapping) {
	'use strict';

	var Movie = function (options) {
		var self = this;

		if (!!options) {
			self.name = options.name;
			self.time = options.time;
			self.rating = options.rating;
			self.description = options.description;
			self.year = options.year;
			self.studio = options.studio;
			self.director = options.director;
			self.cast = options.cast;
		} else {
			self.name = 'This is a movie';
			self.time = '1h30'
			self.rating = 5;
			self.description = "This is a random description of a movie. Most movies contain a certain number of actors, named the cast, along with usually\
			one or more directors and one or more studio. A good movie gets a good rating, whereas a bad movie gets a bad rating.";
			self.year = 1995;
			self.studio = 'Walt Disney';
			self.director = ['Martin Luther King'];
			self.cast = ['Angelina Jolie', 'Brad Pit', 'Will smith', 'Leonardo DiCaprio'];
		}
	};

	return Movie;

});