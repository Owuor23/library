<?php
//$db=new PDO("mysql:host=localhost;dbname=libraray",
//    "root"," ");
$host="localhost";
$user_name="root";
$user_password="";
$db_name="libraray";
 $con=mysqli_connect($host,$user_name,$user_password,$db_name);

if($con)
    echo "connection success";
else
    echo "connection failed";

