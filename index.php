<?php
 //echo md5(md5(md5(md5(md5(md5(md5(dechex("password"))))))));
 //I've to create a secret code that change every time someone use it
 //for sending a post request via JS
 
 session_start();
 
 //We start by creating a random code
 $rand= mt_rand(0123456789,9876543210);
 
 //And then we encode it in HEX
 $number_f= $rand;//The number that we've to encode
 $remaining= array();//An array for the remaining
 
 $remaining[]= array("remaining"=>$number_f % 16);//We start by adding the first result
 
 $divide= $number_f / 16;//Now we divide the result
 
 $divide= explode(".",$divide);//We get number without the period
 $divide= $divide[0];//And we get the remaining
 
 $remaining[]= array("remaining"=>$divide % 16);
 
 //And now we make a loop for remaking all this ^ for each result
 for($num= $divide;$num= $num/16;$num==0){
  $num= explode(".",$num);
  $num= $num[0];
  
  $remaining[]= array("remaining"=>$num % 16);
 }
 
 $number= array();
 
 //Now we put all the number into an array
 foreach($remaining as $rem){
  $num= $rem["remaining"];
  
  $dec= array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
  $hex= array(0,1,2,3,4,5,6,7,8,9,"A","B","C","D","E","F");
  
  $num= str_replace($dec,$hex,$num);
  
  $number[]= array("num"=>$num);
 }
 
 //Some other shit 
 $numb= "";
 
 foreach($number as $num){
  $numb.= $num["num"];
 }
 
 $hex= substr(strrev($numb),"1");//ta da
 
 $_SESSION["code"]= $hex;
?>
<!DOCTYPE html><!-- HTML5 !-->
<html lang="en">
 <head><!-- The head !-->
  <title>Soucial.</title><!--// title //!-->
  <link rel="stylesheet" href="design.css" type="text/css"/><!--// design.css //!-->
  <link rel="stylesheet" href="style.css" type="text/css"/><!--// style.css //!-->
 </head>
 <body>
  <!-- The backgrounds !-->
  <section class="backgrounds">
   <img class="backs one 1 brown" data-num="1" src="NOTCSS/background1.jpeg"/><!-- #1 !-->
   <img class="backs two 2 brown" data-num="2" src="NOTCSS/background2.jpeg"/><!-- #2 !-->
   <img class="backs three 3 green" data-num="3" src="NOTCSS/background3.jpeg"/><!-- #3 !-->
   <img class="backs four 4 green" data-num="4" src="NOTCSS/background4.jpeg"/><!-- #4 !-->
  </section>
  
  <!-- Now we can start add all the other things !-->
  <section class="content">
   <form action="" method="post">
    <section class="soucial brown light bigShadow">
     <input type="text" name="username" placeholder="USERNAME" class="username soucial brown light"/><br/>
	 <input type="password" name="password" placeholder="PASSWORD" class="password soucial brown light"/><br/>
	</section>
	
	<section class="soucial brown light bigShadow" style="margin-top: 2em;">
	 <input type="submit" value="SIGN IN" name="signIn" class="signIn soucial brown dark"/>
	 <input type="submit" value="SIGN UP" name="signUp" class="signUp soucial brown dark"/>
    </section>
   </form>
  </section>
  
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
  <script type="text/javascript" src="NOTCSS/script.js"></script>
  <script type="text/javascript">
   //If the user want to sign up
   $(".content form section .signUp").click(function(){
    var username= $(".content form section .username").val();//Get the username
    var password= $(".content form section .password").val();//Get the password
    var code= "<?php echo $hex; ?>";//The secret code
	
    //If they're not empty
    if(username && password)
    {
     //Do stuff here
	 //Change the color of the form
	 if($(".content form section").hasClass("brown"))
	 {
	  $(".content form section .password,.content form section .username").removeClass("red").addClass("brown");
	 }
	 else
	 {
	  $(".content form section .password,.content form section .username").removeClass("red").addClass("green");
     }
	 
	 //Now we have to create the account
	 var http= new XMLHttpRequest();//Create an htttp request
     var url= "POST/user.php?what=createAccount";//The url
     var params= "username="+ username +"&password="+ password +"&code=<?php echo $hex; ?>";//The params
 
     http.open("POST",url,true);//Open the http request
      
	 //Set up the headers
     http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
     http.setRequestHeader("Content-length",params.length);
     http.setRequestHeader("Connection","close");

     http.onreadystatechange= function(){
	  //If it's all okay
      if(http.readyState==4 && http.status== 200)
      {
	   var resp= http.responseText;//The resp from php
	   
	   //If it's all okay
	   if(resp==1)
	   {
	    //Refresh the page
		window.location.href="";
	   }
	   else
	   {
	    alert("Sorry, but something goes wrong... try later: "+ resp +"");
	   }
      }
     }
 
     http.send(params);
    }
    else
    {
     //Check what's the problem
	 
     //If the username is empty
     if(!username)
     {	  
      //Change the color with RED
	  $(".content form section .username").removeClass("green").removeClass("brown").addClass("red");
	  
      return false;
     }
	 else
	 {
	  //If the username is already taken...
      var http= new XMLHttpRequest();//Create an htttp request
      var url= "POST/user.php?what=usernameTaken";//The url
      var params= "username="+ username +"&code=<?php echo $hex; ?>";//The params
 
      http.open("POST",url,true);//Open the http request
      
	  //Set up the headers
      http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
      http.setRequestHeader("Content-length",params.length);
      http.setRequestHeader("Connection","close");

      http.onreadystatechange= function(){
	   //If it's all okay
       if(http.readyState==4 && http.status== 200)
       {
	    var resp= http.responseText;//The resp from php
		
		//If the username it's not available...
		if(resp==1)
		{
		 $(".content form section .username").removeClass("green").removeClass("brown").addClass("red");
		 
		 return false;
		}
		else
		{
		 if($(".content form section").hasClass("brown"))
		 {
		  $(".content form section .username").removeClass("red").addClass("brown");
		 }
		 else
		 {
		  $(".content form section .username").removeClass("red").addClass("green");
		 }
		}
       }
      }
 
      http.send(params);
	 }
  
     //If the password is empty
     if(!password)
     {
      $(".content form section .password").removeClass("green").removeClass("brown").addClass("red");
	  
	  return false;
     }
	 else
	 {
	  if($(".content form section").hasClass("brown"))
	  {
	   $(".content form section .password").removeClass("red").addClass("brown");
	  }
	  else
	  {
	   $(".content form section .password").removeClass("red").addClass("green");
      }
	 }
    }
   });
  </script>
 </body>
</html>