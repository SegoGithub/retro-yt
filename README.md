# Retro YT
A YouTube client for Flash, built for compatibility

## Who is this for?
This is intended for devices that have Flash pre-installed (example: Nokia [C7-OO](https://en.wikipedia.org/wiki/Nokia_C7-00)) but can also be used on other devices.

## Compatibility
* Flash 9
* ~~Flash 6~~ (in later versions)

## Tested on:
* Nokia C7-00, Default Web Browser, Flash Lite 4 (stuttering)
* Windows 2000, Firefox 10.0.9 ESR, Adobe Flash 9
* Windows 2000, Internet Explorer 5, Adobe Flash 9 (video is very small)

## How does this work?
There are 2 components, the API and the front-end.
The API fetches video information from Invidious and Return YouTube Dislikes and downloads the video and converts the video from MP4 -> FLV (FLV is the most compatible Flash video format)

The front-end is very simple, it fetches the data from the API (video stats) and displays the video. 

## How to run
### NOTE: this project was made to be run locally
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
node .
```
#### Run the front-end
```bash
cd web
php -S YOURLOCALIP:8000 # replace YOURLOCALIP with your local ip
```
