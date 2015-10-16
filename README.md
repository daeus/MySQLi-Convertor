MySQLi Convertor
===========

A simple trick to convert old depreciable mysql code to mysqli in PHP

**IMPORTANT: Noted that converting mysql to mysqli doesn't enhance your system security. It is recommended to rewrite your system in a modern and security approach.**

The project is unfinished. It currently doesn't include all of the function in mysql. 

SETUP
------


1. Include the convertor in your code
```
include 'SqliConvertor.php'; 
```

2. Set up the connection
```
$sqliConvertor = new SqliConvertor($host, $username, $password, $db_name);
```

3. Replace all the string "mysql_" to "$sqliConvertor->" in your file. If you are using Vim, you may use the following command
```
:%s/mysql_/$sqliConvertor->/g
```
