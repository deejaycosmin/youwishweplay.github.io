<?
session_start();

if(isset($_GET['logout'])){	
	
	session_destroy();
	header("Location: index.php"); //Redirect the user
}

function loginForm(){
	echo'
<div class="header-img"></div>

<div class="header">
  <h1>Welcome</h1>
  <h2>to our "You Wish We Play" Evening</h2>
  <h2>in TUI Magic Life Marmari Palace</h2>
  <br></br>
  <h3>Please enter your name to continue:</h3>
</div>
	<div id="loginform">
	<form action="index.php" method="post">
		<label for="name">Name:</label>
		<input type="text" name="name" id="name" />
		<input type="submit" style="background-color: #ffdf00; color: black; border: 1px;
  color: black;" name="enter" id="enter" value="Join" class="button" />
	</form>
	</div>

	';
}

if(isset($_POST['enter'])){
	if($_POST['name'] != ""){
		$_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
	}
	else{
		echo '<span class="error">Please type in a name</span>';
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=0.77, user-scalable=0" />
<meta name="apple-mobile-web-app-capable" content="yes" />
        </head>
<title>TUI Magic Life Marmari Palace</title>
<link type="text/css" rel="stylesheet" href="style.css" />


<?php
if(!isset($_SESSION['name'])){
	loginForm();
}
else{
?>
<div id="wrapper">
    <div class="header-img"></div>
	<div id="vertical-menu">
        <p class="logout"><a id="exit" href="#">Exit</a></p>
        <br></br>
		<p class="welcome">Welcome to our "You Wish We Play" Evening, <b><?php echo $_SESSION['name']; ?></b></p>
          <br></br>
		<p class="welcome"> Please follow the next order for your requests:</p>
    <p class="welcome">Artist Name - Song Title - Your Name</p>
     <br></br>
		<p class="welcome"> We kindly ask you to not request songs with explicit content!</p>
		<div style="clear:both"></div>
	</div>	
	<div id="chatbox"><?php
	if(file_exists("log.html") && filesize("log.html") > 0){
		$handle = fopen("log.html", "r");
		$contents = fread($handle, filesize("log.html"));
		fclose($handle);
		
		echo $contents;
	}
	?></div>
	
	<form name="message" action="">
		<input name="usermsg" type="text" id="usermsg" size="63" />
		<input name="submitmsg" style="background-color: #ffdf00; color: black; border: 1px;
  color: black;" type="submit"  id="submitmsg" value="Send" />
	</form>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript">
// jQuery Document
$(document).ready(function(){
	//If user submits the form
	$("#submitmsg").click(function(){	
		var clientmsg = $("#usermsg").val();
		$.post("post.php", {text: clientmsg});				
		$("#usermsg").attr("value", "");
		return false;
	});
	
	//Load the file containing the chat log
	function loadLog(){		
		var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
		$.ajax({
			url: "log.html",
			cache: false,
			success: function(html){		
				$("#chatbox").html(html); //Insert chat log into the #chatbox div				
				var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
				if(newscrollHeight > oldscrollHeight){
					$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
				}				
		  	},
		});
	}
	setInterval (loadLog, 500);	//Reload file every 2.5 seconds
	
	//If user wants to end session
	$("#exit").click(function(){
		var exit = confirm("Are you sure you want to end the session?");
		if(exit==true){window.location = 'index.php?logout=true';}		
	});
});
</script>
<?php
}
?>
</body>
</html>