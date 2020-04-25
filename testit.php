<?php
try{
 $db=new PDO("mysql:host=localhost;dbname=libraray","root","");
 $db->setAttribute(PDO::ATTR_ERRMODE,   PDO::ERRMODE_EXCEPTION);
 $sth=$db->query("select * from books where author like '%Bryson'");
while($row=$sth->fetch(PDO::FETCH_ASSOC)){
printf("%-40s %-20s\n",$row["title"],$row["author"]);
}
}
catch(PDOException $e){
printf("We have a problem:%s\n",$e->getMessage());
}
exit();
?>