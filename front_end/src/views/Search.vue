
<template>
<iframe :src="'http://hope2finish.byethost6.com/php/SearchUser.php'" frameborder="0">Search</iframe>
</template>

<script>
    import {mapState} from 'vuex'

    export default {
        name: "Search",
        computed: {
            ...mapState(['user'])
        },
        created() {
            if (this.user.username === undefined) {
                this.$router.push('/login');
            }
        }
    };
</script>

<style scoped>
    iframe {
        height: 98%;
        overflow: hidden;
        width: 100%;
    }
</style>