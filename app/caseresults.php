<?php
require "sql.php";

if(!isset($_GET['lastname'])){
    header("Location: casesearch.php");
}
$sqlquery = "SELECT Case_Number,Case_Type,Plaintiff_Name,Defendant_Name,Hearing_Date FROM casedata
 WHERE Plaintiff_Name LIKE '%". $_GET['lastname'] . "%' OR Defendant_Name LIKE '%" . $_GET['lastname'] . "%' LIMIT " . $_GET['limit'];

    try{
        $sql = $connection->query($sqlquery);
        if($sql == FALSE){
            printf("Connect failed: %s\n", $connection->error);
        }else{
            
            $fullarray = $sql->fetch_all(MYSQLI_ASSOC);
            foreach($fullarray as $case){
                print_r($case);
            }
        }
    }catch(Exception $e){
            echo "Error";
            printf("Connect failed: %s\n", $connection->error);
            print_r($e);
    }
?>