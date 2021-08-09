<?php

$validateL = true;
$reg_EmailL = "/^\w+@[a-zA-Z_ ]+?\.[a-zA-Z]{2,3}$/";
$reg_PswdL = "/^(\S*)?\d+(\S*)?$/";

$emailL = "";
$errorMsg = "";

if (isset($_POST["email"]) && $_POST["email"])
{
    $emailL = trim($_POST["email"]);
    $passwordL = trim($_POST["password"]);
    
    $db = new mysqli("localhost", "fan270", "1580Fjk", "fan270");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }


    $q = "SELECT * FROM USER where email = '$emailL' AND password = '$passwordL'";
       
   $r = $db->query($q);
    $row = $r->fetch_assoc();
    if($emailL != $row["email"] && $passwordL != $row["password"])
    {
        $validateL = false;
    }
    else
    {
        $emailLMatch = preg_match($reg_EmailL, $emailL);
        if($emailL == null || $emailL == "" || $emailLMatch == false)
        {
            $validateL = false;
        }
        
        $pswdLen = strlen($passwordL);
        $passwordLMatch = preg_match($reg_PswdL, $passwordL);
        if($passwordL == null || $passwordL == "" || $pswdLen < 8 || $passwordLMatch == false)
        {
            $validateL = false;
        }
    }
    
    if($validateL == true)
    {

        session_start();
        $_SESSION["email"] = $row["email"];
        $_SESSION["uname"] = $row["username"];
        header("Location: index.php");
        $db->close();
        exit();
    }
    else 
    {
        $errorMsg = "The email/password combination was incorrect. Login failed.";
        $db->close();
    }
}

?>



<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Welcome</title>
<script type="text/javascript" src="validate.js"></script>  
<link rel="stylesheet" type= "text/css" href="login_page.css">
</head>
<body>


<div class="background"><span>
	<br>✌    Find out what interests you.
	<br>
	<br>✉   See what people are saying.
	<br>
	<br>✈   Join them.
</span>

<footer style="text-align:center">
<ul>
<li><a style="text-decoration:none; color:#b3b3b3;" href=#>About</a></li>
<li><a style="text-decoration:none; color:#b3b3b3;" href=#>Help</a></li>
<li><a style="text-decoration:none; color:#b3b3b3;" href=#>Blog</a></li>
<li><a style="text-decoration:none; color:#b3b3b3;" href=#>Privacy</a></li>
<li><a style="text-decoration:none; color:#b3b3b3;" href="https://validator.w3.org/nu/?doc=http%3A%2F%2Fwww2.cs.uregina.ca%2F~fan270%2Fas2%2Flogin_page.html">Validate HTML5</a></li>
</ul>
</footer>

</div>

<div class="login_page">
<div class="tag" >See what’s happening in <br>the world right now</div>
	<div class="form">
	<form id="Login" method="post" class="login_form" action="login_page.php">
	<table style="margin:auto">
		<tr><td><input type="text" placeholder="Email" name="email"></td></tr>		
		<tr><td><label id="email_msg" class="err_msg"></label></td></tr>
		<tr><td><input type="password" placeholder="Password" name="password"></td></tr>
		<tr><td><label id="pswd_msg" class="err_msg"></label></td></tr>
		<tr><td><label class="err_msg"><?php echo $errorMsg?></label></td></tr>
	</table>
	<br>
		<button type="submit" value="Login">Log in</button>
		<p class="msg"><br>Not registered? <a href="sign-up.php">Create a new account</a></p>
	</form>
	</div>
</div>


<script type = "text/javascript"  src = "Login-r.js" ></script>
</body>
</html>