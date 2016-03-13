define([
	'../userprofile/Profile',
	'../userprofile/Recent',
	'../userprofile/ReviewList',
	'../userprofile/SubscriptionList',
	'text!ressources/js/pages/UserProfilePageTemplate.html',
	'knockout',
	'komapping',
	'jquery'
], function(Profile, Recent, ReviewList, SubscriptionList, template, ko, komapping, $) {
	'use strict';

	$('#page-top').append(template);

	var UserProfilePage = function (user) {
		var self = this;

		self.text = "UserProfilePage";

		self.user = user;

		self.profiletabs = ko.observableArray([]);
		self.profiletabs().push(new Profile());
		self.profiletabs().push(new Recent());
		self.profiletabs().push(new ReviewList());
		self.profiletabs().push(new SubscriptionList());

		self.profiletabsActive = ko.observable(self.profiletabs()[0]);

		self.modalMovie = ko.observable(null);

		self.setActiveTab = function (tab) {
			self.profiletabsActive(tab);
		};
	};

	return UserProfilePage;

});