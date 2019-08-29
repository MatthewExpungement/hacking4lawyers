<?php
include 'sql.php';
if(isset($_POST['username'])){

$sql = "SELECT * FROM users WHERE username = '" . $_POST['username'] . "'";


$usersql = $connection->query($sql);
$fullarray = $usersql->fetch_all(MYSQLI_ASSOC);
if(count($fullarray)>0){
    if($fullarray[0]['password'] == $_POST['password']){
        echo "Passwords match!";
        setcookie("username",$_POST['username']);
    }else{
        echo "Passwords don't match";
    }
}else{
    print($fullarray);
}
print_r($fullarray);
}else{
  echo '<form method="post" action="login.php">
  Username:<br>
  <input type="text" name="username" value="">
  <br>
  Password:<br>
  <input type="text" name="password" value="">
  <br>
  <input type="submit" value="Submit">
</form>';
}
?>