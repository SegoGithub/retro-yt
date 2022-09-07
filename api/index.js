const app = require('express')();
const PORT = 8080
const cors = require('cors');
const { response } = require('express');
const fs = require('fs');
const axios = require('axios');
const ytdl = require('ytdl-core');
const { createFFmpeg, fetchFile } = require('@ffmpeg/ffmpeg');
const download = require('download')

console.log(__dirname)
const ffmpeg = createFFmpeg({ log: true });
async function load() {
    await ffmpeg.load();
}
load();
app.use(cors());
app.listen(
    PORT,
    () => console.log(`RetroYT API is running on ${PORT}`)
)

app.get('/v1/retroyt/flash/:vid', (req, res) => {
    const { vid } = req.params;
    axios.get(`https://invidio.xamh.de/api/v1/videos/${vid}?fields=formatStreams`)
    .then(data => {
      download(data.data.formatStreams[1].url, `./vid/${vid}`)
      .then(() => {
        (async () => {
            ffmpeg.FS('writeFile', `videoplayback.mp4`, await fetchFile(`./vid/${vid}/videoplayback.mp4`));
            await ffmpeg.run('-i', `videoplayback.mp4`, `videoplayback.flv`);
            await fs.promises.writeFile(`./vid/${vid}/videoplayback.flv`, ffmpeg.FS('readFile', `videoplayback.flv`));
          })();
      });
    })
    .catch(error => {
      console.log(error.message);
    })
});

app.get('/v1/retroyt/dl/:vid', (req, res) => {
    const { vid } = req.params
    res.sendFile(`${__dirname}/${vid}.swf`)
});