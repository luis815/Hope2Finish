<?php




echo '<html>
<div class = header>
  <h1> <strong> Kyros </strong></h1>
</div>  
   <div class="body">
      <div class = "Topbar">
      <button class="home">Home</button>
      </div>
      <div>
      <br>
        <form method="POST"  action="CreateProf.php">
         <button type = "create" class="create" name= "create">Create New User</button><br>
        </form>

           
           <form method="POST"  action="Viewprof.php">
             <input name= "username" type="text" placeholder="Search User.." class="search">
            <button type = "submit" name = "submit" class="Save">Search</button><br>
           </form>
      </div>  
    </div>


 <style scoped>

.Topbar {
  width: 100%;
  height: 6%;
  border: solid;
  text-align: center;
  overflow: hidden;
  background-color:aquamarine;
}


.header{
  height: 8%;
  text-align: center;
 
}

.home {
  background-color: rgba(0, 119, 255, 0.712);
  border: solid;
  color: black;
  text-align: center;
  font-size: 20px;
  cursor: pointer;
  margin: 10 7;
  float: left;
  display: inline-block;

}
.home:hover {

  background-color: cadetblue;
}
</style>

</html>'
      ?>