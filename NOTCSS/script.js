//Javascript (but mostly jQuery)
//Let's do the background with a random image
var backs= $(".backgrounds .backs");//The backs
var num= backs.length;//Get the number of backs
var rand= 1 + Math.floor(Math.random()* num);//Generate a random number

$(".backgrounds .backs."+ rand +"").show();//Show the random back

//And now we've to show the right form
if($(".backgrounds .backs."+ rand +"").hasClass("brown"))
{
 $(".content form section").removeClass("green").addClass("brown");
 $(".content form section input").removeClass("green").addClass("brown");
}
else
{
 $(".content form section").removeClass("brown").addClass("green");
 $(".content form section input").removeClass("brown").addClass("green");
}

//Now let's do the submit stuff on the form
$(".content form").submit(function(){
 return false;
});