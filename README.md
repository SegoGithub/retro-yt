# Retro YT
A YouTube client for Flash and Silverlight cuz why not?

## Who is this for?
This is intended for devices that have Flash pre-installed (example: Nokia [C7-OO](https://en.wikipedia.org/wiki/Nokia_C7-00)) but can also be used on other devices.
This uses a modified version of player_flv_mini.swf which has the pause button set to Space instead of P and removes the Stop function
There is no malware in player_flv_mini.swf
pinkie promise

## Compatibility (not tested yet, but should work with)
* Flash 6+
* Silverlight 2+

## Tested on:
* Nokia C7-00, Default Web Browser, Flash Lite 4 (stuttering)
* Windows 2000, Firefox 10.0.9 ESR, Adobe Flash 9
* Windows 2000, Internet Explorer 5, Adobe Flash 9 (video is very small)

## How this works
video is downloaded and converted into .flv and .wmv
backend acts as a proxy and returns the video information using non-encrypted http

## How to run
### NOTE: im bad at coding so i advise only one device use this at a time
### Prerequisites:
* php
* php-curl
* node.js
* python

### Once you have the prerequisites
#### Clone the project
```bash
git clone https://github.com/SegoGithub/retro-yt.git
cd retro-yt
```
#### Adjust config.ini to match your ip and change the ports if you like
```bash
python start.py
```

shabangalangaloom
its running!

Available arguments for start.py:
* --api-only
* --web-only