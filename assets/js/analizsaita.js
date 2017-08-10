'use strict';
var request = require('request');
var iconv  = require('iconv-lite');
var unique = require('uniq');

var opt = {
    url: 'http://analizsaita.com/',
    encoding: null
}

request(opt, function (err, res, body) {
    if (err) throw err;
   	document.getElementById("host").value("qwe");
});