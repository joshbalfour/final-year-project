app.service('Tween', function ($rootScope) {
	
	setInterval(TWEEN.update, 10);

	return function () {
		var tween = new TWEEN.Tween;
		tween.constructor.apply(tween, arguments);
		tween.onUpdate(function () {
			$rootScope.$digest();
		});
		return tween;
	};

});