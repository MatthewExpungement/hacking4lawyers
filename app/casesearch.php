<?php

?>
<html>
<body>

<h2>Case Lookup</h2>

<form method = "GET" action="casepage.php">
  Case Number:<br>
  <input type="text" name="casenumber">
  <br><br>
  <input type="submit" value="Search">
</form> 

<br><br>
<form method = "GET" action="caseresults.php">
  Last Name:<br>
  <input type="text" name="lastname">
  <br>
  <label>Number of Results</label>
    <select name="limit">
      <option value = "5">5</option>
      <option value = "10">10</option>
    </select>
  <br><br>
  <input type="submit" value="Search">
</form> 


<p>Click search to search the case number."</p>

</body>
</html>
