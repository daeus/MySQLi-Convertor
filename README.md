MySQLi Convertor
===========

A simple trick to convert old deprecated mysql code to mysqli in PHP

**IMPORTANT: Noted that converting mysql to mysqli doesn't enhance your system security. It is recommended to rewrite your system in a modern and security approach.**

The project currently doesn't include all of the function in mysql but you may extend it by adding corresponding functions easily. 

SETUP
------


**STEP 1.** Include the convertor in your code
```
include 'SqliConvertor.php'; 
```

**STEP 2.** Set up the connection
```
$sqliConvertor = new SqliConvertor($host, $username, $password, $db_name);
```

**STEP 3.** Replace all the string "mysql_" to "$sqliConvertor->" in your file. If you are using Vim, you may use the following command
```
:%s/mysql_/$sqliConvertor->/g
```
