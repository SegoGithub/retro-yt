const app = require('express')();
const cors = require('cors');
const fs = require('fs');
const fsextra = require('fs-extra')
const axios = require('axios');
const download = require('download');
const { FFmpegCommand, FFmpegInput, FFmpegOutput } = require('fessonia')();

const PORT = process.env.RETRO_YT_API_PORT;

app.use(cors());
app.set('json spaces', 0);
app.use('/vid', require('express').static('vid'))
app.listen(
  PORT,
  () => console.log(`RetroYT API is running on ${PORT}`)
)

app.get('/video/:vid', (req, res) => {
  const { vid } = req.params;
  axios.get(`https://vid.priv.au/api/v1/videos/${vid}?fields=title,description,viewCount,likeCount,author,authorId,subCountText,formatStreams`)
    .then(data => {

      axios.get(`https://returnyoutubedislikeapi.com/votes?videoId=${vid}`)
        .then(dislikes => {
          let width = data.data.formatStreams[1].size.split('x')[0];
          let height = data.data.formatStreams[1].size.split('x')[1];
          if (fs.existsSync(`./vid/${vid}/videoplayback.flv`) && fs.existsSync(`./vid/${vid}/videoplayback.wmv`)) {
            res.json({
              title: data.data.title,
              desc: data.data.description,
              views: data.data.viewCount,
              likes: data.data.likeCount,
              dislikes: dislikes.data.dislikes,
              channel: data.data.author,
              channelID: data.data.authorId,
              subs: data.data.subCountText,
              width: width,
              height: height,
            })
          } else {
              download(data.data.formatStreams[1].url, `./vid/${vid}`)
                .then(() => {
                  let cmd = new FFmpegCommand();
                  cmd.addInput(new FFmpegInput(`./vid/${vid}/videoplayback.mp4`));
                  cmd.addOutput(new FFmpegOutput(`./vid/${vid}/videoplayback.flv`));
                  cmd.addOutput(new FFmpegOutput(`./vid/${vid}/videoplayback.wmv`));
                  cmd.spawn();
                  cmd.on('success', () => {
                    fsextra.removeSync(`./vid/${vid}/videoplayback.mp4`)
                    res.json({
                      title: data.data.title,
                      desc: data.data.description,
                      views: data.data.viewCount,
                      likes: data.data.likeCount,
                      dislikes: dislikes.data.dislikes,
                      channel: data.data.author,
                      channelID: data.data.authorId,
                      subs: data.data.subCountText,
                      width: width,
                      height: height,
                    })
                  });

                });
            }
          }

        )
    })
    .catch(error => {
      console.log(error.message);
    })
});