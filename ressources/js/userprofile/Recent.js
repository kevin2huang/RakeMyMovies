define([
	'text!ressources/js/userprofile/RecentTemplate.html',
	'knockout',
	'komapping'
], function(template, ko, komapping) {
	'use strict';

	$('#page-top').append(template);

	var Recent = function (user) {
		var self = this;

		self.text = "Recent";

		self.user = user;
	};

	return Recent;

});