require([
	'jQuery', 
	'knockout',
], function ($, ko, SpriteGenerator, Helper, BoardTemplate) {
	
    $(document).ready(function () {

        ko.components.register('welcome-screen', {
            viewModel: { require: 'ressources/js/welcome/Welcome' },
            template: { require: 'text!ressources/js/welcome/WelcomeTemplate.html' }
        });


        //Instantiate page view model
        ko.applyBindings(function () {});
    });
});
/*
Debug Knockout
<div data-bind="text: ko.toJSON($data)"></div>
or
<pre data-bind="text: ko.toJSON($data, null, 2)"></pre>

ko.dataFor will return the ViewModel that the element is bound to.
ko.contextFor returns the "binding context" of the current element. 
http://knockoutjs.com/documentation/unobtrusive-event-handling.html
*/