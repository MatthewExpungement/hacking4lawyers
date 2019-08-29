<?php
include 'sql.php';

if(isset($_COOKIE['username'])){
    //User account details.
    //print_r($_COOKIE);
//Session/Cookie Highjacking by entering another user's username.
//SQL Injection testuser' OR '1'='1

//This gets all the usernames and emails
//SELECT username,email FROM `users` WHERE username = '1' OR 1=1 UNION ALL SELECT username, email FROM users WHERE '1'='1
//SELECT username,email FROM `users` WHERE usernae = '1' or 1=1 UNION ALL SELECT username, password as email FROM users WHERE '1'1 = '1
    $sql = $connection->query("SELECT username, email FROM users WHERE username = '". $_COOKIE['username'] . "'");
    //printf("Error message: %s\n", $connection->error);
    $fullarray = $sql->fetch_all(MYSQLI_ASSOC);
    foreach($fullarray as $user){
        echo "<p>Username: " . $user['username'] . "</p>";
        echo "<p>Password: " . $user['password']. "</p>";
        echo "<p>Email: " . $user['email'] . "</p>";
    }
    //echo json_encode($fullarray);
}else{
    header('Location: /create.php');
}
?>