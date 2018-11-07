<template>
    <div id="watch" class="bg-dark">
        <kyros-bar/>
        <div id="player-container">
            <div class="container">
                <div class="row">
                    <div class="col"></div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-10">
                        <video id="player" class="video-js" autoplay controls preload="auto" style="min-height: 20em">
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
                    <div class="col"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import videojs from 'video.js'
    import KyrosBar from '../components/KyrosBar.vue'

    export default {
        name: "Watch",
        components: {KyrosBar},
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
        min-height: 100%;
        height: 1px;
        overflow: auto;
    }

    #player-container {
        background: black;
    }
</style>