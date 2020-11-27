# propaganda
propaganda is a not-very-complicated PHP and Javascript web app for informational display screens

# why did I develop this?
I was using the wonderful Concerto digital signage app to run informational screens at my job, but it was total overkill for our simple setup.  Also, I often ran into problems with getting the weather widget to work, getting videos to display, and getting the news ticker going, so I just ended up creating custom iFrames for those things.  I am also not a Ruby-on-Rails guy, so when Concerto had issues, I was often confused.  Finally, Concerto stopped working in updated browsers and I had extreme difficulty updating the stock Concerto VM image to get it going again.

So I dumped it and built propaganda to take its place.

# screenshot
I'm currently using this for the screens at my job.  Here's what it looks like in action:

![screenshot](https://user-images.githubusercontent.com/61878195/99812587-a3a87a80-2b14-11eb-852b-6098c1688f03.jpg)

# requirements
1. A web server that runs PHP7
2. MariaDB / MySQL
3. An OpenWeather API Key (free from openweathermap.org)

# installation
1. Copy everything in the /src directory to your webroot (/var/www/html, c:/inetpub/wwwroot, etc). 
2. Run the SQL script (sql/propaganda.sql) to create the propaganda DB
3. Adjust your webserver to require authentication to use stuff in the management folder.  For example, here's what I added to my apache2 config file so that my users can use their ActiveDirectory login via LDAP:

```
        #Permissions for the propaganda manager -- ya gotta log in
        <Directory "/var/www/html/propaganda/management">
                <Files *.php>
                        Options all
                        Order deny,allow
                        AuthName "Login with your work credentials"
                        AuthType Basic
                        AuthBasicProvider ldap
                        LDAPReferrals Off
                        AuthLDAPUrl ldap://[my domain controller FQDN]/dc=[my domain name],dc=[my domain suffix]?sAMAccountName?sub
                        AuthLDAPBindDN "[a user that can access the domain]@[my domain]"
                        AuthLDAPBindPassword "[that user's password]"
                        AllowOverride None
                        Require valid-user
                </Files>
        </Directory>

```

4. Make sure your webserver allows file uploads.  Check you php.ini to see if file_uploads is on and upload_max_filesize is set to something reasonable.  
5. Allow write access to the propagandaUploads folder.  For example, on my apache2 server, I had to change the owner of propagandaUploads to www-data, so that propagandaUploads now has these permissions:

```
drwxr-xr-x  www-data www-data
```

6. Edit propagandaConfig.php to customize the look and feel and get the weather working
7. Configure your display devices (a Raspberry Pi, for exampe) to load propaganda/propaganda.php in Chrome (I haven't really tested it in other browsers)

# configuring a display device
A Raspberry Pi works great for this.  I have included a script in /scripts that will launch propaganda for you in chromium.  I would recommend setting up your Pi to run this script automatically at login.
