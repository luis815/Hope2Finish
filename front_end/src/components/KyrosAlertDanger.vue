<template>
    <div id="kyros-alert-danger" class="container fixed-bottom">
        <div class="alert alert-danger" role="alert"> {{msg}}</div>
    </div>
</template>

<script>
    export default {
        name: "KyrosAlertDanger",
        props: ['msg']
    }
</script>

<style scoped>
    #kyros-alert-danger {

    }
</style>