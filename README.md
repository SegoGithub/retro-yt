# Retro YT
A YouTube client for Flash, built for compatibility

## Who is this for?
This is intended for devices that have Flash pre-installed (example: Nokia [C7-OO](https://en.wikipedia.org/wiki/Nokia_C7-00)) but can also be used on other devices.
This uses a modified version of play_flv_mini.swf which has the pause button be Space instead of P and removes the Stop function

## Compatibility
* Flash 6+
* Silverlight 2+

## Tested on:
* Nokia C7-00, Default Web Browser, Flash Lite 4 (stuttering)
* Windows 2000, Firefox 10.0.9 ESR, Adobe Flash 9
* Windows 2000, Internet Explorer 5, Adobe Flash 9 (video is very small)

## how this works
video is downloaded and converted into .flv and .wmv
backend acts as a proxy and returns the video information using non-encrypted http

## How to run
### NOTE: im bad at coding so i advise only one device use this at a time 
### Prerequisites:
* php
* php-curl
* node.js

### Once you have the prerequisites
#### Clone the project
```bash
git clone https://github.com/SegoGithub/retro-yt.git
cd retro-yt
```
#### This will need 2 terminals
#### Run the API
```bash
cd api
npm i
npm start
```
#### Run the front-end
```bash
cd web
php -S YOURLOCALIP:YOURPORT # replace YOURLOCALIP and YOURPORT
```
