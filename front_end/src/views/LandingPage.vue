<template>
<body style="background-color:grey;">
<font color="50c878">
    <div id="LandingPage">
        <center><h1>Kyros</h1></center>
        <center><p>Kyros a unique content creator oriented platform</p></center>
        <div id="nav">
            <center><router-link to="/login">login</router-link></center>
            <center><router-link to="/signup">register</router-link></center>
        </div>
        <form>
        <center>
  		User name:<br>
  		<input type="text" name="Username"><br>
  		Password:<br>
  		<input type="text" name="password">
  		<p>
  		<A HREF="https://www.youtube.com/" style="color: #50c878">New User?</A>
  		</p>
		</center>
		</form>
    </div>
</font>
</body>
</template>

<script>
    export default {
        name: "LandingPage"
    }
</script>

<style scoped>
    #LandingPage {


    }

    #nav {
        background: whitesmoke;
    }
</style>