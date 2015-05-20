
var app = require('./app.js');

var howSoonIsSoonInMinutes = 30;

app.getTrainsArrivingOrLeavingSoon(howSoonIsSoonInMinutes,function(error, trains){
	if (error){
		console.log('Errored:',error);
	} else {
		if (trains && trains.length > 0){
			console.log('Trains coming soon:',trains);
		}
	}
});