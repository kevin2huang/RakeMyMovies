define([
	'knockout',
	'komapping'
], function(ko, komapping) {
	'use strict';

	var Movie = function (options) {
		var self = this;

		self.name = ko.observable('This is a movie');
		self.time = ko.observable('1h30');
		self.rating = ko.observable(0);
		self.description = ko.observable("This is a random description of a movie. Most movies contain a certain number of actors, named the cast, along with usually one or more directors and one or more studio. A good movie gets a good rating, whereas a bad movie gets a bad rating.");
		self.year = ko.observable(1995);
		self.studio = ko.observableArray(['Walt Disney']);
		self.director = ko.observableArray(['Martin Luther King']);
		self.cast = ko.observableArray(['Angelina Jolie', 'Brad Pit', 'Will smith', 'Leonardo DiCaprio']);
		self.genres = ko.observableArray(['Horror', 'Comedy', 'Drama']);
		self.movieId = ko.observable(-1);
		self.country = ko.observable('US');
		self.image = ko.observable('');
		self.language = ko.observable('ENG');
		self.releaseDate = ko.observable('1 Jan 2010');
		self.tg = ko.observable('G');
		self.trailerUrl = ko.observable('http://www.youtube.com/embed/XGSy3_Czz8k'); //trailerUrl
		if (!!options) {
			if (!!options.movietitle) { self.name(options.movietitle);}
			if (!!options.movieduration) { self.time(options.movieduration);}
			if (!!options.rating) { self.rating(options.rating);}
			if (!!options.moviedescription) { self.description(options.moviedescription);}
			if (!!options.year) { self.year(options.year);}
			if (!!options.studios) { self.studio(options.studios);}
			if (!!options.directors) { self.director(options.directors);}
			if (!!options.actors) { self.cast(options.actors);}
			if (!!options.movieid) { self.movieId(options.movieid);}
			if (!!options.moviecountry) {self.country(options.moviecountry);}
			if (!!options.moviecover) {self.image(options.moviecover);}
			if (!!options.movielanguage) {self.language(options.movielanguage);}
			if (!!options.moviereleasedate) {self.releaseDate(options.moviereleasedate);}
			if (!!options.movietgrating) {self.tg(options.movietgrating);}
			if (!!options.trailerUrl) {self.trailerUrl(options.trailerUrl);}
		} 
	};

	return Movie;

});