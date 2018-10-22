
<?php
if (isset($_POST["submit"])) {
    $username = htmlspecialchars($_POST['username']);
    
    
// error_reporting(E_ALL);
// ini_set('display_errors', 1);


$dob ="";
$displayName = "";
$About ="";
$email = "";
$tablename = "users";
$dbname = "ProfileInfo.db";
try{
    $db = new \PDO('sqlite:'. $dbname);

    $select = "SELECT username, displayName, email, DOB, About FROM " .$tablename . " WHERE username=:username;";
    $stmt = $db->prepare($select);
    $stmt->bindParam(':username', $username);
     $stmt->execute();
    $data = [];

    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
        
   
            $displayName = $row['displayName'];
            $email  = $row['email'];
            $dob = $row['DOB'];
            $About = $row['About'];
        
    }
    } catch(PDOException $e) {
    echo $e->getMessage();
     }
    if($email == "")
    {
        echo '<html>

        <div>
           <h1> Kyros</h1> 
         <div class="body">
        This User Does Not Exist
         
         <form method="POST"  action="SearchUser.php">
         <button type = "home"  class="home">Back</button><br>
         </form>
         </div>

        </div>
         </html>';

    }
    else
    {
 
  echo '<html>

<div>
    <div class = header>
     <h1> <strong> Kyros </strong></h1>
    </div>  
    <div class="body">
        
        <div class = "Topbar">  
            <form method="POST"  action="SearchUser.php">
            <button type = "back"  class="home" name= "back">Back</button><br>
            <label class= "user"> '. $username . ' </div>
            </form>
            
        </div>
        
        <br>

        <div class="row">
            <div class="side">
                <h2>' . $displayName . '</h2>
                <h3> email: ' . $email . '</h3>
                <h3> Birthday: ' . $dob . '</h3>
                <h5>Profile pic:</h5>
                <div class="profpic" style="height:200px;"><img src="Profpic.png" class="prof"></div>
                <h3>About me</h3>
                <p> ' .  $About  . ' </p>
                <button class="profed">edit</button>
            </div>

            <div class="main">
                <h5>Video uploads:</h5>
                <div>
                    <br>
                    <br>
                    <br>
                </div>
                <h5>Video favorites:</h5>
            
            </div>
        </div>
    </div>
</div>
      
 

  <style scoped>
  .home {
    background-color: rgba(0, 119, 255, 0.712);
    border: solid;
    color: black;
    text-align: center;
    font-size: 20px;
    cursor: pointer;
    margin: 10 7;
    float: left;
    
    
  
  }
  .user{
    text-align: center;
    font-size: 25px;
    float: center;
    
    margin: 7 0;

    }
  .home:hover {
  
    background-color: cadetblue;
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
      height: 80%;
  }
  
  .main {   
      flex: 70%;
      background-color: white;
      padding: 20px;
  }
  
  
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

  .body {
    margin: 0;
    padding: 0;
    text-align: center;
  }
  </style>
  </html>';
}
}
?>




