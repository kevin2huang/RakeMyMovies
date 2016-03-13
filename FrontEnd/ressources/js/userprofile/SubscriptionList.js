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

		//self.user = user;

		self.genres = ko.observableArray([]);
		self.genres().push('Horror');
		self.genres().push('Action');
		self.genres().push('Comedy');
		self.genres().push('Documentary');
		self.genres().push('New');
		self.genres().push('Thriller');
		self.genres().push('Animated');
		self.genres().push('Drama');
		self.genres().push('Western');

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

		self.artists = ko.observableArray([]);
		self.artists().push('Robert Downey Jr.');
		self.artists().push('Tom Hanks');
		self.artists().push('Jonny Depp');
		self.artists().push('Tom Cruise');
		self.artists().push('Will Smith');
		self.artists().push('Brad Pitt');
		self.artists().push('Morgan Freeman');
		self.artists().push('George Clooney');
		self.artists().push('Robin Williams');

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