/**
 * Angular wrapper for the Tween library
 */
app.service('Tween', function ($rootScope) {
	
	// Tell tween up run a frame every 10 milliseconds
	setInterval(TWEEN.update, 10);

	// Factory that will auto create a tween
	// And apply angular digest after each frame
	return function () {
		var tween = new TWEEN.Tween;
		tween.constructor.apply(tween, arguments);
		tween.onUpdate(function () {
			$rootScope.$digest();
		});
		return tween;
	};

});