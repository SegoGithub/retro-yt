const app = require('express')();
const PORT = 8080
const cors = require('cors');
const { response } = require('express');
const fs = require('fs');
const axios = require('axios');
const ytdl = require('ytdl-core');
const { createFFmpeg, fetchFile } = require('@ffmpeg/ffmpeg');
const download = require('download')

app.set('json spaces', 0);
app.use('/vid', require('express').static('vid'))
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
    axios.get(`https://invidio.xamh.de/api/v1/videos/${vid}?fields=title,description,viewCount,likeCount,author,authorId,subCountText,formatStreams`)
    .then(data => {
      axios.get(`https://returnyoutubedislikeapi.com/votes?videoId=${vid}`)
      .then(dislikes => {
        let width = data.data.formatStreams[1].size.split('x')[0];
        let height = data.data.formatStreams[1].size.split('x')[1];
  
        if (fs.existsSync(`./vid/${vid}/videoplayback.flv`)) {
          res.json({
            title: data.data.title,
            desc: data.data.description,
            views: data.data.viewCount,
            likes: data.data.likeCount,
            dislikes: dislikes.data.dislikes, // using Return YouTube Dislikes API in the future
            channel: data.data.author,
            channelID: data.data.authorId,
            subs: data.data.subCountText,
            width: width,
            height: height,
        })
        } else {
          download(data.data.formatStreams[1].url, `./vid/${vid}`)
        .then(() => {
          (async () => {
              ffmpeg.FS('writeFile', `videoplayback.mp4`, await fetchFile(`./vid/${vid}/videoplayback.mp4`));
              await ffmpeg.run('-i', `videoplayback.mp4`, `videoplayback.flv`);
              await fs.promises.writeFile(`./vid/${vid}/videoplayback.flv`, ffmpeg.FS('readFile', `videoplayback.flv`));
              // send json
              res.json({
                title: data.data.title,
                desc: data.data.description,
                views: data.data.viewCount,
                likes: data.data.likeCount,
                dislikes: dislikes.data.dislikes, // using Return YouTube Dislikes API in the future
                channel: data.data.author,
                channelID: data.data.authorId,
                subs: data.data.subCountText,
                width: width,
                height: height,
            })
            })();
        });
        }
        
      })
    })
    .catch(error => {
      console.log(error.message);
    })
});

app.get('/v1/retroyt/dl/:vid', (req, res) => {
    const { vid } = req.params
    res.sendFile(`${__dirname}/${vid}.swf`)
});