
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$username = "Justin";


$tablename = "users";
$dbname = "test.db";
try{
    $db = new \PDO('sqlite:'. $dbname);

    $select = "SELECT username, email, DOB, About FROM " .$tablename . " WHERE username=:username;";
    $stmt = $db->prepare($select);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $data = [];

    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
        
   
            
            $email  = $row['email'];
            $dob = $row['DOB'];
            $About = $row['About'];
        
    }

   

    } catch(PDOException $e) {
    echo $e->getMessage();
  }
 
  echo '<html>

  <div>
     <h1> Kyros</h1> 
   <div class="body">
      <div class = "Topbar">
          <ul>
          <li class="but"><button v-on:click="home" class="home">Home</button></li>
          <li class="search"><input type="text" placeholder="Search.." class="sear"></li>
         
          
          <!-- <li class= "profpic"><img src="@/assets/Profpic.png" class="prof"></li> -->
          </ul>
      </div>
  
      <div class="row">
    <div class="side">
        <h2>' . $username . '</h2>
        
        <h5>Profile pic:</h5>
        <div class="profpic" style="height:200px;"><img src="@/assets/Profpic.png" class="prof"></div>
        <h3>About me</h3>
        <p> ' .  $About  . ' </p>
        <button class="profed">edit</button>
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
      
 
  </body>

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

    color: black;
}

.profed {
 background-color: none;
  border: none;
  color: blue;
  text-align: center;
  font-size: 16px;
  cursor: pointer;
}
.profed:hover {

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
  
}

.Topbar li {
  float: left;
  display:grid;
  text-decoration: none;
  font-weight: bold;
  height: 100%;
  padding-top: 5px;
  padding-bottom: 10px;
  padding-left: 3px;
 
}

.body {
  margin: 0;
  padding: 0;
  text-align: center;
}
</style>
  </html>';
?>




