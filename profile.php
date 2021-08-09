<?php
session_start();

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type= "text/css" href="login_page.css">
<meta charset="UTF-8">
<title>View Profile</title>
</head>
<script>
var xmlHttp;
function refresh1(){  
	xmlHttp = new XMLHttpRequest(); 
    xmlHttp.open("GET","profile.php",true);  
    xmlHttp.onreadystatechange = function(){
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200){  
            document.getElementById("body").innerHTML = xmlHttp.responseText;  
            setTimeout("refresh1()",6000);  
        }  
    }
    xmlHttp.send();  
}  
</script>

<body class="postbackground" id="body" onload="refresh1()">

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
</div>

<?php
if(isset($_SESSION["email"]))
{

	$email=$_SESSION["email"];
	$db = new mysqli("localhost", "fan270", "1580Fjk", "fan270");
	if ($db->connect_error)
	{
		die ("Connection failed: " . $db->connect_error);
	}
	$q="SELECT * FROM USER where email = '$email'";
	$r = $db->query($q);
	$row = $r->fetch_assoc();
	$username=$row["username"];
	$DOB=$row["DOB"];
	$user_id=$row["user_id"];
?>

<div class="frame">
<p><img src="uploads/<?php echo $username; ?>" height="30%" width="30%" class="icon"><a class="font" href="profile.php" style="text-decoration:none;color:black;"><b>@<?php echo $username; ?></b></a></p>
<br>
<br>
<br>
<table style="width:100%; border:0; cellspacing:0; cellpadding:0;">
	<tr><td style="color:#888888;font-size:16px;">From Regina, Saskatchewan</td></tr>
	<tr><td style="color:#1E90FF;font-size:16px;">www2.cs.uregina.ca/~fan270/cs215/login_page.php</td></tr>
	<tr><td style="color:#888888;font-size:16px;">Joined Feb 2018</td></tr>
	<tr><td style="color:#888888;font-size:16px;">Born on <?php echo $DOB; ?></td></tr>
	<tr><td style="color:#1E90FF;font-size:16px;"><a href="#">Photos and videos</a></td></tr>
	<tr><td><button onclick="window.location.href='post_list_page.php';return false">Back</button></td></tr>


</table>
</div>

<?php 
$conn = mysqli_connect("localhost","fan270","1580Fjk","fan270");
$q2="SELECT * FROM Post WHERE Post_User = '$user_id' ORDER BY Date DESC ";
$result= mysqli_query($conn,$q2);
if(mysqli_num_rows($result)>0)
{
	
	while(($row2 = mysqli_fetch_assoc($result))&&($counterp<20))
	{
		$Post_User=$row2["Post_User"];
		$q0="SELECT * FROM USER WHERE user_id = '$Post_User'";
		$r0=$db->query($q0);
		$row0=$r0->fetch_assoc();
		$PostID=$row2["Post_ID"];
		
		$pDislike="SELECT * FROM Rating WHERE value=2 AND Post_id='$PostID'";
		$gpDislike=mysqli_query($conn,$pDislike);
		$ndl=mysqli_num_rows($gpDislike);
		$pLike="SELECT * FROM Rating WHERE value=1 AND Post_id='$PostID'";
		$gpLike=mysqli_query($conn,$pLike);
		$nl=mysqli_num_rows($gpLike);

       	echo " 	<div class='frame_post' name='".$row2["Post_User"]."'>
				<form>
				<div style='display:inline;position:relative;left:10px;top:0px;'>
                <img src="."uploads/".$row0["username"]."  height='60px' width='65px' style='margin-left:15px; margin-top:15px;vertical-align:middle;'/>
				<a href='profile.php' style='text-decoration:none;color:black;'><b style='font-size:16px;margin-left:3px;'>".$row0["username"]."</b></a>
       			<li style='font-size:15px;margin:0;color:#888888;'>".$row2["Date"]."</li>
				</div>
				<p style='position:relative;left:85px;top:30px;'>".$row2["Content"]."</p>
				<div style='display:inline;position:absolute;left:0px;bottom:0px;'>
				<ul>
				<li><a href='repost.php?id=".$PostID."'>Repost</a></li>
				<li><button>Comments(3) <i class='fa fa-comment-o'></i></button></li>
					<li><input type='button' value='Like' onclick='like(".$PostID.")'>".$nl."</li>
					<li><input type='button' value='Dislike' onclick='Dislike(".$PostID.")'>".$ndl."</li>
				</ul>
				</div>
				</form>
 				</div>
 				<br/>";
    }
    			
}
       else
       {
       	echo"<form class='frame_post'><p style='position:relative;left:85px;top:30px;'>Post, nothing's Here.</p></form>";
       }
       
       
       $q3="SELECT * FROM Re_post ORDER BY Date DESC";
       $result2= mysqli_query($conn,$q3);
       $counterr=0;
       if((mysqli_num_rows($result2)>0)&&($counterr<20))
		{
       	while($row2 = mysqli_fetch_assoc($result2))
			{
				
			$Repost_User=$row2["Repost_User"];
       		$Repost_ID=$row2["Repost_Post"];
       		$q4="SELECT * FROM Post where Post_ID = '$Repost_ID'";
       		$r4 = $db->query($q4);
       		$row4 = $r4->fetch_assoc();
       		
       		$past_post=$row4["Content"];
       		$past_time=$row4["Date"];
       		$Post_ID=$row4["Post_User"];
       		
       		
       		$q5="SELECT * FROM USER where user_id = '$Post_ID'";
       		$r5 = $db->query($q5);
       		$row5 = $r5->fetch_assoc();
       		
       		$goUser="SELECT * FROM USER WHERE user_id='$Repost_User'";
       		$rb=$db->query($goUser);
       		$rou=$rb->fetch_assoc();
       			
       		$repostID=$row2["Repost_ID"];
       		$rDislike="SELECT * FROM Rating WHERE value=2 AND Repost_id='$repostID'";
       		$grDislike=mysqli_query($conn,$rDislike);
       		$nrd=mysqli_num_rows($grDislike);
       		$rLike="SELECT * FROM Rating WHERE value=1 AND Repost_id='$repostID'";
       		$grLike=mysqli_query($conn,$rLike);
       		$nrl=mysqli_num_rows($grLike);
       		$counterr+=1;
       		
       		echo " <div class='frame_post' name='".$row2["Repost_User"]."'>
					 <form>
       				<img src="."uploads/".$rou["username"]." style='height:55px; width:60px;position:absolute; top:2%;left:2%;vertical-align:middle;'/>
       				<div style='display:inline;position:relative;left:30px;top:0px;'>
       				<ul>
       				<li><a href='profile.php' style='text-decoration:none;color:black;'><b style='font-size:16px;margin-left:3px;'>".$rou["username"]."</b></a></li>
					<li style='font-size:16px;margin:0;color:#888888;'>".$row2["Date"]."</li>
					</ul>
					</div>
       				
					<p style='position:absolute;left:85px;top:30px;'>".$row2["Content"]."</p>
					<ul>
					
					<li style='font-size:16px;color:#888888;position:absolute;left:280px;top:30px;'>Repost from: ".$row5["username"]."<br/>".$past_time."</li>
					</ul>
					<img src="."uploads/".$row5["username"]."  style='height:55px;width:60px;position:absolute;left:85px;top:80px;'/>
					<p style='font-size:13px;position:absolute;left:160px;top:100px;'>".$past_post."</p>
					<div style='display:inline;position:absolute;left:0px;bottom:0px;'>
					<ul>
					<li><button>Comments(6) <i class='fa fa-comment-o'></i></button></li>
					<li><input type='button' value='Like' onclick='rLike(".$repostID.")'>".$nrl."</li>
					<li><input type='button' value='Dislike' onclick='rDislike(".$repostID.")'>".$nrd."</li>
					</ul>
					</div>
					</form>
       				</div>";
				}
			}
			 else{
			 		echo"<form class='frame_post'><p style='position:relative;left:85px;top:30px;'>Reposts, nothing's Here.</p></form>";
			 		}
?>
	
	
	
</section>
<?php 

}

else
{
	header("Location: post_list_page.php");
}
?>
	
</body>
</html>