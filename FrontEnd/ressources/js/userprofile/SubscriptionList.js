define([
	'text!ressources/js/userprofile/SubscriptionListTemplate.html',
	'knockout',
	'komapping'
], function(template, ko, komapping) {
	'use strict';

	$('#page-top').append(template);

	var SubscriptionList = function (user) {
		var self = this;

		self.text = "Subscriptions";

		self.user = user;

		self.genres = ko.observableArray([]);
		self.artists = ko.observableArray([]);

		$.ajax({
			url: "http://localhost:8888/DatabaseProject/BackEnd/ajax/getSubscriptions.php",
			method: "POST",
			data: {
				userId: self.user.userId,
			}
		}).done(function (rep) {
			if (!!rep.genres && $.isArray(rep.genres)) {
				$.each(rep.genres, function (key, value) {
					self.genres().push(value);
				});
			}
			if (!!rep.actors && $.isArray(rep.actors)) {
				$.each(rep.genres, function (key, value) {
					self.genres().push(value);
				});
			}
		});

		self.newGenreInput = ko.observable('');

		self.removeFromGenres = function (genre) {
			self.genres.remove(function (g) {
				return g === genre;
			});
		};

		self.addGenre = function () {
			if (self.newGenreInput() !== '') {
				self.genres.push(self.newGenreInput());
				self.newGenreInput('');
			}	
		};

		self.newArtistInput = ko.observable('');

		self.removeFromArtists = function (artist) {
			self.artists.remove(function (a) {
				return a === artist;
			});
		};

		self.addArtist = function () {
			if (self.newArtistInput() !== '') {
				self.artists.push(self.newArtistInput());
				self.newArtistInput('');
			}	
		};
	};

	return SubscriptionList;

});