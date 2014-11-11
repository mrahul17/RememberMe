<?php
$servername = "localhost";
$user = "root";
$password = "";

$username = $_POST['username'];
$password = $_POST['password'];
echo $username;

$conn = mysql_connect($servername,$user);
if(!$conn){
	die('Database unavailable at this time');
}
$db = mysql_select_db('ambitionbox',$conn);
$query = mysql_query('SELECT * FROM users WHERE username = "rahul"');
if($query && mysql_num_rows($query)>0){
	$row = mysql_fetch_array($query);
	if($row['password']==md5($password)){
		//set cookie for next visit if remember me checked in
		if(isset($_POST['remember'])){
			
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

			if(setcookie('ambitionbox',$array)){
				$sql = "INSERT INTO rememberedsessions(username,token) VALUES('$username','$token')";
			
				$query = mysql_query($sql);
				if($query){
					die("yes");
				}
			}
			
		}


		header('Location:success.php');
	}else{
		die("Username password combination incorrect");
	}
}else{
	//$query = mysql_query('SELECT ')
	echo "Some Problem occurred. Please try again";
}



?>