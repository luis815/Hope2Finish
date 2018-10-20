<template>
<div>
    
 <div class="body">
     <h1> Kyros</h1>
    <div class = "Topbar">
        
        <label class="homel"><button v-on:click="home" class="home">Home</button></label>
    </div>

    <div>
        <form method="POST" action= "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
            <fieldset>
                <legend><h3>Personal Info:</h3></legend>
                <label class = "infield">Name:</label> <input type="text"><br>
                <label class = "infield">Email:</label> <input type="text"><br>
                <label class = "infield">Date of birth:</label> <input type="text"><br>
                <label class = "infield">About me: </label><br>
                <textarea rows="4" cols="50"></textarea><input type="text"><br>
                <button type = "submit" class="Save">Save</button><br>
            </fieldset>
        </form>
    </div>
  </div>
</div>
    
</template>

<script>
export default {
  name: "ProfileEditor",
  methods: {
    home: function(event) {
      event.preventDefault();
      this.$router.push("/home");
    }
    // save: function(event) {
    //   event.preventDefault();
    //   this.$router.push("/profile");
    // }
  }     
};
</script>

<style scoped>
.homel{
  float: left;
  padding-top: 5px;
  padding-bottom: 0px;
  padding-left: 3px;
}
.home {
  background-color: rgba(0, 119, 255, 0.712);
  border: solid;
  color: black;
  text-align: center;
  font-size: 16px;
  cursor: pointer;
}
.home:hover {
  background-color: cadetblue;
}

.infield{
    display: inline-block;
    clear: left;
    width: 150px;
    text-align: left;
}
input {
  display: inline-block;
}


.Topbar {
  height: 50px;
  width: 100%;
  border: solid;
  text-align: center;
  overflow: hidden;
  background-color: aquamarine;
}




</style>