


<?php
if (isset($_POST["submit"])) {
$username = htmlspecialchars($_POST['username']);
$displayName = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$DOB = htmlspecialchars($_POST['dob']);
$About = htmlspecialchars($_POST['about']);

$tablename = "users";
$dbname = "ProfileInfo.db";


try{
    //open database if it exists otherwise create one
   $db = new \PDO('sqlite:'. $dbname);

   $db->exec(
    "CREATE TABLE IF NOT EXISTS users (
        username TEXT PRIMARY KEY,
        displayName TEXT, 
        email TEXT,
        DOB TEXT, 
        About TEXT)"
    );

    //Check if user exists
    $select = "SELECT * from " .$tablename . " WHERE username=:username";
    $stmt = $db->prepare($select);
    $stmt->execute(array(':username'=>$username));
    $result = $stmt->fetchAll();


    //If user exists
    if (count($result) > 0) {
       
        //Update Data

        
        $stmt->closeCursor();
        $insert = "UPDATE " . $tablename . " SET displayName =:displayName, " . "  email =:email, " .  "DOB =:DOB, " . "About=:About " . "WHERE username=:username";
        $stmt = $db->prepare($insert);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':displayName', $displayName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':DOB', $DOB);
        $stmt->bindParam(':About', $About);
        $stmt->execute();
        $stmt->closeCursor();
    } else {
       
    
    //If user info doesnt exist, create it
    $stmt->closeCursor();


    $insert = "INSERT INTO " . $tablename . " (username, displayName, email, DOB, About) VALUES (:username, :displayName, :email, :DOB, :About)";
    $stmt = $db->prepare($insert);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':displayName', $displayName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':DOB', $DOB);
    $stmt->bindParam(':About', $About);
   $stmt->execute();
   $stmt->closeCursor();
    
    }

    
  
} catch(PDOException $e) {
    echo $e->getMessage();
}


echo  '<html>
<div class = header>
  <h1> <strong> Kyros </strong></h1>
</div>  
   <div class="body">
      <div class = "Topbar">
      <button class="home">Home</button>
      </div>
      <div>
      <br>
        <form method="POST"  action = "SearchUser.php">
         <button>back</button><br>
        </form>

           
           <form method="POST"  action = "Viewprof.php">
             <input name= "username" value = "'. $username . '" type="text"  class="search" readonly>
            <button type = "submit" name = "submit" class="Save">View Profile</button><br>
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

</html>';
}
//Test
//addInfo("test.db", "users", "Justin", "jwcappie@wfwfewefwvdfe", "10/23/96", "hi");
// var_dump(getInfo("Justin"));
?>