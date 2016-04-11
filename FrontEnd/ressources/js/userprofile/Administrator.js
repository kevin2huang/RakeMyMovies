define([
	'text!ressources/js/userprofile/AdministratorTemplate.html',
	'../movie/Movie',
	'knockout',
	'komapping',
], function(template, Movie, ko, komapping) {
	'use strict';

	$('#page-top').append(template);

	var Administrator = function (user) {
		var self = this;

		self.text = "Administrator";

		self.user = user;

		self.movieList = ko.observableArray([{
			name: 'test',
			id: 1
		}, {
			name: 'fluff',
			id: 2
		}, {
			name: 'foo',
			id: 3
		}]);
		self.selectedMovie = ko.observable();
		self.movieInfo = ko.observable();
		self.directorList = ko.observableArray([{
			name: 'test',
			id: 1
		}, {
			name: 'fluff',
			id: 2
		}, {
			name: 'foo',
			id: 3
		}]);
		self.selectedDirector = ko.observable();
		self.genreList = ko.observableArray([{
			name: 'test',
			id: 1
		}, {
			name: 'fluff',
			id: 2
		}, {
			name: 'foo',
			id: 3
		}]);
		self.selectedGenre = ko.observable();

		$.ajax({
			url: "http://localhost/DatabaseProject/BackEnd/ajax/getAllNamesAndIds.php",
			method: "POST",
			data: {}
		}).done(function (rep) {
			rep = JSON.parse(rep);
			if (!!rep && !!rep.movies && $.isArray(rep.movies)) {
				self.movieList(rep.movies);
			}
			if (!!rep && !!rep.directors && $.isArray(rep.directors)) {
				self.directorList(rep.directors);
			}
			if (!!rep && !!rep.genres && $.isArray(rep.genres)) {
				self.genreList(rep.genres);
			}
		});

		self.getMovie = function () {
			if (!!self.selectedMovie()) {
				$.ajax({
					url: "http://localhost/DatabaseProject/BackEnd/ajax/getMovies.php",
					method: "POST",
					data: {
						movieId : self.selectedMovie().id
					}
				}).done(function (rep) {
					rep = JSON.parse(rep);
					if (!!rep.movies && $.isArray(rep.movies)) {rep = rep.movies[0];}
					self.movieInfo(new Movie(rep))
				});
			}
		};

		self.add = function (name, observableArr) {
			self.movieInfo()[observableArr].push(name);
		};
		self.remove = function (name, observableArr) {
			self.movieInfo()[observableArr].remove(name);
		};
		self.save = function () {
			$.ajax({
				url: "http://localhost/DatabaseProject/BackEnd/ajax/updateMovie.php",
				method: "POST",
				data: {
					movieId: selectedMovie().movieId(),
					directors: movieInfo().directors(),
					genres: movieInfo().genres()
				}
			});
		};
	};

	return Administrator;

});