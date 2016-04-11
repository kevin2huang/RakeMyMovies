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

		self.movieList = ko.observableArray([]);
		self.selectedMovie = ko.observable();
		self.movieInfo = ko.observable();
		self.directorList = ko.observableArray([]);
		self.selectedDirector = ko.observable();
		self.genreList = ko.observableArray([]);
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
				$.each(rep.directors, function (i, value) {
					self.directorList.push({
						directorid: rep.directors[i].id,
						directorname: rep.directors[i].name
					});
				});
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
		self.removeDir = function (name, observableArr) {
			self.movieInfo()[observableArr].remove(function(value) {
				return value.directorname === name.directorname;
			});
		};
		self.save = function () {
			$.ajax({
				url: "http://localhost/DatabaseProject/BackEnd/ajax/updateMovie.php",
				method: "POST",
				data: {
					movieId: self.movieInfo().movieId(),
					directors: self.movieInfo().director(),
					genres: self.movieInfo().genres()
				}
			});
		};
	};

	return Administrator;

});