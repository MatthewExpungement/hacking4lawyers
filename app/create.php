<?php
require "sql.php";
if(isset($_COOKIE['username'])){
    header("Location: blog.php");
}

if(isset($_POST['username'])){
    $sql = "INSERT INTO users (username,password,email) VALUES('" . $_POST['username'] . "','" . $_POST['password'] . "','" . $_POST['email'] . "')";
    if ($connection->query($sql) === TRUE) {
        setcookie("username",$_POST['username']);
        header("Location: blog.php");
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}else{
    require "header.html";
  echo '  <header class="bg-primary text-white">
  <div class="container text-center">
    <h1>Create an Account</h1>
  </div>
</header>
  <div class="container">
      <div class="row">
        <div class="col-lg-10 mx-auto">
        <div class="form-group">
        <form method="post" action="create.php">
        <label for "username">Username:</label><br>
  <input type="text" id="username" name="username" class="form-control">
  <br>
  <label for "password">Password:</label><br>
  <input type="text" id="password" name="password" class="form-control">
  <br>
  <label for "email">Email:</label><br>
  <input type="text" id = "email" name="email" class="form-control">
  <br><br>
  <button type="submit" class="btn btn-primary">Create</button>

</form></div></div></div></div>';
}
require "footer.html";
?>