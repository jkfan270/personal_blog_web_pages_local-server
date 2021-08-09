<?php
session_start();

if(isset($_SESSION["email"]))
{
	$email=$_SESSION["email"];
	$conn = mysqli_connect("localhost","fan270","1580Fjk","fan270");
	if ($conn->connect_error)
	{
		die ("Connection failed: " . $conn->connect_error);
	}
	$q="SELECT * FROM USER where email = '$email'";
	$r = $conn->query($q);
	$row = $r->fetch_assoc();
	$username=$row["username"];
	$DOB=$row["DOB"];
	$userID=$row["user_id"];

	if(isset($_POST["bID"])){

		$inputBID=$_POST["bID"];
		$inputRID=0;
		$testLike="SELECT * FROM Rating WHERE Repost_id='$inputRID' AND Post_id='$inputBID'AND User_id='$userID'";
		
		$testr=mysqli_query($conn,$testLike);
		if(mysqli_num_rows($testr)==0){

			$inputLike="INSERT INTO Rating (Repost_id,Post_id,User_id,value) VALUES ('$inputRID','$inputBID','$userID',1)";
			$conn->query($inputLike);
			$result=1;
			
		}
		else{
			$result=0;
			
		}
		echo $result;
		$conn->close();
	}
	
	if(isset($_POST["rID"])){
		
		$inputBID=0;
		$inputRID=$_POST["rID"];
		$testLike="SELECT * FROM Rating WHERE Repost_id='$inputRID' AND Post_id='$inputBID'AND User_id='$userID'";
		$testr=mysqli_query($conn,$testLike);
		if(mysqli_num_rows($testr)==0){
			$inputLike="INSERT INTO Rating (Repost_id,Post_id,User_id,value) VALUES ('$inputRID','$inputBID','$userID',1)";
			$conn->query($inputLike);
			$result=1;
		}
		else{
			$result=0;
		}
		echo $result;
		
		$conn->close();
	}
	
}
?>