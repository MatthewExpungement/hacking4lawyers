<?php
if(isset($_POST['username'])){
    $connection = new mysqli('localhost', 'root', '','websitedata') or die("Can't connect to server. Please check credentials and try again");
    if ($connection->connect_errno) {
        echo "Failed to connect to MySQL: " . $connection->connect_error;
        die();
    }
    $sql = "INSERT INTO users (username,password,email) VALUES('" . $_POST['username'] . "','" . $_POST['password'] . "','" . $_POST['email'] . "')";

    if ($connection->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}else{
  echo '<form method="post" action="create.php">
  Username:<br>
  <input type="text" name="username" value="">
  <br>
  Password:<br>
  <input type="text" name="password" value="">
  <br>
  Email:<br>
  <input type="text" name="email" value="">
  <br><br>
  <input type="submit" value="Submit">
</form>';
}
?>