# propaganda
propaganda is a not-very-complicated PHP and Javascript web app for informational display screens

This is a work in progress.

# screenshot
I'm currently using this for the screens at my job.  Here's what it looks like in action:

![screenshot](https://user-images.githubusercontent.com/61878195/99812587-a3a87a80-2b14-11eb-852b-6098c1688f03.jpg)

# requirements
1. A web server that runs PHP7
2. MariaDB / MySQL
3. An OpenWeather API Key (free from openweathermap.org)

# installation
1. Download everything and stick it in your webroot (/var/www/html, c:/inetpub/wwwroot, etc)
2. Run the SQL script (doesn't exist yet) to create the propaganda DB
3. Adjust your webserver to require authentication to use propagandaUploader.php 
4. Adjust your webserver to allow people to upload files to the propagandaUploads directory (you may need to change some PHP settings and grant write access to propagandaUploads)
5. Edit propagandaConfig.php to customize the look and feel and get the weather working
6. Configure your display devices (a Raspberry Pi, for exampe) to load propaganda/propaganda.php in Chrome (I haven't really tested it in other browsers)

I think that ought to be it.
