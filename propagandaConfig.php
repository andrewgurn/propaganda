<?php


/****************************
	Look and Feel
****************************/

	//Page background image location
	define("PAGEBACKGROUND", "images/bg.jpg");
	//Company logo at the bottom of the weather div
	define("COMPANYLOGO", "images/logo.png");
	
	
/****************************
	OpenWeather API key
*****************************/	
	//To get one of these, goto openweathermap.org and sign up.  It's free, so long as you don't make more than 60 calls per minute!
	define("OPENWEATHERAPIKEY", "your-key-goes-here");

/****************************
	Content Settings
****************************/

	//Randomize order of the content?
	define("RANDOMIZEDCONTENT", true);
	//How often should we refresh the weather? (ms)
	define("WEATHERREFRESH", 3600000);
	//How often should we refresh the news ticker? (ms)
	define("TICKERREFRESH", 900000);
	//How often should we look in the DB for new content? (ms)
	define("MAINCONTENTREFRESH", 900000);


/****************************
	Security Settings
****************************/
	
	//An array of users allowed to use the upload page
	//Set your webserver up so that propagandaUploader.php requires authentication, whether it be some local user on the webserver, an LDAP user, and AD user, etc
	//These usernames will be compared to what's in $_SERVER['remote_user'] after the user authenticates
	//If you leave this as a blank array, it will be accessible to everybody who can access it
	define("UPLOADERS", array());

?>
