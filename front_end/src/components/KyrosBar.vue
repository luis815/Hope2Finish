<template>
    <nav id="kyros-bar">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <router-link class="navbar-brand" to="/home">Kyros</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/home">Home</router-link>
                    </li>
                     <li class="nav-item">
                        <router-link class="nav-link" to="/upload">Upload</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/profile">{{this.user.username}}</router-link>
                    </li>
                    <li class="nav-item">
                        <a id="logout" class="nav-link" v-on:click="logout">
                            logout
                        </a>
                    </li>
                    <li class="nav-item">
                         <router-link class="nav-link" to="/search">Search</router-link>
                    </li>
                </ul>
            </div>
        </nav>
    </nav>
</template>

<script>
    import {mapState, mapMutations} from 'vuex'
    export default {
        name: "KyrosBar", 
        computed:{
            ...mapState(['user'])
        },
        methods:{
            logout(){
                this.setUser({});
                this.$router.push('/')

            },
            ...mapMutations(['setUser'])
        }
    }
</script>

<style scoped>
    #kyros-bar {


    }
    #logout {
        cursor: pointer;
    }
</style>