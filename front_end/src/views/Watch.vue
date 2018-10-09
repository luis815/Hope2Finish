<template>
    <div id="watch" class="bg-dark">
        <div id="player-container">
            <div class="container">
                <video id="player" class="video-js" controls preload="auto" height="240px">
                    <source src="http://clips.vorwaerts-gmbh.de/VfE_html5.mp4"/>
                    <p class="vjs-no-js">
                        To view this video please enable JavaScript, and consider upgrading to a
                        web browser that
                        <a href="http://videojs.com/html5-video-support/" target="_blank">
                            supports HTML5 video
                        </a>
                    </p>
                </video>
            </div>
        </div>
    </div>
</template>

<script>
    import videojs from 'video.js'

    export default {
        name: "Watch",
        mounted() {
            let options = {fluid: true};
            let player = videojs('player', options);
            player.on('ended', function () {
                videojs.log('Done playing.');
            })

        }
    }
</script>

<style scoped>
    #watch {
        height: 100%;
        overflow: scroll;
    }
    #player-container {
        background: black;
    }
</style>