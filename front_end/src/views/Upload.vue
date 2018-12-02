<template>
    <iframe src="https://cse442.dbmxpca.com/upload.php" frameborder="0"></iframe>
</template>

<script>
    import {mapState} from 'vuex'
    export default {
        name: "Upload",
        computed: {
            ...mapState(['user'])
        },
        created() {
            if(this.user.username === undefined) {
                this.$router.push('/login');
            }
        }
    }
</script>

<style scoped>
    iframe {
        height: 99%;
        overflow: hidden;
        width: 100%;
    }
</style>