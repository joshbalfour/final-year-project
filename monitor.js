/* Database Handling */
var mysql = require('mysql');

/*

dbconfig.js is

module.exports = {
	host     : '',
	database : '',
	user     : '',
	password : '',
}

 */
var pool = mysql.createPool(require('./dbconfig.js'));

function doQuery(query,args,callback){
	var callback = callback || function(){};
	pool.getConnection(function(err, connection) {
		if (err){
		  mysqlConnectionError(err);
		  callback(err,null);
		} else {
			connection.query(query,args, function(err, rows) {
				if (err){
					mysqlSyntaxError(err,query);
				}
				callback(err,rows);
				connection.release();
			});
		}
	});
}

function mysqlConnectionError(err){
	log(err);
}

function mysqlSyntaxError(err,query){
	log(err+"\n with query:\n "+query);
}

function log(msg){
	console.log("[ "+(new Date()).toUTCString()+" ] " + msg);
}


function storeJourney(journey){

	store(journey.origin,'location');
	store(journey.destination,'location');

	journey.originCRS = journey.origin.crs;
	journey.destinationCRS = journey.destination.crs;

	delete journey.origin;
	delete journey.destination;

	store(journey,'journey');
}

function store(object, intable){
	var props = Object.keys(object);

	function q(){
		return '?'
	}

	var sql = "REPLACE INTO "+intable+" ("+props.join(',')+") VALUES("+props.map(q)+")";

	var values = props.map(function(prop){
		return object[prop];
	});

	doQuery(sql, values, function(err, data){
		if (err){
			log('error: ',err);
		} else {
			log('stored '+intable);
		}
	});
}

var app = require('./app.js');

function doScrape(){
	app.getTrains('CBW',function(err,data){
		if (err){
			log(err);
		} else {
			data.forEach(storeJourney);
		}
	});
}

var mins = 3;

doScrape();

setInterval(doScrape, mins*60*1000);