# propaganda
propaganda is a not-very-complicated PHP and Javascript web app for informational display screens

# v0.9 todo list
- There is no interface for adding a new Channel at the moment.  It'll take me like 5 minutes to do, and yet, I haven't done it.  In the meantime, new Channels will need to be added directly through the DB
- The news ticker uses NewsMax for a source, mainly because they have a functional RSS feed.  At some point I'd like to have this be changeable option via propagandaConfig.php, but if you want to change it now, go have a look in src/propagandaTicker.php and make changes accordingly

# why did I develop this?
I was using the wonderful Concerto digital signage app to run informational screens at my job, but it was total overkill for our simple setup.  Also, I often ran into problems with getting the weather widget to work, getting videos to display, and getting the news ticker going, so I just ended up creating custom iFrames for those things.  I am also not a Ruby-on-Rails guy, so when Concerto had issues, I was often confused.  Finally, Concerto stopped working in updated browsers and I had extreme difficulty updating the stock Concerto VM image to get it going again.

So I dumped it and built propaganda to take its place.

# screenshot
I'm currently using this for the screens at my job.  Here's what it looks like in action:

![screenshot](https://user-images.githubusercontent.com/61878195/99812587-a3a87a80-2b14-11eb-852b-6098c1688f03.jpg)

# requirements
1. A web server that runs PHP7+ (it'll probably run on 5+ but I haven't tested it)
2. MariaDB / MySQL
3. An OpenWeather API Key (free from openweathermap.org)
4. jQuery (currently auto grabs jquery-latest from jquery.com)

# installation
1. Copy everything in the /src directory to your webroot (/var/www/html, c:/inetpub/wwwroot, etc). 
2. Run the SQL script (sql/propaganda.sql) to create the propaganda DB and tables.
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

If your webserver is IIS, you can just set Windows permisssions directly on the propaganda management folder you copied to your webroot.

4. Make sure your webserver allows file uploads.  Check you php.ini to see if file_uploads is on and upload_max_filesize is set to something reasonable.  
5. Allow write access to the propagandaUploads folder.  For example, on my apache2 server, I had to change the owner of propagandaUploads to www-data, so that propagandaUploads now has these permissions:

```
drwxr-xr-x  www-data www-data
```

6. Edit propagandaConfig.php to setup your MariaDB connection stuff, customize the look and feel, and get the weather working
7. Configure your display devices (a Raspberry Pi, for exampe) to load propaganda/propaganda.php in Chromium (I haven't really tested it in other browsers)

# configuring a display device
A Raspberry Pi works great for this, but any PC that can run Chromium would work (or any web browser, but my setup script assumes a Chrome-based browser).  I have included a script in /scripts that will launch propaganda for you in Chromium.  I would recommend setting up your Pi to run this script automatically at login.  

To do this on an LXDE-based Pi, copy the propagandaStartup.sh script to your home directory (or wherever you want it) and make it executable:
        
        sudo chmod +x /home/pi/propagandaStartup.sh

Next:

        sudo nano /etc/xdg/lxsession/LXDE-pi/autostart
 
And then add this above the @xscreensaver line:

        @sh /home/pi/propagandaStartup.sh

NOTE: If Chromium launches with a blank screen, you need to disable hardware acceleration.  Goto Settings > Advanced > System and uncheck "Use hardware acceleration when available".

# more pi stuff
It's a good idea to install unclutter to hide the mouse cursor (X11 only; not sure what the Wayland alternative would be if there is one):

        sudo apt install unclutter

I also use unattended-upgrades because I'd rather things be up-to-date and have a slim possibilty to dying on an update than very-out-of-date:

        sudo apt install unattended-upgrades
        dpkg-reconfigure --priority=low unattended-upgrades

Finally, I add the line below to the root crontab to reboot the pi at midnight:

        0 0 * * * /usr/sbin/reboot
