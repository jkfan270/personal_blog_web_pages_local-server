<!DOCTYPE html>
<html>
<head>
<title>Index page with SignUp and Login</title>
</head>
<body>

     <?php
	session_start();

	if(isset($_SESSION["email"]))
	{

		echo "Welcome, logged in as:  " .$_SESSION['email']. "<br />" ;	
			echo "<a href='new_post.php'>Make Posts</a>";
			echo"</br>";
              echo "<a href='Logout.php'>Logout</a>";
	}

	else
	{	
		echo "<H3>Please Login or Sign up</h3>";
		echo "<a href='login_page.php'>Login</a> <a href='sign-up.php'>Signup</a>";	
				
	}
     ?>

</body>
</html>
