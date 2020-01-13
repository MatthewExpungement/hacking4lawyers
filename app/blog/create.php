<?php
require "../sql.php";
if(isset($_COOKIE['username'])){
    header("Location: index.php");
}

if(isset($_POST['username'])){
    $sql = "INSERT INTO users (username,password,email) VALUES('" . $_POST['username'] . "','" . md5($_POST['password']) . "','" . $_POST['email'] . "')";
    if ($connection->query($sql) === TRUE) {
        setcookie("username",$_POST['username']);
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}else{
    require "../resources/header.html";
  echo '  <header class="bg-primary text-white">
  <div class="container text-center">
    <h1>Create an Account</h1>
  </div>
</header>
  <div class="container">
      <div class="row">
        <div class="col-lg-6 mx-auto">
          <div class="form-group">
          </br>
            <form method="post" action="create.php">
              <label for="username">Username:</label><br>
              <input type="text" id="username" name="username" class="form-control">
              <br>
              <label for="password">Password:</label><br>
              <input type="text" id="password" name="password" class="form-control">
              <br>
              <label for="email">Email:</label><br>
              <input type="text" id="email" name="email" class="form-control">
              <br><br>
              <button id="create" type="submit" class="btn btn-primary">Create</button>
            </form>
          </div>
        </div>
        <div class="col-lg-6 mx-auto">
        </br>
          <button class="btn btn-primary" data-toggle="collapse" data-target="#hackerhelp">Click For Hacker Help</button>
          <div id="hackerhelp" class="collapse">
          </br></br>
          <p class="text-primary font-weight-bold">Bypass JavaScript input validation</p>
          <p class="text-primary">On the user registration page, when the user clicks "Create," an error
          message will appear if the username field is empty, if the password is
          empty, or if the e-mail address is not a valid e-mail address.</p>

          <p class="text-primary">If the user uses "Inspect" to look at the "Create" button, he or she
          will see that there is an "event" attached to the button, and the
          button has the id `create`.  The user can also see from the page
          source that the site uses JQuery.</p>

          <p class="text-primary">To get around client-side input validation, enter the following into
          the JavaScript Console.</p>

        
          $("#create").off();
        
          </br></br>
          <p class="text-primary">Then click the "Create" button.</p>
          
          </div>
        </div>
      </div>
    </div>';
}
require "../resources/footer.html";
?>
