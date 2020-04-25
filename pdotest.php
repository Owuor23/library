<?php
$searchtitle="Dune";
$searchauthor="Frank Herbert";
try{
	$db=new PDO("mysql:host=localhost;dbname=libraray","root","");
	
	switch($argv[1]){
		case 1://Explict sql query
		$query="selct*from books where title like'%$searchtitle%".
		"and author like '%$searchauthor%'";
		$stmt=$db->query($query);
		while($row=$stmt->fetch(PDO:: FETCH_ASSOC)){
			printf("%-40s%-20s\n",$row["title"],$row["author"]);
		}
		break;
		
		case 2://Use a prepared  statement with parameters bound by position Method 1
		$stmt=$db->prepare("selct*from books where title like? and author like?");
		$stmt->execute(array("%$searchtitle%","%$searchauthor%"));
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			printf("%-40s%-20s\n",$row["title"],$row["author"]);
		}
		break;
		
		case 3://Use a prepared statmemnt with parameters bound by position Method 2
		$stmt=$db->prepare("select*from books"."where title regexp? and author regexp?");

        $stmt->bindParam(1,$searchtitle);
        $stmt->bindParam(2,$searchauthor);
       // $searchtitle="";
       // $searchauthor=";
        $stmt->execute();
		while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			printf("%-40s%-20s\n",$row["title"],$row["author"]);
		}
		$searchtitle="";
        $searchauthor="";
		$stmt->execute();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			printf("%-40s %-20s\n",$row["title"],$row["author"]);
		}
		break;
		
		case 4://Use a prepared statement with parameters bound by name Method 1
		$stmt=$db->prepare("select*from books where title like :title and where author like:author");
		$stmt->execute(array(":title"=>"%$searchtitle%",":author"=>"%$searchauthor%"));
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			printf("%-40s %-20s\n",$row["title"],$row["author"]);
		}
		break;
		case 5://use a prepared statement with parameters bound by name Method 2
		$stmt=$db->prepare("select*from books where title regexp:title"."and author regexp:author");
        $stmt->bindParam(':title',$searchtitle);
        $stmt->bindParam(':author',$searchauthor);
        $stmt->execute();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			printf("%-40s %-20s\n",$row["title"],$row["author"]);
		}
		$searchtitle="";
        $searchauthor="";
		$stmt->execute();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			printf("%-40s %-20s\n",$row["title"],$row["author"]);
		}
		break;
		
		case 6://Use a stored procedure
		$stmt=$db->query("call overdue_books()");
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			printf("%s\n",$row["title"]);
		}
		break;
		
		case 7://using a stored function
		$stmt=$db->query("select count_overdue_books()");
		$stmt->execute(array(2));
		printf("No.of overdue books=%d\n",$stmt->fetchColumn());
		break;
		
		
		case 8;//Execute a non-query(Insert)
		$stmt=$db->prepare("insert into borrowers (name,address)values"."(:name,:address)");
		$stmt->execute(array(":name"=>"Greg ochieng",
		              ":address"=>"Umoja Kwa chief"));
	    $stmt->execute(array(":name"=>"Lucy oure",
		                     ":address"=>"kayole juction"));
		break;
		case 9://Ececute a non query (Delete)
		$stmt=$db->prepare("delete from borrowers where address=?");
		$stmt->execute(array("kayole junction"));
		printf("%d  Rows deleted \n",$stmt->rowCount());
		
		break;
		case 10://Ececute a summary function
		$stmt=$db->query("select count(*) from books where author like'%Dickens%'");
		printf("we have %d books by Dickens \n",$stmt->fetchColumn());
		
		break;
		
		
		
		
	}
}catch(PDOException $e){
printf("We have a problem:%s\n",$e->getMessage());
}
exit();
?>