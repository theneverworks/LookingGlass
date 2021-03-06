# LookingGlass
A simple HTML / CSS and/or PHP, grid template for smart mirrors. This plain black back ground, nine (9) grid template is intended for the maker that may not be a JavaScript developer.  This simple page refreshes itself, but could be more real time with JavaScript and some web workers.  That is not the intent here.

This simple dash page is intended to be ran on a Raspberry Pi but could be used most anywhere.  These instructions are not intended to support every situation.  They should be enough to get you started though.

## Raspberry Pi & Linux

Assuming you have a fresh running Raspberry Pi and can SSH into it from a command line, proceed with the steps below.  If you do not have a running Raspberry Pi.  Might I suggest PiBakery.  http://www.pibakery.org/

Let's update the operating system.
```bash
sudo apt-get update
sudo apt-get upgrade
```
### Install supporting software
```bash
sudo apt-get install apache2 -y
sudo apt-get install php libapache2-mod-php -y
sudo apt-get install php7.0-curl
sudo apt-get install chromium-browser
sudo apt-get install ttf-mscorefonts-installer unclutter x11-xserver-utils
```
### Configuring the Raspberry Pi to stay awake and start the Looking Glass
```bash
cd .config/lxsession/LXDE-pi/
sudo nano autostart
```
```
@lxpanel --profile LXDE-pi
@pcmanfm --desktop --profile LXDE-pi
@xscreensaver -no-splash
@point-rpi
@/usr/bin/chromium-browser --start-fullscreen --incognito --disable-session-craon-crashed-bubble --disable-infobars http://localhost/lookingglass.php
```
```bash
sudo nano /etc/xdg/lxsession/LXDE/autostart
```
```
@lxpanel --profile LXDE
@pcmanfm --desktop --profile LXDE
#@xscreensaver -no-splash
@xset s off
@xset -dpms
```
```bash
sudo nano /etc/lightdm/lightdm.con
```

Add - ```xserver-command=X -s 0 dpms``` under ```[Seat:*]```

Place lookingglass.php or lookingglass.html in this folder.

```bash
cd /var/www/html
```

Reboot

```bash
shutdown
```
