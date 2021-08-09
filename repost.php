<?php 
$validateR = true;
session_start();
$email=$_SESSION["email"];
if(isset($_GET["id"])){
	$_SESSION["id"]=$_GET["id"];
}

$errorMsg=" ";

if (isset($_POST["submittedL"]) && $_POST["submittedL"])
{
	$Repost_post=$_SESSION["id"];
	$dateR = trim($_POST["dateR"]);
	$ContentR = trim($_POST["ContentR"]);
	
    $db = new mysqli("localhost", "fan270", "1580Fjk", "fan270");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }
    $q1 = "SELECT * FROM USER WHERE email='$email'";
    $r1 = $db->query($q1);
    $row = $r1->fetch_assoc();
    
    $q = "SELECT * FROM Re_post where Content = '$ContentR'";

   $r = $db->query($q);

    if(strlen($ContentR) > 250 || strlen($ContentR)<=0)
    {
    	$validateR = false;
 
    }

    if($validateR == true)
    {
    	$Repost_UserR = $row["user_id"];
    	$q2 = "INSERT INTO Re_post(Repost_User,Content,Repost_Post) VALUES('$Repost_UserR','$ContentR','$Repost_post')";
        $r2 = $db->query($q2);
        if ($r2 === true)
        {	
            header("Location:post_list_page.php");
            $db->close();
            exit();
        }
    }
    else  
    {
        $errorMsg = "The content you type is invalid, please try agian.";
        $db->close();
    }
}

?>


<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type= "text/css" href="login_page.css">
<meta charset="UTF-8">
<title>Repost</title>
<script type="text/javascript" src="validate.js"></script>  
</head>

<body class="postbackground">

<div class="bigframe">
<nav>
	<ul class="navigator">
  		<li><a class="active" href="post_list_page.php">Home</a></li>
  		<li><a class="active" href="#moments">Moments</a></li>
 		<li><a class="active" href="#notifications">Notifications</a></li>
 		<li><a class="active" href="#messages">Messages</a></li>
 		<li><a class="active" href="new_post.php">Make Post</a></li>
 		<li style="float:right;"><a class="active" href="login_page.php">Log out</a></li>
	</ul>
</nav>

<div style="position:absolute; left:40%;top:10%;">
<div class="form" style="height:200px;width:350px;">
<form id="postForm" method="post" action="repost.php" enctype="multipart/form-data">  
<input type="hidden" name="submittedL" value="1"/>
<table>
	<tr><td><p class="font2" style="color:#888888;font-size:12px;position:absolute; left:30%;top:5%;">Write your own</p></td></tr>
	<tr><td><textarea onkeyup="size(this);" style="height:100px;width:320px;" placeholder="Leave a comment on selected post" name="ContentR"></textarea></td></tr>
	<tr><td><label id="text_msg" class="err_msg"></label></td></tr>
	<tr><td><small class="text_msg" >You can type maximum 250 words. Remain：<span id="check_text" class="text_msg">250</span></small></td></tr>
	<tr><td><label class="err_msg"><?php echo $errorMsg?></label></td></tr>
	<tr><td><button type="submit">Repost</button></td></tr>
</table>
</form>
</div>
</div>
</div>
</body>
</html>