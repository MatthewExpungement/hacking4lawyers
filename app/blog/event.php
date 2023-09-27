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
      <h1>Law Conference Event This Month!</h1>
      <p class="lead">Sign up for tickets today!</p>
 
    </div>
  </header>
  <div class="container">
      <div class="row">
        <div class="col-lg-6 ">
            <?php
            if(isset($_POST['submitted']) == False){
                //Means the form has not been submitted
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                echo "<p class='text-primary'>Hacker Help: Your user agent is <span class='text-dark'>" . $user_agent ."</span> (i.e. Browser)</p>";
                if (stripos($user_agent, 'Firefox') === false) {
                    //Means this is NOT a chrome browser.
                    //This is meant to replicate the AT&T hack by "Weev"
                    echo "<h2 class='text-danger'>This website can only be viewed via the Firefox Browser</h2>";
                }else{
                    //Means this is a chrome browser.
                
                    $email = $first_name = $last_name = ""; //We set these to blank values so we don't have to have to form echo statements.
                    if(isset($_GET['ID'])){
                        //Means this is a unique link.
                        //Get the account information and populate the fields.
                        $sqlquery = "SELECT * FROM users WHERE ID = '". $_GET['ID'] . "'";
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
                        $email = $fullarray['email'];
                        $first_name = $fullarray['first_name'];
                        $last_name = $fullarray['last_name'];
                        }

                    echo '<div class="form-group">
                    <h2> Conference Information </h2>
                    <form method="post" action="event.php">
                    <label for="first_name">First Name:</label><br>
                    <input type="text" id="first_name" name="first_name" value="' . $first_name . '" class="form-control">
                    <br>
                    <label for="last_name">Last Name:</label><br>
                    <input type="text" id="last_name" name="last_name" value="' . $last_name . '" class="form-control">
                    <br>
                    <label for="email">Email:</label><br>
                    <input type="text" id="email" name="email" value="' . $email . '" class="form-control">
                    <br><br>
                    <input  type="hidden" name="submitted" value="true">
                    <button id="create" type="submit" class="btn btn-primary">Sign Up</button>
                    </form>
                </div>';
                }
            }else{
                //For was just submitted.
                echo "<br><br><h2 class='text-success'>Thank you for registering for the conference!</h2>";
            }
            
        ?>
        </div>
</div>