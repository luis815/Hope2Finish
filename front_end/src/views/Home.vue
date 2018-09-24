<template>
    <div class = "body">
    <h1>
        Kyros
    </h1>
    <div class="topnav">
        <input type="text" placeholder="Search..">
    </div>
        <div class = "rightnav">
            Welcome <router-link to="/profile">KyrosUser!</router-link>
        </div>
    <div class="leftcolDiv">
        <div class="YTvid">
            <iframe width="560" height="349" src="https://www.youtube.com/embed/I7LJIuB2CHE"
                    allowfullscreen></iframe></div>
        <p>Comments</p>
        <p><textarea rows="4" cols="50" name="comment" placeholder="Enter Comment">
        </textarea></p>
    </div>

    <div class="rightcolDiv">
        Recent Uploads
        <div class="innerdiv">
            <iframe src="https://www.youtube.com/embed/ctx4YBEdOxo" allowfullscreen></iframe>
            <iframe src="https://www.youtube.com/embed/vMPR7k9DWlw" allowfullscreen></iframe>
            <iframe src="https://www.youtube.com/embed/u5V_VzRrSBI" allowfullscreen></iframe>
        </div>
    </div>


    </div>
</template>

<script>
    export default {
        name: "Home"
    }
</script>

<style scoped>
    .body {
        text-align: center;
    }
    .leftcolDiv {
        float: left;
        margin: 0 1% 1% 10%;
        padding: 1%;
        width: 39%;
    }
    .rightcolDiv {
        float: right;
        margin: 0% -5% 1% 1%;
        padding: 1%;
        width: 39%;
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
    .rightnav{
        float: right;
        margin-top: -6%;
        margin-right: 1%;
        font-size: 120%;
    }
    .innerdiv {
        border: 5px outset;
        box-shadow : 2px 10px 10px #888888;
        margin: 1% -10% 1% 15%;
        padding: 7%;
        width: 50%
    }
</style>
