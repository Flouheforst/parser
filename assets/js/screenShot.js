"use strict";
(function(){
	var system = require('system');
	var webshot = require("webshot");

	var  randWD = function(n){  // [ 2 ] random words and digits
	  return Math.random().toString(36).slice(2, 2 + Math.max(1, Math.min(n, 30)) );
	}

	var screenShot = {
		site : process.argv[2],
		width : process.argv[3],
		height : process.argv[4],
		rand : randWD(30)
	}

	var name = screenShot.site + screenShot.width + "X" + screenShot.height + screenShot.rand + ".jpg";
	var url = "../../assets/img/" + name;

	var option = {
		streamType : "jpg",
		windowSize: {
			width : screenShot.width,
			height : screenShot.height
		},

		shotSize: {
			width : screenShot.width,
			height : screenShot.height
		}
	};

	webshot(screenShot.site, url, option, (err) => {
		if (err) {
			return console.log(err);
		}
		
		console.log(url);
	});
	
})();