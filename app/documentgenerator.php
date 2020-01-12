<?php
require('header.html');
?>
<div class='container'>
  <div class="row text-center">
    <div class="col-lg-8 mx-auto">
      <h1 class='text-primary'>Document Generator</h1>
      <br>
      <p>Automating the creation of documents in your cases can be very useful, but be careful how you manage information relating to clients.</p>
    </div>
  </div>
</div>
<div class="container">
<?php 
    if (!isset($_POST['petitiondata'])) {
     ?>   

      <div class="row">
        <div class="col-lg-8 mx-auto">
          <div class="form-group">
            <h2> Create your super secret petition </h2>
            <form method = "POST" action="documentgenerator.php">
              <label for "filename">File name</label><br>
              <input type="text" name="filename" id="filename" value="Example.txt" class="form-control"><br> 
              <label for "petitiondata">Petition:</label><br>
              <textarea id="petitiondata" rows=10 name="petitiondata" class="form-control"> 
                Dear [client name]:

                    I wish to share a very important secret with you. The secret is: 

                    ________________            

              </textarea>
              <small id="emailHelp" class="form-text text-muted">You might include very personal information about a client in a petition to a court.</small>
              <br><br>
              <button type="submit" class="btn btn-primary">Generate</button>
            </form>
          </div>
      </div>
</div>
    <?php 
    } else {
        file_put_contents("docs/" . $_POST['filename'], $_POST['petitiondata']);
        ?> 
        <div class="row">
          <div class="col-lg-8 mx-auto">        
            Your document has been created. You can access it <a href="docs/<?php print($_POST['filename']);?>"> here. </a>
          </div>
        </div>
    <?php } ?>
