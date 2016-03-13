define([
	'text!ressources/js/userprofile/ProfileTemplate.html',
	'knockout',
	'komapping'
], function(template, ko, komapping) {
	'use strict';

	$('#page-top').append(template);

	var Profile = function (user) {
		var self = this;

		self.text = "Profile";

		self.user = user;

	};

	return Profile;

});