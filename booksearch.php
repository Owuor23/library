<!DOCTYPE HTML PUBLIC "-//WC3//DTD HTML 4.01 Transitional//EN""http:www.w3.org/TR/html4/loose.dtd">
<HTML>
<Head>
<Title>Book Search Results</Title>
<meta http-equiv="Content-Type"content="text/html;charset=utf-8">
<Head/>
<Body>
<h3>Book Search Results</h3>
<hr> 
<?php
//Get the data from the form
$searchtitle= trim($_POST['searchtitle']);
$searchauthor= trim($_POST['searchauthor']);

if(!$searchtitle && !$searchauthor){
	printf("You must specify either a title or an author");
	exit();
}

$searchtitle=addslashes($searchtitle);
$searchauthor=addslashes($searchauthor);

try{
 $db=new PDO("mysql:host=localhost;dbname=libraray","root","");
 $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 
}
catch(PDOException $e){
printf("Unable to open database:%s\n",$e->getMessage());
}
//Build the query Users are allowed to search on title,author or both
$query="select*from books";
if($searchtitle && !$searchauthor){
	//title search only
	$query=$query."where title like '%".$searchtitle."%'";
}
if(!$searchtitle && $searchauthor){
	//only searchauthor
	$query=$query."where author like'%".$searchauthor."%'";
}
if($searchtitle && $searchauthor){
	//title and author
	$query=$query."where title like '%".$searchtitle."%' and author like '%".$searchauthor."%'"; 
}
  printf("Debug:running the query%s<br>",$query);
try{
	$sth=$db->query($query);
	$bookcount=$sth->rowCount();//Only works for MYSQL
	if($bookcount==0){
		printf("Sorry,we did not find any matching books");
		exit;
	}
	prinf('<table bgcolor="#bdc0ff"cellpadding="6">');
	prinf('<tr><b><td>Title</td> <td>Author</td> </b> </tr>');
	while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
		prinf("<tr> <td> %s </td> <td> %s </td> </tr>",htmlentities$row["title"],htmlentities$row["author"]);
	}
}
catch(PDOException $e){
printf("We have a problem:%s\n",$e->getMessage());
}
printf("</table>");
printf("<br>  We found %s matching books",$bookcount);
?>
</Body>
</HTML>