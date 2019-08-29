<?php
include 'sql.php';
header("X-XSS-Protection: 0");
if(isset($_POST['blogtitle'])){
    //Means we need to insert 
    $sql = "INSERT INTO blogposts (blogtitle,blogpost,username) VALUES('" . $_POST['blogtitle'] . "','" . $_POST['blogpost'] . "','" . $_COOKIE['username'] . "')";

    if ($connection->query($sql) === TRUE) {
        echo "New blog post created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}
//<script> alert("Hello"); </script>
//Now I need to create a script that says write a post about how great mstubenberg is if one doesn't already exist.
?>
<html>
<head>
</head>
<body>
<?php
if(isset($_COOKIE['username'])){
echo'
<form method=post action="/blog.php">
  Title:<br>
  <input type="text" name="blogtitle" value="">
  <br>
  Post:<br>
  <input type="textarea" name="blogpost" value="">
  <br><br>
  <input type="submit" value="Submit">
</form>';
}
?>
<?php
    $sql = $connection->query("SELECT * FROM blogposts");
    //printf("Error message: %s\n", $connection->error);
    $fullarray = $sql->fetch_all(MYSQLI_ASSOC);
    foreach($fullarray as $blogpost){
        echo("<hr>");
        echo("<h2>" . $blogpost['blogtitle'] . "</h2>");
        echo("<p> User: " . $blogpost['username'] . "</p>");
        echo("<p>" . $blogpost['blogpost'] . "</p>");
    }
?>
</body>
</html>