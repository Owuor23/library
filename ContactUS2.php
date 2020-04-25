<!DOCTYPE HTML PUBLIC "-//WC3//DTD HTML 4.01 Transitional//EN""http:www.w3.org/TR/html4/loose.dtd">
<HTML>
<Head>
<Title>ContactUs2</Title>
<meta http-equiv="Content-Type"content="text/html;charset=utf-8">
<Head/>
<Body>
<?php
//Get the data from the form
//Basic error checking
if($_POST["customeremail"]==""){
	echo "You did not enter an email address";
	exit;
}
if(!erg("[a-z]+@[a-z]+\.[a-z]+",$_POST["customeremail "])){
	echo "Email Address is not valid";
	exit;
}
</Body>
</HTML>