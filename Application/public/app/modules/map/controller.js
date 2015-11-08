app.controller('MapController', function ($http, $interval, Tween) {

	var ctrl = this;

	this.zoom = 10;
	this.center = {
		latitude: 51.297761,
		longitude: 1.071835 
	};
	this.mapOptions = {
		streetViewControl: false
	};
	this.gateMarkers = [];

	this.showCrossingDetails = false;
	this.crossingDetails = {};

	this.googleMap = {};

	/**
	 * Loads all of the crossings from the server.
	 * Updates he gateMarkers array.
	 */
	this.loadCrossings = function () {
		$http.get('app/fixtures/crossings.json')
		.then(function (response) {
			var result = response.data;

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

	this.mapLongRange = function () {
		var bounds = ctrl.googleMap.getGMap().getBounds();
		return bounds.getNorthEast().lng() - bounds.getSouthWest().lng();
	};

	this.markerClicked = function (marker, event, model) {
		ctrl.showCrossingDetails = true;

		var width = ctrl.mapLongRange();

		var newLocation = {
			latitude: model.latitude,
			longitude: model.longitude + width / 4
		};

		var tween = Tween(ctrl.center).to(newLocation, 500);
		tween.easing(TWEEN.Easing.Cubic.InOut);
		tween.start();

		$http.get('app/fixtures/crossings-' + model.id + '.json')
		.then(function (response) {

			var result = response.data;

			// Check the API call succeeded
			if (result.result !== "OK") {
				return false;
			}

			ctrl.crossingDetails.meta = result.data;
		});


		$http.get('app/fixtures/crossings-' + model.id + '-times.json')
		.then(function (response) {

			var result = response.data;

			// Check the API call succeeded
			if (result.result !== "OK") {
				return false;
			}

			ctrl.crossingDetails.times = result.data;
		});
	};

	this.closeCrossingDetals = function () {
		ctrl.showCrossingDetails = false;
		this.crossingDetails = {};
	};

	this.init = function () {
		ctrl.loadCrossings();
		$interval(function () {
			ctrl.loadCrossings();
		}, 5000);
	};
});
