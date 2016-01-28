var merge = require('merge');
var mysql = require('./mysql');

function getRoutes(cb) {
	mysql.query(
		'select count(*) as le_count from train_routes WHERE `hasCrossing` = 1',
		function (err, results) {

			var streamable = mysql.query(
				'SELECT * from train_routes WHERE `hasCrossing` = 1'
		//		+ " AND contains(GeomFromText('Polygon((51.500217 0.214378, 51.493949 1.503170, 50.671713 1.503170, 50.690852 0.002936, 51.500217 0.214378))'), route);"
			);
			streamable.total = results[0].le_count;
			cb(streamable);
		}
	);
}

function getCrossings(cb) {
	mysql.query(
		'SELECT * from crossings'
//		+ " WHERE contains(GeomFromText('Polygon((51.500217 0.214378, 51.493949 1.503170, 50.671713 1.503170, 50.690852 0.002936, 51.500217 0.214378))'), loc);"
		, function(err, rows, fields) {
	  if (err) throw err;

	  cb(rows);
	});
}

Array.prototype.first = function () {
	return this[0];
};
Array.prototype.last = function () {
	return this[this.length - 1];
};

Array.prototype.remove = function (element) {
	var index = this.indexOf(element);
	if (index > -1) {
		this.splice(index, 1);
	}
};


function sqr(x) { return x * x; }
function dist2(v, w) { return Math.sqrt(sqr(v.x - w.x) + sqr(v.y - w.y)); }


function pointKey(point) {
	return point.x + '-' + point.y;
}

var normalizedPointMap = {};
function normalizePoint(point, type, meta) {
	var key = pointKey(point);
	if (!normalizedPointMap[key]) {
		normalizedPointMap[key] = merge.recursive({}, point, meta);
	}

	normalizedPointMap[key].type = type;

	return normalizedPointMap[key];
}


function getDatabaseData(cb) {


	getCrossings(function (crossings) {
		getRoutes(function (routes) {
			cb(
				routes,
				crossings
			);
		});
	});
}

var asyncTracker = (function (logThreshold) {
	var onComplete = function () {};
	var counter = 0;
	return {
		track: function () {
			counter++;
			return function () {
				counter--;

				if ((counter % logThreshold) == 0) {
					console.log(counter + ' pending DB commit');
				}

				if (counter == 0) {
					onComplete();
				}
			};
		},
		onComplete: function (_onComplete) {
			onComplete = _onComplete;
			if (counter == 0) {
				onComplete();
			}
		}
	};
});

function routeHasCrossingIn(route) {
	return route.some(function (point) {
		return point.type == 'crossing';
	});
}

function insertConnectionsIntoDB(connections, cb) {
	cb = cb || function () {};

	connections = [].concat(connections);
	var tracker = asyncTracker(100);


	while(connections.length) {
		var connectionsToSend = connections.splice(0, 100);

		var placeHolders = [];
		var params = [];
		connectionsToSend.forEach(function (connection) {
			placeHolders.push("(?, ?, ?, ?)");
			params = params.concat([connection.train_route_id, connection.crossing_id, connection.distance_along_track, connection.node_number]);
		});

		mysql.query(
			"INSERT INTO train_route_has_crossing (`train_route_id`, `crossing_id`, `distance_along_track`, `node_number`) VALUES " + placeHolders.join(','),
			params,
			function (err, result) {
				if (err) {
					console.log(err);
				}
				tracker.track();
			}
		);

		tracker.onComplete(cb);
	}
}

function getCrossingMap(crossings) {
	var crossingsMap = new Map();

	crossings.forEach(function (crossing) {
		var loc = normalizePoint(crossing.loc, 'crossing');

		crossingsMap.set(loc, crossing);
	});

	return crossingsMap;
}


function getCrossingsInRoute(route, crossingsMap) {
	var connectionPoints = [];

	var distanceTraveled = 0;

	route.route.forEach(function (point, index, points) {
		if (index === 0) {
			return;
		}
		var prevPoint = points[index - 1];
		distanceTraveled += dist2(prevPoint, point);

		var normPoint = normalizePoint(point);
		if (!crossingsMap.has(normPoint)) {
			return;
		}
		var crossing = crossingsMap.get(normPoint);

		connectionPoints.push({
			train_route_id: route.id,
			crossing_id: crossing.id,
			distance_along_track: distanceTraveled,
			node_number: index
		});
	});

	return connectionPoints;
}

mysql.connect();

getDatabaseData(function (routesStream, crossings) {

	console.log('Mapping crossings to map');
	var crossingMap = getCrossingMap(crossings);
	var i = 0;
	console.log('Pulling crossings from routes');

	routesStream
		.on('error', function(err) {
			// Handle error, an 'end' event will be emitted after this as well
			console.log('Fuck', err);
		})
		.on('result', function (row) {
			if (((++i) % 50) === 0) {
				console.log('Processing route: ' + (i) + '/' + routesStream.total);
			}

			var crossingsInRoutes = getCrossingsInRoute(row, crossingMap);
			insertConnectionsIntoDB(crossingsInRoutes);
		})
		.on('end', function() {
			console.log('Shutting down...');
			
			// all rows have been received
			setTimeout(function () {
				mysql.end();
			}, 1000);			
		});

});



