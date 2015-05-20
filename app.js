
var http = require('https'),
	parseString = require('xml2js').parseString;

function postXML(options,data,callback,errorCallback){
	post(options,data,function(data){
		xml2json(data,callback,errorCallback);
	});
}

function post(options,data,callback,array){
	var req= http.request(options, function(response) {
		var str = [];
		
		response.on('data', function (chunk) {
			str.push(chunk);
		});
		
		response.on('end', function () {
			if (!array){
				callback(str.join(""));
			} else {
				callback(str);
			}
		});
	})
	req.write(data)
	req.end();
}

function xml2json(string,callback,errorCallback){
	parseString(string, function (err, result) {
		if (err){
			errorCallback(err);
		} else {
			callback(result);
		}
	});
}

function addZero(num) {
	return (num >= 0 && num < 10) ? "0" + num : num + "";
}

/* TODO: there has got to be a better way to do this! */
function getDateTimestampNow(){
	var now = new Date();
	var strDateTime = [[ now.getFullYear(),addZero(now.getMonth() + 1),addZero(now.getDate()) ].join("-"), [addZero(now.getHours()), addZero(now.getMinutes()),addZero(now.getSeconds())].join(":")].join("T");
	return strDateTime;
}


function getArrivalsNowFrom(fromStation,toStation,callback){
	getArrivalsFrom(fromStation,toStation,getDateTimestampNow(),callback);
}

var rtOptions = {
	method: 'POST',
	host: 'realtime.nationalrail.co.uk',
	headers: {
		'User-Agent': 'nationalrailenq',
		'Content-Type': 'text/xml;charset=UTF-8',
		'Accept-Encoding': 'gzip'
	},
	path: '/LDBSVWS/ldbsv4.asmx',
	port: 443
}
var ACCESS_TOKEN = "fae7caa0-286c-47c8-85b8-019eb889c846";

function getArrivalsFrom(fromStation,toStation,at,callback){
	getAFXML(fromStation,toStation,at,function(xml){
		postXML(rtOptions,xml,function(data){
			callback(data['soap:Envelope']['soap:Body'][0]['GetArrivalBoardByCRSResponse'][0]['GetBoardResult'][0]['trainServices']);
		},function(err){
			console.log(err);
		});
	});
}

function getAFXML(fromStation,toStation,at,callback){
	var xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:com="http://thalesgroup.com/RTTI/2010-11-01/ldb/commontypes" xmlns:typ="http://thalesgroup.com/RTTI/2011-10-31/ldbsv/types"> 	<soapenv:Header> 		<com:AccessToken> 			<com:TokenValue>'+ACCESS_TOKEN+'</com:TokenValue> 		</com:AccessToken> 	</soapenv:Header> 	<soapenv:Body> 		<typ:GetArrivalBoardByCRSRequest> 			<typ:numRows>50</typ:numRows> 			<typ:crs>'+fromStation+'</typ:crs> 			<typ:time>'+at+'</typ:time> 			<typ:timeWindow>120</typ:timeWindow> 			<typ:filtercrs>'+toStation+'</typ:filtercrs> 			<typ:filterType>to</typ:filterType> 			<typ:services>PBS</typ:services> 		</typ:GetArrivalBoardByCRSRequest> 	</soapenv:Body> </soapenv:Envelope>';
	callback(xml);
}

function getTrainsArrivingOrLeavingSoon(howSoonIsSoonInMinutes, callback){
	var error = null;
	var res = null;
	getArrivalsNowFrom('CBW','',function(data){
		if (data){

			res = data[0].service
						.map(transformData)
						.filter( scanForOutgoing(howSoonIsSoonInMinutes) );

			callback(error,res);
		}

	});
}

function transformData(from){
	var to = {};
	for (var i in from){
		to[i] = from[i][0];
		if (i == 'origin' || i == 'destination'){
			to[i] = transformData(to[i].location[0]);
		}
		if (i.length==3 && i.indexOf('t')==1 ){
			try {
				to[i] = new Date(to[i]+"+01:00");
			} catch (e){

			}
		}
	}
	return to;
}

function scanForOutgoing(howSoonIsSoonInMinutes){
	howSoonIsSoon = howSoonIsSoonInMinutes * 60 * 1000;
	return function(record){

		if (record.eta) {
			record.tta = record.eta - Date.now();
			if ( record.tta <= howSoonIsSoon){
				return record;
			}
		} else {
			// console.log('got one without an eta: ',record);
		}
	};
}

module.exports = {
	getTrainsArrivingOrLeavingSoon : getTrainsArrivingOrLeavingSoon
}
