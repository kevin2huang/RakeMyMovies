define([
	'knockout',
	'komapping'
], function(ko, komapping) {
	'use strict';

	var Movie = function () {
		var self = this;

		self.name = 'This is a movie';
		self.time = '1h30'
		self.rating = 5;
		self.description = "This is a random description of a movie. Most movies contain a certain number of actors, named the cast, along with usually\
		one or more directors and one or more studio. A good movie gets a good rating, whereas a bad movie gets a bad rating.";
		self.year = 1995;
		self.studio = 'Walt Disney';
		self.director = ['Martin Luther King'];
		self.cast = ['Angelina Jolie', 'Brad Pit', 'Will smith', 'Leonardo DiCaprio'];

	};

	return Movie;

});