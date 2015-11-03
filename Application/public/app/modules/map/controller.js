app.controller('MapController', function ($http) {

	var ctrl = this;

	this.zoom = 10;
	this.center = {
		latitude: 51.297761,
		longitude: 1.071835 
	};
	this.gateMarkers = [];

	this.loadCrossings = function () {
		$http.get('app/fixtures/crossings.json')
		.then(function (request) {
			var result = request.data;

			// Clear the old markers
			this.gateMarkers = [];

			// Check the API call succeeded
			if (result.result !== "OK") {
				return false;
			}

			// Convert the data into a format that
			// the google maps library understands
			ctrl.gateMarkers = result.data.map(function (crossing) {
				return {
					id: crossing.id,
					latitude: crossing.location.lat,
					longitude: crossing.location.lon,
					icon: 'app/images/barrier-' + crossing.status + '.png'
				};
			});
		});
	};

	this.init = function () {
		this.loadCrossings();
	};
});
