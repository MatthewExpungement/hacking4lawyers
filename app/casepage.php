<?php
/*
Note even though the user here was smart and only uses the first entry returned from the sql query. If the first case number doesn't exist then then
second statement will be the first case number.

//Returns the address of the plaintiff as the defendants name
fakecasenumber' UNION ALL SELECT Case_Number,Case_Type,Plaintiff_Name,Plaintiff_Address as Defendant_Name,Hearing_Date,Case_Description From casedata WHERE Case_Number = '12C934902

//Resets the hearing date for a month earlier.
fakecasenumber'; UPDATE casedata SET Hearing_Date = '2019-10-5' WHERE Case_Number = '12C934903

//Updates the defendants name
fakecasenumber'; UPDATE casedata SET Defendant_Name = 'Someone Else' WHERE Case_Number = '12C934903

//Reset the name for case 19C934903
UPDATE `casedata` SET Defendant_Name = 'Larry David' WHERE Case_Number = '12C934903'
*/
include "sql.php";
$_GET['casenumber'] = "fakecasenumber'; UPDATE casedata SET Defendant_Name = 'Someone Else2' WHERE Case_Number = '12C934903";
if(!isset($_GET['casenumber'])){
    //Send to casesearch.php
    echo "No case number";
   // header("Location: casesearch.php");
}else{
    //casenumber=12C934902' UNION ALL SELECT Plaintiff_Address as Defendant_Name WHERE casenumber = '12C934902
    $sqlquery = "SELECT Case_Number,Case_Type,Plaintiff_Name,Defendant_Name,Hearing_Date,Case_Description 
    FROM casedata WHERE Case_Number = '". $_GET['casenumber'] . "'";

    try{
        $sql = $connection->multi_query($sqlquery);
        //printf("Error message: %s\n", $connection->error);
        if($sql == FALSE){
            printf("Connect failed: %s\n", $connection->error);
        }else{
            
            $fullarray = $sql->fetch_all(MYSQLI_ASSOC);
            //print_r($fullarray);
            
            if($fullarray == null){
                echo "Case Not Found";
            }else{
                echo "Case Number: " . $fullarray[0]['Case_Number'];
                echo "<br>Case Type: " . $fullarray[0]['Case_Type'];
                echo "<br>Plaintiff Name: " . $fullarray[0]['Plaintiff_Name'];
                echo "<br>Defendant Name: " . $fullarray[0]['Defendant_Name'];
                echo "<br>Hearing Date: " . $fullarray[0]['Hearing_Date'];
                echo "<br>Case Description: " . $fullarray[0]['Case_Description'];
            }
        }
        echo "<br><br><br>SQL Query: " . $sqlquery;
    }catch(Exception $e){
        echo "Error";
        printf("Connect failed: %s\n", $connection->error);
        print_r($e);
    }
}


?>