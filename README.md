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

4. Adjust your webserver to allow people to upload files to the propagandaUploads directory (you may need to change some PHP settings and grant write access to propagandaUploads)
5. Edit propagandaConfig.php to customize the look and feel and get the weather working
6. Configure your display devices (a Raspberry Pi, for exampe) to load propaganda/propaganda.php in Chrome (I haven't really tested it in other browsers)

I think that ought to be it.
