var express = require('express');
var app = express();
var bodyParser = require('body-parser');
var exec = require('child_process').execSync;

app.use(bodyParser.json());

app.post('/redeploy', function (req, res) {
	redeploy();
	res.json(true);
});

var server = app.listen(7000, function () {
	var host = server.address().address;
	var port = server.address().port;

	console.log('[',(new Date()).toUTCString(),']','Auto Deploy webhook listening at http://'+host+':'+port);

	console.log('[',(new Date()).toUTCString(),']','git status: ',exec("cd ~ && cd final-year-project && git status"));
});

function redeploy(){
	console.log('[',(new Date()).toUTCString(),']','Redeploying...');
	
	try {
		console.log('[',(new Date()).toUTCString(),']',exec("cd ~ && cd final-year-project && git pull"));
	} catch (e){
		console.log('[',(new Date()).toUTCString(),']','Redeployment Error:',e,e.message);
		return;
	}


	console.log('[',(new Date()).toUTCString(),']','Restarting self...');
	
	console.log('[',(new Date()).toUTCString(),']',exec("forever restartall"));
}