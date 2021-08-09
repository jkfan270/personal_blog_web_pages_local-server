function Login(event){
	var element = event.currentTarget;
	var a = element[0].value;
	var b = element[1].value;
	
	var result = true;
	
    var email_v = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/; 
	var pswd_v = /^(?![^a-zA-Z]+$)(?!\D+$).{8}$/;
	
	document.getElementById("email_msg").innerHTML="";
	document.getElementById("pswd_msg").innerHTML="";
	
    if (a==null || a==""|| email_v.test(a) == false)
    {	   
   document.getElementById("email_msg").innerHTML="email is empty or invalid(example: cs215@uregina.ca)";
       result = false;
    }
    
	if (b==null || b=="" || pswd_v.test(b) == false){
		document.getElementById("pswd_msg").innerHTML="8 characters long at least one non-letter";
		result = false;
	}
	
    if(result == false )
    {    
        event.preventDefault();
    }

}

function SignUp(event){
	var element = event.currentTarget;
	var a = element[1].value;
	var b = element[2].value;
	var c = element[3].value;
	var d = element[4].value;
	var e = element[5].value;
	
	
	var result = true;
	
    var email_v = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/; 
	var Uname_v = /^[a-zA-Z0-9_-]+$/;
	var date_v =  /\d{2}-\d{2}-\d{4}/;
	var pswd_v = /^[0-9a-zA-Z]{8}$/;
	
	
	document.getElementById("email_msg").innerHTML="";
	document.getElementById("uname_msg").innerHTML="";
	document.getElementById("date_msg").innerHTML="";
	document.getElementById("pswd_msg").innerHTML="";
	document.getElementById("pswdr_msg").innerHTML="";
	
	
	
    if (a==null || a==""|| email_v.test(a) == false){	   
       document.getElementById("email_msg").innerHTML="email is empty or invalid(example: cs215@uregina.ca)";
       result = false;
    }
    
	if (b==null || b=="" || Uname_v.test(b) == false){  
	    document.getElementById("uname_msg").innerHTML="username is empty or invalid";
	    result = false;
    }
	
	if (c==null || c==""|| date_v.test(c) ==false){
		document.getElementById("date_msg").innerHTML="please follow the format dd-mm-yyyy";
		result = false;
	}
	
	if (d==null || d=="" || pswd_v.test(d) == false){
		document.getElementById("pswd_msg").innerHTML="8 characters long at least one non-letter";
		result = false;
	}
	
	if (e==null || e=="" || e!=d || pswdr_v.test(e) == false){
		document.getElementById("pswdr_msg").innerHTML="passworDislike and confirmed passworDislike has to match";
		result = false;
	}
	
	
    if(result == false)
    {    
        event.preventDefault();
    }
  
}

function postForm(){
	var result = true;
	var a = document.forms.postForm.text.value;
	var text_v = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/; 
	document.getElementById("text_msg").innerHTML ="";
	if (a==null || a =="" ||text_v.test(a) == false){
		document.getElementById("text_msg").innerHTML="Please enter the word you want to send.";
		result = false;
	}
}

function size(text){
	var max = 250;
	if(text.value.length < max)
		{
			var str = max - text.value.length;
			document.getElementById("check_text").innerHTML=str.toString();
		}
	else
		{
			document.getElementById("check_text").innerHTML="Exceeded limit!";
		}
}

function like(bID){
	var likeR = new XMLHttpRequest();
	var error=bID+"B1";
	console.log(bID);
	likeR.onreadystatechange = function() {
        if (likeR.readyState == 4 && likeR.status == 200) {
           	var results = likeR.responseText;
           	console.log(results);
           	if(results==0){
				document.getElementById(error).innerHTML="";
               	}	           
        }
	}
    likeR.open("POST", "like.php", true);
    likeR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    likeR.send("bID="+ bID);
}

function rLike(rID){
	var rLikeR = new XMLHttpRequest();
	var error=rID+"R1";
	rLikeR.onreadystatechange = function() {
        if (rLikeR.readyState == 4 && rLikeR.status == 200) {
           	var results = rLikeR.responseText; 
           	if(results==0){
				document.getElementById(error).innerHTML="";
               	}	  		            
        }
	}
    rLikeR.open("POST", "like.php", true);
    rLikeR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    rLikeR.send("rID="+ rID);
}

function Dislike(bID){
	var xmlhttp = new XMLHttpRequest();
	var error=bID+"B2";
	xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
           	var results = xmlhttp.responseText;   	
           	if(results==0){
				document.getElementById(error).innerHTML="";
               	}	 	            
        }
	}
    xmlhttp.open("POST", "dislike.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("bID="+ bID);
}

function rDislike(rID){
	var xmlhttp = new XMLHttpRequest();
	var error=rID+"R2";
	xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
           	var results = xmlhttp.responseText;  
           	if(results==0){
				document.getElementById(error).innerHTML="";
               	}	 		            
        }
	}
    xmlhttp.open("POST", "dislike.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("rID="+ rID);
}
