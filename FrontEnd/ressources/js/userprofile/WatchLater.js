define([
	'text!ressources/js/userprofile/WatchLaterTemplate.html',
	'knockout',
	'komapping'
], function(template, ko, komapping) {
	'use strict';

	$('#page-top').append(template);

	var WatchLater = function (user) {
		var self = this;

		self.text = "WatchLater";

		self.user = user;
	};

	return WatchLater;

});