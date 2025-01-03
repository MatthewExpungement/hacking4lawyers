<?php
include 'sql.php';
include "resources/sql_header.html";

$error = ''; // Placeholder for error messages

// Check the connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>
<div class='container'>
<h1 class='text-primary text-center'>SQL Executor</h1>
<form action="" method="post" onsubmit="document.getElementById('hidden-sql').value = editor.getValue();">
    <input type="hidden" name="sql" id="hidden-sql">
    <div class="form-group">
        <label for="sql">SQL Command:</label>
        <div id="sql-editor"></div>

    </div>
    <button type="submit" class="btn btn-primary">Execute</button>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sql'])) {
    $sql = $_POST['sql'];
    $result = $connection->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            echo '<div class="alert alert-success">Results:</div>';
            echo '<table class="table table-bordered">';
            
            // Display headers
            $fields = $result->fetch_fields();
            echo '<thead class="thead-dark"><tr>';
            foreach ($fields as $field) {
                echo "<th>" . htmlspecialchars($field->name) . "</th>";
            }
            echo '</tr></thead>';

            // Display rows
            echo '<tbody>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                foreach ($fields as $field) {
                    echo "<td>" . htmlspecialchars($row[$field->name]) . "</td>";
                }
                echo '</tr>';
            }
            echo '</tbody></table>';
        } else {
            echo '<div class="alert alert-warning">Query successful but returned 0 results.</div>';
        }
    } else {
        // Display the actual SQL error to the user
        $error = $connection->error;
        echo '<div class="alert alert-danger">Error executing query: ' . htmlspecialchars($error) . '</div>';
    }
}

$connection->close();
?>
</div>
<script>
    var editor = CodeMirror(document.getElementById("sql-editor"), {
        mode: "text/x-mysql",
        theme: "default",
        lineNumbers: true,
        value: `<?php echo isset($_POST['sql']) ? html_entity_decode(htmlspecialchars($_POST['sql'])) : ''; ?>` 

    });
</script>
<?php
require "../resources/footer.html";
?>