<template>
    <div id="home" class="text-center text-light bg-dark">
        <KyrosBar/>
        <h1>Kyros</h1>
        <div>
            <input type="text" placeholder="Search..">
        </div>
        <div>
            Welcome KyrosUser!
        </div>
        <h3>
            Subscriptions
        </h3>
        <div class="container">
            <div class="row">
                <div v-for="url in urls" class="col-md">
                    <img v-on:click="onThumbnailClick(url)" class="img-fluid thumbnail"
                         :src="'http://img.youtube.com/vi/' + url + '/maxresdefault.jpg'"/>
                </div>
            </div>
        </div>
        <div id="overlay">
            <div id="modal" class="bg-light">
                <i v-on:click="closeOverlay" id="close" class="far fa-window-close fa-2x"></i>
                <iframe class="youtube" :src="modalSrc" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</template>

<script>
    import KyrosBar from "../components/KyrosBar"
    export default {
        name: "Home",
        components: {KyrosBar},
        data() {
            return {
                urls: ['I7LJIuB2CHE', 'ctx4YBEdOxo', 'vMPR7k9DWlw', 'u5V_VzRrSBI'],
                modalSrc: ''
            }
        },
        methods: {
            onThumbnailClick(/*String*/url) {
                this.modalSrc = 'https://www.youtube.com/embed/' + url;
                $('#overlay').fadeIn(250);
            },
            closeOverlay() {
                $('#overlay').fadeOut(250);
            }
        },
        mounted() {
            $('#overlay').hide();
        }
    }
</script>

<style scoped>
    #home {
        min-height: 100%;
        height: 1px;
        overflow: auto;
    }

    .thumbnail {
        padding-top: 1em;
        padding-bottom: 1em;
    }

    #overlay {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 2;
    }

    #modal {
        width: 90%;
        margin: 100px auto;
        max-width: 800px;
        min-height: 100px;
        position: relative;
        padding: 20px;
        border-radius: 10px;
    }

    .youtube {
        width: 100%;
        height: 400px;
    }

    #close {
        color: #333;
        padding-bottom: 10px;
        float: right;
    }

    #close:hover {
        cursor: pointer;
        color: #555;
    }
</style>
