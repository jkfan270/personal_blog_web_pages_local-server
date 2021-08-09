<?php
$validateS = true;
$error = "";
$reg_Email = "/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/";
$reg_Pswd = "/^(?![^a-zA-Z]+$)(?!\D+$).{8}$/";
$reg_Bday = "/^\d{1,2}\-\d{1,2}\-\d{4}$/";
$emailS = "";
$dateS = "mm-dd-yyyy";
$errorMsg=" ";


if (isset($_POST["emailS"]) && $_POST["emailS"])
{
	$emailS = trim($_POST["emailS"]);
	$dateS = trim($_POST["dateS"]);
	$passwordS = trim($_POST["passwordS"]);
	$usernameS = trim($_POST["usernameS"]);
	  $db = new mysqli("localhost", "fan270", "1580Fjk", "fan270");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }


	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			$errorMsg= "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			$errorMsg= "File is not an image.";
			$uploadOk = 0;
		}
	}

	if (file_exists($target_file)) {
		$errorMsg= "Sorry, file already exists.";
		$uploadOk = 0;
	}

	if ($_FILES["fileToUpload"]["size"] > 500000) {
		$errorMsg= "Sorry, your file is too large.";
		$uploadOk = 0;
	}

	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
		$errorMsg="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}

	if ($uploadOk == 0) {
		$errorMsg= "Sorry, your file was not uploaded.";

	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			$errorMsg= "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			$filename= $_FILES['fileToUpload']['name'];
			$name=explode(".",$filename);
			$newname="uploads/".$usernameS;
			$oldname="uploads/".$filename;
			rename($oldname,$newname);
			
		} else {
			$errorMsg= "Sorry, there was an error uploading your file.";
		}
	}
	
	if ($uploadOk == 1)
	{
		$validateS = true;
		
	}
    
    $q1 = "SELECT * FROM USER WHERE email = '$emailS'";
    $r1 = $db->query($q1);

    if($r1->num_rows > 0)
    {
        $validateS = false;
    }
    else
    {
        $emailMatch = preg_match($reg_Email, $emailS);
        if($emailS == null || $emailS == "" || $emailMatch == false)
        {
            $validateS = false;
        }
        
              
        $pswdLenS = strlen($passwordS);
        $pswdMatch = preg_match($reg_Pswd, $passwordS);
        if($passwordS == null || $passwordS == "" || $pswdMatch == false)
        {
            $validateS = false;
        }

        $bdayMatch = preg_match($reg_Bday, $dateS);
        if($dateS == null || $dateS == "" || $bdayMatch == false)
        {
            $validateS = false;
        }
    }

    if($validateS == true)
    {
        $dateFormatS = date("Y-m-d", strtotime($dateS));
        
        $q2 = "INSERT INTO USER(Username,Password,Email,DOB) VALUES('$usernameS','$passwordS','$emailS','$dateFormatS')";
        $r2 = $db->query($q2);
        
        if ($r2 === true)
        {
            header("Location:login_page.php");
            $db->close();
            exit();
        }
    }
    else
    {
        $errorS = "email address is not available. Signup failed.";
        $db->close();
    }

}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type= "text/css" href="login_page.css">
<meta charset="UTF-8">
<title>Create new account</title>
</head>
<script type="text/javascript" src="validate.js"></script>  
<body>

<div class="background">
<span>
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
<div class="tag">See what’s happening in <br>the world right now <br><p  style="font-size:25px;">Join today.</p></div>
	<div class="form">
	<form id="SignUp" method="post" action="sign-up.php" enctype="multipart/form-data">
	<table style="margin:auto">
		<tr><td><input type="text" placeholder="Email address" name="emailS"></td></tr>
		<tr><td><label id="email_msg" class="err_msg"></label></td></tr>
		<tr><td><input type="text" placeholder="Username" name="usernameS"></td></tr>
		<tr><td><label id="uname_msg" class="err_msg"></label></td></tr>
		<tr><td><input type="text" placeholder="dd-mm-yyyy" name="dateS"></td></tr>
		<tr><td><label id="date_msg" class="err_msg"></label></td></tr>
		<tr><td><input type="file" id="image-file" name="fileToUpload"></td></tr>
		<tr><td><label class="err_msg"><?php echo $errorMsg?></label></td></tr>
		<tr><td><input type="password" placeholder="Password" name="passwordS"></td></tr>
		<tr><td><label id="pswd_msg" class="err_msg"></label></td></tr>
		<tr><td><input type="password" placeholder="Confirm password"></td></tr>
		<tr><td><label id="pswdr_msg" class="err_msg"></label></td></tr>
		<tr><td><label class="err_msg"><?php echo $errorS?></label></td></tr>
	</table>
	<br>
		<button type="submit">Get started</button>
		<p class="msg"><br>Already registered? <a href="login_page.php">Log in</a></p>
	</form>
	</div>
</div>


<script type = "text/javascript"  src = "SignUp-r.js" ></script>
</body>
</html>