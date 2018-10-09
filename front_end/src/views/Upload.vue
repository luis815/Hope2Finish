<template>
    <div>
        <h1>
            Kyros
        </h1>
        <form action="" method='post' enctype="multipart/form-data">
            <input type="file" name="file"/><br><br>
            <input type="text" placeholder="Title"><br><br>
            <textarea input type="text" placeholder="Description" rows="4" cols="50"></textarea><br><br>
            <input type="submit" value="Upload"/>
        </form>
    </div>
</template>

<script>
    export default {
        name: "Upload"
    }
</script>

<style scoped>
    body {
        text-align: center;
    }
    p {
        font-size: 20px;
    }
    .topnav input[type=text] {
        padding: 6px;
        border: solid;
        margin-bottom: 16px;
        font-size: 17px;
        width: 35%;
    }
</style>