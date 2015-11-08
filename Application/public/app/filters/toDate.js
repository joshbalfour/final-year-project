app.filter('toDate', function () {
	return function (date) {
		return new Date(date);
	};
});