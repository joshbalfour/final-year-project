var qualityRegex = require('emoji-regex')();
var fs = require('fs');
var path = require('path');

var exts = ['php'];

var qualityMultiplier = 20;

function fileQuality(fileName, callback){
	fs.readFile(fileName,'utf-8', function(err, contents){
		if (err){
			callback(err,null);
		} else {
			var no = contents.match(qualityRegex);
			if (!no){
				no = [];
			}
			callback(null, Math.round( (no.length / contents.split(' ').join('').split('\n').join('').length) * 100) * qualityMultiplier);
		}
	});
}


var walk = function(dir, done) {
  var results = [];
  fs.readdir(dir, function(err, list) {
	 if (err) return done(err);
	 var pending = list.length;
	 if (!pending) return done(null, results);
	 list.forEach(function(file) {
		file = path.resolve(dir, file);
		fs.stat(file, function(err, stat) {
		  if (stat && stat.isDirectory()) {
			 walk(file, function(err, res) {
				results = results.concat(res);
				if (!--pending) done(null, results);
			 });
		  } else {
			 var ext = file.split('.');
			 if (exts.indexOf(ext[ext.length - 1]) != -1){
			 	results.push(file);
			 }
			 if (!--pending) done(null, results);
		  }
		});
	 });
  });
};

var noOfFiles = 0;

var qualityScores = [];

var assert = require('assert');

describe('Level Crossing Predictor', function() {


	it('should have quality PHP code', function (cestFini) {
		walk('/src/app', function(err, phpFiles){

			phpFiles.forEach(function(file){

				fileQuality(file, function(err, qualityScore){
					
					qualityScores.push(qualityScore);

					if (phpFiles.length == qualityScores.length){
						done();
					}

				});
			});
		});

		function done(){
			
			var totalScore = 0;
			qualityScores.forEach(function(score){
				totalScore+=score;
			});

			var avgScore = totalScore / qualityScores.length;
			
			console.log('Quality score: '+avgScore);

			var passed = (avgScore < 5.71);

			cestFini(passed);
		}
	});
});
