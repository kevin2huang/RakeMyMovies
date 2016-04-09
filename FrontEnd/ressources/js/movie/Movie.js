define([
	'knockout',
	'komapping'
], function(ko, komapping) {
	'use strict';

	var Movie = function (options) {
		var self = this;

		self.name = ko.observable('This is a movie');
		self.time = ko.observable('1h30');
		self.rating = ko.observable(5);
		self.description = ko.observable("This is a random description of a movie. Most movies contain a certain number of actors, named the cast, along with usually one or more directors and one or more studio. A good movie gets a good rating, whereas a bad movie gets a bad rating.");
		self.year = ko.observable(1995);
		self.studio = ko.observable('Walt Disney');
		self.director = ko.observableArray(['Martin Luther King']);
		self.cast = ko.observableArray(['Angelina Jolie', 'Brad Pit', 'Will smith', 'Leonardo DiCaprio']);
		self.genres = ko.observableArray(['Horror', 'Comedy', 'Drama']);
		if (!!options) {
			if (!!options.name) { self.name(options.name)};
			if (!!options.time) { self.time(options.time)};
			if (!!options.rating) { self.rating(options.rating)};
			if (!!options.description) { self.description(options.description)};
			if (!!options.year) { self.year(options.year)};
			if (!!options.studio) { self.studio(options.studio)};
			if (!!options.director) { self.director(options.director)};
			if (!!options.cast) { self.cast(options.cast)};
		} 
	};

	return Movie;

});