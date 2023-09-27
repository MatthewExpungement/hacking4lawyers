<?php

include '../sql.php';
header("X-XSS-Protection: 0");
if(isset($_POST['logout'])){
    unset($_COOKIE['username']);
    setcookie('username', '', time() - 3600);
}
include "../resources/header.html";

?>
  <header class="bg-primary text-white">
    <div class="container text-center">
      <h1>Classified Document Portal</h1>
      <p class="lead"><i class="bi bi-lock"></i>This is the portal to be used by authorized users only.<i class="bi bi-lock"></i></p>
      
 
    </div>
  </header>
  <div class="container">
      <div class="row">
        <div class="col-lg-12 ">
        <h4 class='text-center text-danger'>As policy dictates, you may only download documents on this portal using a web browser.</h4>

        <?php

    $directory = 'classified_documents/';

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
            #header("Location: classified_portal.php");
        }else{
            echo "<h3 class='text-danger text-center'>Passwords don't match</h3>";
        }
    }else{
        echo "<h3 class='text-danger text-center'>Looks like we couldn't find your username.</h3>"; 
    }
}
if(isset($_COOKIE['username']) || $login == True){
    //Means the user is already logged in.
    //Need to show account information
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
    echo "<span class='text-primary font-weight-bold'>Welcome </span><span id='accountinfousername' class='text-primary font-weight-bold'>" . $fullarray['username'] . "</span><br>";
    echo '<div class="form-group">
    <form method = "post" action="classified_portal.php">
    <input id="logout" type="hidden" name="logout" value="true">
    <button type="submit" id="logoutbutton" class="btn btn-primary">Logout</button>
    </form>
    </div>';

    $directory = 'classified_documents/';
    $files = [];
    
    // Open the directory
    if ($handle = opendir($directory)) {
    
        // Loop through each file in the directory
        while (false !== ($file = readdir($handle))) {
    
            // Skip '.' and '..'
            if ($file != '.' && $file != '..') {
                $files[] = $file;
            }
        }
    
        // Close the directory handle
        closedir($handle);
    }
    
    // Custom comparison function to sort by the number at the end of the filename
    function sortByNumber($a, $b) {
        $number1 = (int) filter_var($a, FILTER_SANITIZE_NUMBER_INT);
        $number2 = (int) filter_var($b, FILTER_SANITIZE_NUMBER_INT);
    
        return $number1 - $number2;
    }
    
    // Sort the files
    usort($files, 'sortByNumber');
    
    // Display the sorted files
    foreach ($files as $file) {
        echo "<a href='classified_documents/" . $file . "'>" . $file . "</a><br>";
    }

}else{
    //No login so give the prompts to login.
    echo '<div class="form-group">
            <h2> Please Login </h2>
            <form method = "post" action="classified_portal.php">
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
</div>
</div>
<?php
    require "../resources/footer.html";
    ?>