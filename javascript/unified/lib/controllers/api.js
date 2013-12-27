'use strict';

var twitter = require('twit'),
    mongoose = require('mongoose'),
    Thing = mongoose.model('Thing'),
    async = require('async');

exports.getPosts = function(req, res) {

  var T = new twitter(req.app.get( 'config' ).all().twitter);

  var stream = T.stream('statuses/filter', { track: 'test' });

  stream.on('tweet', function (tweet) {
    console.log(tweet);
  });

  stream.on('disconnect',function(disconnectMessage){
    stream.stop();
  });

  return Thing.find(function (err, things) {
    if (!err) {
      return res.json(things);
    } else {
      return res.send(err);
    }
  });
};

exports.awesomeThings = function(req, res) {
  return Thing.find(function (err, things) {
    if (!err) {
      return res.json(things);
    } else {
      return res.send(err);
    }
  });
};
