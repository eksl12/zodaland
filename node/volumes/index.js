var express = require('express');

var app = express();
var port = 9000;

app.get('/node', function(req, res) {
	res.send('hello world');
	console.log('listening!');
});

app.get('/test', function(req, res) {
	res.send('hello test');
});

app.listen(port, function() {
	console.log('listening on port ' + port);
});
