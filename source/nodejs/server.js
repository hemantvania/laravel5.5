var env = require('node-env-file');
env('../.env');
//require modules
var express = require('express');
var app     = express();
var http    = require('http').Server(app);
var socket  = require('socket.io')(http);
var Redis   = require('ioredis');
//var redis   = new Redis(6379, '10.0.3.150');
var redis   = new Redis(process.env.REDIS_PORT, process.env.REDIS_HOST);
//subscribe to test-channel on redis
redis.psubscribe('vdesk-channel','vdesk-chat*','vdesk-thread:*','vdesk-class:*','vdesk-userlogin','vdesk-userlogout','vdesk-share:*','vdesk-student-lock:*', function(error, count){
	//console.log('Connection: ' + count);
});

//configuration
var port = process.env.PORT || 8122;
socket.on('connection', function (io) {
	console.log('New user connected, Id :- ' + io.id);
    // we tell the client to execute 'new message'
});


redis.on('pmessage', function(subscribed,channel, message){
	console.log('Message received: ' + message);
	message = JSON.parse(message);
	socket.emit(channel + ':' + message.event, message.data);
});

http.listen(port, function(){
	console.log('Server running on port: ' + port);
});


