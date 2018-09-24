<template>
    <div id="LandingPage">
        <ul>
            <li><router-link to="/login">login</router-link></li>
            <li><router-link to="/sigup">signup</router-link></li>
        </ul>
        <div id="welcome">
            <h1>Welcome to Kyros!</h1>
        </div>
    </div>
</template>

<script>
    export default {
        name: "LandingPage"
    }
</script>

<style scoped>
    #LandingPage {

    }

    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #333;
    }

    li {
        float: left;
    }

    li a {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    li a:hover {
        background-color: #111;
    }

    #welcome {
        text-align: center;
        padding-top: 10em;
    }
</style>