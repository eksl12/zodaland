var express = require('express');
var request = require('request');

var app = express();
var port = 9000;

app.get('/node', function(req, res) {
	res.send('hello world');
	console.log('listening!');
});

app.get('/', function(req, res) {
	res.send('hello empty');
});

app.get('/java', function(req, res) {
	var spr_res = "";

	request.post({
		headers: {'content-type': 'application/json'},
		url: 'http://zodaland:9002/test',
		body: {'test': 'hello', 'test2': 'world'},
		json: true
	}, function(error, res, body) {
		//res.json(body);
		spr_res = body;
	});
	res.send(spr_res + "good");

});

app.listen(port, function() {
	console.log('listening on port ' + port);
});
