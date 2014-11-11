<?php
$servername = "localhost";
$user = "root";
$password = "";



if(isset($_COOKIE['ambitionbox'])){
	echo "cookie is set \n";
	//values retrieved from table $username $series $token
	$conn = mysql_connect($servername,$user);
	if(!$conn){
		die('Database unavailable at this time');
	}
	$db = mysql_select_db('ambitionbox');
	$array = $_COOKIE['ambitionbox'];

	$array = explode(',',$array);
	
	$username = $array[0];
	

	$token = $array[1];
	print $token;
	$sql = "SELECT * FROM rememberedsessions WHERE username = '$username' AND token = '$token'";

	$query = mysql_query($sql);
	
	if($query && mysql_num_rows($query)>0){
		/*$row = mysql_fetch_array($query);
		
		$series = $row['series'];
		$token = $row['token'];
		
		if ($array[0]==$username && $array[1] == $series && $array[2] == $token){
			//this is a valid login
			header('Location:success.php');
		}else if($array[0]==$username && $array[1] == $series){
			//delete all other sessions
			header('Location:success.php');
		}else{
			continue;
		}*/
		
		$min = '10000';
		$max = '10000000000000';
		//code taken from http://stackoverflow.com/questions/1479823/in-php-how-do-i-generate-a-big-pseudo-random-number
 		$difference   = bcadd(bcsub($max,$min),1);
  		//$rand_percent1 = bcdiv(mt_rand(), mt_getrandmax(), 8); // 0 - 1.0
  		$rand_percent2 = bcdiv(mt_rand(), mt_getrandmax(), 8); // 0 - 1.0

  		//$series =  bcadd($min, bcmul($difference, $rand_percent, 8), 0);
		$token =  bcadd($min, bcmul($difference, $rand_percent2, 8), 0);
		$array = array($username,$token);
		$array = implode(',',$array);
		print $username;
		print $token;
		setcookie('ambitionbox', '', time() - 3600);
		if(setcookie('ambitionbox',$array)){
			$sql = mysql_query("UPDATE rememberedsessions SET token ='$token' ");
			
			$query = mysql_query($sql);
			if($query){
				echo("yes");
			}
		}
		header('Location:success.php');
	}
	
}




if(isset($_POST['loginbtn'])){
	$username = $_SESSION['username'];
	$password = $_SESSION['password'];
}






?>








<html>
	<head>
				<!--<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css"> -->
	</head>
	<body class="container">
		<form action = "login.php" method = "POST">
			Username<input type = "text" name = "username" class= "form-control"><br>
			Password<input type = "password" name ="password" class = "form-control"><br>
			Remember Me:<input type = "checkbox" name = "remember" class = "form-control"><br>
			<input type = "submit" name = "loginbtn" class = "btn btn-primary" value = "Login">
		</form>
	</body>

<html>