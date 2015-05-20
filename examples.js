
var app = require('./app.js');

// gotta be a number
var howSoonIsSoonInMinutes = 30;
// CRS code (read: http://www.nationalrail.co.uk/stations_destinations/48541.aspx)
var atStation = 'CBW';

/*
	Trains is an array of objects
 */
app.getTrainsArrivingOrLeavingSoon(atStation,howSoonIsSoonInMinutes,function(error, trains){
	if (error){
		console.log('Errored:',error);
	} else {
		if (trains && trains.length > 0){
			console.log('Trains coming soon:',trains);
		}
	}
});