var express = require('express');

var app = express();
var port = 9000;

app.get('/', function(req, res) {
	res.send('hello world');
	console.log('listening!');
});

app.listen(port, function() {
	console.log('listening on port ' + port);
});
