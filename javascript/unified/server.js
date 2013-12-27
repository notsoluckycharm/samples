'use strict';

// Module dependencies.
var express = require('express'),  
    path = require('path'),
    fs = require('fs');

var app = express();

// Connect to database
var db = require('./lib/db/mongo');

// Bootstrap models
var modelsPath = path.join(__dirname, 'lib/models');
fs.readdirSync(modelsPath).forEach(function (file) {
  require(modelsPath + '/' + file);
});

// Express Configuration
require('./lib/config/express')(app);

app.configure(function(){
  app.set('config', require('konphyg')(__dirname + '/config') );
});

// Controllers
var api = require('./lib/controllers/api'),
    index = require('./lib/controllers');

// Server Routes
app.get('/api/awesomeThings', api.getPosts);

// Angular Routes
app.get('/partials/*', index.partials);
app.get('/*', index.index);

// Start server
var port = process.env.PORT || 3000;
app.listen(port, function () {
  console.log('Express server listening on port %d in %s mode', port, app.get('env'));
});

//var twitter = require('twit');
//  var T = new twitter()
//
//  var stream = T.stream('statuses/filter', { track: 'test' });
//
//  stream.on('tweet', function (tweet) {
//    console.log(tweet);
//  });
//
//  stream.on('disconnect',function(disconnectMessage){
//    stream.stop();
//  });

// Expose app
exports = module.exports = app;