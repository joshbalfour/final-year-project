var mysql      = require('mysql');
var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'root',
  password : 'level_crossing_predictor',
  database : 'level_crossing_predictor'
});

module.exports = connection;
