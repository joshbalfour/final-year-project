app.controller('DebugController', function ($http, $interval, $rootScope) {
	$rootScope.debug = {
		enabled: false,
		trainLocations: []
	}; 

	function pullTrainLocations() {

		if (!$rootScope.debug.enabled) {
			$rootScope.debug.trainLocations = [];
			return;
		}

		$http.get('debug/active_trains')
		.then(function (response) {
			$rootScope.debug.trainLocations = response.data.data.map(function (obj) {
				return {
					icon: "http://cl.ly/3k1o3D461W11/Image%202016-02-15%20at%209.46.12%20pm.png",
					id: obj.rid,
					latitude: obj.location.x,
					longitude: obj.location.y,
				};
			});
		});
	}

	$interval(pullTrainLocations, 2000);
	pullTrainLocations();

});
