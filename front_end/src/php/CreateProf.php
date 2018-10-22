<?php


//     function addInfo($username, $email, $DOB, $About)
//     {
//          $tablename = "users";
//           $dbname = "test.db";


//         try{
//     //open database if it exists otherwise create one
//    $db = new \PDO('sqlite:'. $dbname);

//    $db->exec(
//     "CREATE TABLE IF NOT EXISTS users (
//         username TEXT PRIMARY KEY, 
//         email TEXT,
//         DOB TEXT, 
//         About TEXT)"
//     );

//     //Check if user exists
//     $select = "SELECT * from " .$tablename . " WHERE username=:username";
//     $stmt = $db->prepare($select);
//     $stmt->execute(array(':username'=>$username));
//     $result = $stmt->fetchAll();


//     //If user exists
//     if (count($result) > 0) {
       
//         //Update Data

//         echo 'Exists';
//         $stmt->closeCursor();
//         $insert = "UPDATE " . $tablename . " SET email =:email, " .  "DOB =:DOB, " . "About=:About " . "WHERE username=:username";
//         $stmt = $db->prepare($insert);
//         $stmt->bindParam(':username', $username);
//         $stmt->bindParam(':email', $email);
//         $stmt->bindParam(':DOB', $DOB);
//         $stmt->bindParam(':About', $About);
//         $stmt->execute();
//     } else {
//         echo 'Does not exist';
    
//     //If user info doesnt exist, create it
//     $stmt->closeCursor();


//     $insert = "INSERT INTO " . $tablename . " (username, email, DOB, About) VALUES (:username, :email, :DOB, :About)";
//     $stmt = $db->prepare($insert);
//     var_dump($stmt);
//     $stmt->bindParam(':username', $username);
//     $stmt->bindParam(':email', $email);
//     $stmt->bindParam(':DOB', $DOB);
//     $stmt->bindParam(':About', $About);
//    $stmt->execute();
    
//     }
  
// } catch(PDOException $e) {
//     echo $e->getMessage();
// }
// }
// }
if (isset($_POST["create"])) {
echo '

<html>
<div class = header>
<h1> <strong> Kyros </strong></h1>
</div>   
    <div class="body">
  
    <div class = "Topbar">  
            <button type = "back" action="SearchUser.php" class="home" name= "back">Back</button>
        </div>
        
        <br>

    <div>
        <form method="POST" action= "ProfileSubmit.php">
            <fieldset>
                <legend><h3>Personal Info:</h3></legend>
                <label class = "infield">Username:</label> <input type="text" name = "username"><br>
                <label class = "infield">Name:</label> <input type="text" name = "name"><br>
                <label class = "infield">Email:</label> <input name = "email" id = "email" type="text"><br>
                <label class = "infield">Date of birth:</label> <input type="text" name = "dob"><br>
                <label class = "infield">About me: </label><br>
                <textarea rows="4" cols="50" input type="text" name = "about"></textarea><br>
                <button type = "submit" name = "submit" class="Save">Save</button><br>
            </fieldset>
        </form>
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
    display: inline-block;
  
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



</style>
</html>';
}
?>