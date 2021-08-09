<?php
$db = new mysqli("localhost", "fan270", "1580Fjk", "fan270");
session_start();
if(!isset($_SESSION['user']))
{
    $_SESSION['user'] = session_id();
}
$uid = $_SESSION['user'];  // set your user id settings
 
if($_POST)  // AJAX request received section
{
    $pid    = mysqli_real_escape_string($connection,$_POST['pid']);  // product id
    $op     = mysqli_real_escape_string($connection,$_POST['op']);  // like or unlike op
    
 
    if($op == "like")
    {
        $gofor = "like";
    }
    elseif($op == "unlike")
    {
        $gofor = "unlike";
    }
    else
    {
        exit;
    }
    // check if alredy liked or not query
    $query = mysqli_query($connection,"SELECT * from `likes` WHERE pid='".$pid."' and uid='".$uid."'");
    $num_rows = mysqli_num_rows($query);
 
    if($num_rows>0) // check if alredy liked or not condition
    {
        $likeORunlike = mysqli_fetch_array($query);
    
        if($likeORunlike['like'] == 1)  // if alredy liked set unlike for alredy liked product
        {
            mysqli_query($connection,"update `likes` set `unlike`=1,`like`=0 where id='".$likeORunlike['id']."' and uid='".$uid."'");
            echo 2;
        }
        elseif($likeORunlike['unlike'] == 1) // if alredy unliked set like for alredy unliked product
        {
            mysqli_query($connection,"update `likes` set `like`=1,`unlike`=0 where id='".$likeORunlike['id']."' and uid='".$uid."'");
            echo 2;
        }
    }
    else  // New Like
    {
       mysqli_query($connection,"INSERT INTO `likes` (`pid`,`uid`, `$gofor`) VALUES ('$pid','$uid','1')");
       echo 1;
    }
    exit;
}
 
 
$query  = "SELECT * FROM  `Post`"; // products list
$res    = mysqli_query($connection,$query);
$HTML = "";
while($row=mysqli_fetch_array($res))
{
    // get likes and dislikes of a product
    $query = mysqli_query($connection,"select sum(`like`) as `like`,sum(`unlike`) as `unlike` from `likes` where pid = ".$row['id']);
    $rowCount = mysqli_fetch_array($query);
    if($rowCount['like'] == "")
        $rowCount['like'] = 0;
        
    if($rowCount['unlike'] == "")
        $rowCount['unlike'] = 0;
        
    if($uid == "") // if user not loggedin then show login link on like button click
    {
        $like = '
            <input onclick="location.href = \'login_page.php\';" type="button" value="'.$rowCount['like'].'" rel="'.$row['id'].'" data-toggle="tooltip"  data-placement="top" title="Login to Like" class="button_like" />
            <input onclick="location.href = \'login_page.php\';" type="button" value="'.$rowCount['unlike'].'" rel="'.$row['id'].'" data-toggle="tooltip" data-placement="top" title="Login to Unlike" class="button_unlike" />';
    }
    else
    {
        $query = mysqli_query($connection,"SELECT * from `likes` WHERE pid='".$row['id']."' and uid='".$uid."'");
        if(mysqli_num_rows($query)>0){ //if already liked od disliked a product
            $likeORunlike = mysqli_fetch_array($query);
            // clear values of variables
            $liked = '';
            $unliked = '';
            $disable_like = '';
            $disable_unlike = '';
            
            if($likeORunlike['like'] == 1) // if alredy liked then disable like button
            {
                $liked = 'disabled="disabled"';
                $disable_unlike = "button_disable";
            }
            elseif($likeORunlike['unlike'] == 1) // if alredy dislike the disable unlike button
            {
                $unliked = 'disabled="disabled"';
                $disable_like = "button_disable";
            }
            
            $like = '
            <input '.$liked.' type="button" value="'.$rowCount['like'].'" rel="'.$row['id'].'" data-toggle="tooltip"  data-placement="top" title="Like" class="button_like '.$disable_like.'" id="linkeBtn_'.$row['id'].'" />
            <input '.$unliked.' type="button" value="'.$rowCount['unlike'].'" rel="'.$row['id'].'" data-toggle="tooltip" data-placement="top" title="Un-Like" class="button_unlike '.$disable_unlike.'" id="unlinkeBtn_'.$row['id'].'" />
            ';
        }
        else{ //not liked and disliked product
            $like = '
            <input  type="button" value="'.$rowCount['like'].'" rel="'.$row['id'].'" data-toggle="tooltip"  data-placement="top" title="Like" class="button_like" id="linkeBtn_'.$row['id'].'" />
            <input  type="button" value="'.$rowCount['unlike'].'" rel="'.$row['id'].'" data-toggle="tooltip" data-placement="top" title="Un-Like" class="button_unlike" id="unlinkeBtn_'.$row['id'].'" />
            ';
        }
    }
        
    $HTML.='
        <li> <img src="images/'.$row['image'].'" class="">
            <h4 class="">'.$row['product_name'].'</h4>
            <div class="product-price">
                <span class="normal-price">$'.$row['price'].'</span>
            </div>
            <a href="#" class="btn btn-default navbar-btn" >Buy Now</a>
            <div class="grid">
                '.$like.'
            </div>
        </li>';
}
 
?>