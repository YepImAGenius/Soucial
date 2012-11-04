<?php
 //A php file for gettting all info about a user
 //Mysql stuff
 $connect= mysql_connect("localhost","root","")or die("Opss: ". mysql_error());
 $selectDb= mysql_select_db("soucial")or die("Opss: ". mysql_error());
 
 session_start();
 
 //If the codes are right
 if($_POST["code"]==$_SESSION["code"])
 {
  //We can start the fun
  $what= $_GET["what"];//What the fuck do you want?
  
  //If we want to check if a username is available...
  if($what=="usernameTaken")
  {
   $username= $_POST["username"];//Get the username
   
   //Now we've to check on the db if it's available
   $query= mysql_query("SELECT*FROM users WHERE username='$username'");
   $checknum= mysql_num_rows($query);
   
   //If it's available...
   if($checknum)
   {
    echo 1;
   }
   else
    echo 0;
  }
  
  //If we want to create a new account...
  if($what=="createAccount")
  {
   $username= $_POST["username"];//Get the username
   $password= md5(md5(md5(md5(md5(md5(md5(dechex($_POST["password"]))))))));//Get the password (encoded)
   
   $query= mysql_query("INSERT INTO users(username,password) VALUES('$username','$password')")or die("Opss: ". mysql_error());
   
   //If it's all ok...
   if($query)
   {
    //Log the user
	//Get the user id
	$id= mysql_insert_id();
	$log= md5(md5(md5(md5(md5(md5(md5(dechex(mysql_insert_id()))))))));//The id encoded
	
	//Upate the db for add the new id encoded
	$query= mysql_query("UPDATE users SET log='$log' WHERE id='$id'")or die("Opss: ". mysql_error());
	
	//Set the cookie
	setcookie("login",$log,time() +315569260,"/");
	
    echo 1;
   }
   else
    echo 0;
  }
 }
?>