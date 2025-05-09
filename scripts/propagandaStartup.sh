#This is the script I use on our Raspberry Pi devices running LXDE and Chromium.  It may or may not work right out of the box on whatever you're running.

#Disable DPMS.
xset -dpms
xset s off
xset s noblank

#Clean up stuff
rm /home/pi/.config/chromium/SingletonLock
killall -TERM chromium-browser 2>/dev/null;
sleep 2;
killall -9 chromium-browser 2>/dev/null;

#Launch propaganda in chromium
chromium-browser --kiosk --noerrdialogs --disable-translateb --ignore-certificate-errors --app=https://[your webserver address]/propaganda/index.php?channelID=[channel ID you want displayed]
