app.controller('MapController', function ($http, $interval, Tween) {

	var ctrl = this;

	// Maps zoom level
	this.zoom = 7;

	// Center of the google map
	this.center = {
		latitude: 51.297761,
		longitude: 1.071835 
	};

	// Default settings passed when stating google maps
	this.mapOptions = {
		streetViewControl: false
	};

	// List of level crossings to show
	this.gateMarkers = [];

	// Should the extra details panel be open
	this.showCrossingDetails = false;

	// Data to show in the extra details popup
	this.crossingDetails = {};

	// Google map library is bound to this on boot
	this.googleMap = {};

	/**
	 * Loads all of the crossings from the server.
	 * Updates he gateMarkers array.
	 */
	this.loadCrossings = function () {
		$http.get('debug')
		.then(function (response) {
			var result = response.data;

			// Clear the old markers
			this.gateMarkers = [];
			console.log(result);
			/*
			// Check the API call succeeded
			if (response.result !== "OK") {
				return false;
			}
			*/

			// Convert the data into a format that
			// the google maps library understands
			
			var points = [];

			// xings
			points = points.concat(result[1].map(function (crossing, index) {
				return {
					id: index+'-xing',
					latitude: crossing.lat,
					longitude: crossing.lng,
					icon: 'https://maps.gstatic.com/intl/en_us/mapfiles/markers2/measle_blue.png',
					type: 'xing'
				};
			}));

			// stations
			points = points.concat(result[0].map(function (crossing, index) {
				return {
					id: index+'-stn',
					latitude: crossing.lat,
					longitude: crossing.lng,
					icon: 'https://maps.gstatic.com/intl/en_us/mapfiles/markers2/measle.png',
					type: 'station'
				};
			}));

			ctrl.gateMarkers = points;

		});
	};

	/**
	 * Returns the longitude range between the
	 * left and right side of the map
	 * 
	 * @return int
	 */
	this.mapLongRange = function () {
		var bounds = ctrl.googleMap.getGMap().getBounds();
		return bounds.getNorthEast().lng() - bounds.getSouthWest().lng();
	};

	/**
	 * On click handler for when a user clicks or tabs
	 * a crossing icon on the map
	 * 
	 * @param  Object marker Google maps Marker
	 * @param  String event  The event on the marker
	 * @param  Object model  The data model used to build the marker
	 */
	this.markerClicked = function (marker, event, model) {
		// // Show the popup
		// ctrl.showCrossingDetails = true;

		// // Get the new center location for the map
		// var width = ctrl.mapLongRange();
		// var newLocation = {
		// 	latitude: model.latitude,
		// 	longitude: model.longitude + width / 4
		// };

		// // Slide the map so the crossing icon is in the center
		// var tween = Tween(ctrl.center).to(newLocation, 500);
		// tween.easing(TWEEN.Easing.Cubic.InOut);
		// tween.start();

		// // Download the crossing meta data
		// $http.get('app/fixtures/crossings-' + model.id + '.json')
		// .then(function (response) {

		// 	var result = response.data;

		// 	// Check the API call succeeded
		// 	if (result.result !== "OK") {
		// 		return false;
		// 	}

		// 	// Copy the data to scope
		// 	ctrl.crossingDetails.meta = result.data;
		// });

		// // Download the future crossing times
		// $http.get('app/fixtures/crossings-' + model.id + '-times.json')
		// .then(function (response) {

		// 	var result = response.data;

		// 	// Check the API call succeeded
		// 	if (result.result !== "OK") {
		// 		return false;
		// 	}

		// 	// Copy the data to scope
		// 	ctrl.crossingDetails.times = result.data;
		// });
	};

	/**
	 * Closes the extra details popup
	 */
	this.closeCrossingDetals = function () {
		// Hide the popup
		ctrl.showCrossingDetails = false;
		// Clear the data for the popup
		this.crossingDetails = {};
	};

	/**
	 * Initialization function when the controller loads
	 */

	this.init = function () {
		ctrl.loadCrossings();
		// $interval(function () {
		// 	ctrl.loadCrossings();
		// }, 5000);
	};
});
