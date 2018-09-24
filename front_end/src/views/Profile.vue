<template>
<div>
    
 <div class="body">
     <h1> Kyros</h1>
    <div class = "Topbar">
        <ul>
        <li class="but"><button v-on:click="home" class="home">Home</button></li>
        <li class="search"><input type="text" placeholder="Search.." class="sear"></li>
        
        <!-- <li class= "profpic"><img src="@/assets/Profpic.png" class="prof"></li> -->
        </ul>
    </div>

    <div class="row">
  <div class="side">
      <h2>Username</h2>
      <h5>Profile pic:</h5>
      <div class="profpic" style="height:200px;"><img src="@/assets/Profpic.png" class="prof"></div>
      <h3>About me</h3>
      <p>blah blah blah</p>
  </div>
  <div class="main">
      <h5>Video uploads:</h5>
      <div>
          <p></p>
      </div>
      <h5>Video favorites:</h5>
      <div>
          <p></p>
      </div>
  </div>
</div>
  </div>
</div>
    
</template>

<script>
export default {
  name: "Profile",
  methods: {
    home: function(event) {
      event.preventDefault();
      this.$router.push("/home");
    }
  }
};
</script>

<style scoped>
.home {
  background-color: rgba(0, 119, 255, 0.712);
  border: solid;
  color: black;
  text-align: center;
  font-size: 16px;
  cursor: pointer;
}
.home:hover {

    background-color:cadetblue;
}

.prof{
    height: 80%;
    width:  40%;
    border-style: solid;
}

.row {  
    display: flex;
    flex-wrap: wrap;
}

.side {
    flex: 20%;
    background-color: #f1f1f1;
    padding: 20px;
}

.main {   
    flex: 70%;
    background-color: white;
    padding: 20px;
}

.Topbar ul {
  height: 100%;
  width: 100%;
  list-style: none;
  border: solid;
  text-align: center;
  overflow: hidden;
  background-color:aquamarine;
}
.Topbar {
  width: 100%;
  height: 50px;
  list-style: none;
}

.Topbar li {
  float: left;
  display: block;
  text-decoration: none;
  font-weight: bold;
  height: 100%;
  padding: 1px 3px;
 
}

.body {
  margin: 0;
  padding: 0;
  text-align: center;
}
</style>