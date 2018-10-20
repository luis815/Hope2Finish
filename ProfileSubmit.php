<?php

namespace ProfData;


function getInfo($username)
{

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
        $tasks[] = [
   
            'username' => $row['username'],
            'email' => $row['email'],
            'DOB' => $row['DOB'],
            'About' => $row['About']
        ];
    }

    return $tasks;

    } catch(PDOException $e) {
    echo $e->getMessage();
  }
}




function addInfo($username, $email, $DOB, $About)
{
    $tablename = "users";
    $dbname = "test.db";


try{
    //open database if it exists otherwise create one
   $db = new \PDO('sqlite:'. $dbname);

   $db->exec(
    "CREATE TABLE IF NOT EXISTS users (
        username TEXT PRIMARY KEY, 
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

        echo 'Exists';
        $stmt->closeCursor();
        $insert = "UPDATE " . $tablename . " SET email =:email, " .  "DOB =:DOB, " . "About=:About " . "WHERE username=:username";
        $stmt = $db->prepare($insert);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':DOB', $DOB);
        $stmt->bindParam(':About', $About);
        $stmt->execute();
    } else {
        echo 'Does not exist';
    
    //If user info doesnt exist, create it
    $stmt->closeCursor();


    $insert = "INSERT INTO " . $tablename . " (username, email, DOB, About) VALUES (:username, :email, :DOB, :About)";
    $stmt = $db->prepare($insert);
    var_dump($stmt);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':DOB', $DOB);
    $stmt->bindParam(':About', $About);
   $stmt->execute();
    
    }
  
} catch(PDOException $e) {
    echo $e->getMessage();
}
}
//Test
//addInfo("test.db", "users", "Justin", "jwcappie@wfwfewefwvdfe", "10/23/96", "hi");
//var_dump(getInfo("Justin"));
?>