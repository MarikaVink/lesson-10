<?php

	require_once("../../config.php");
	
	//start server session to store data
	//in every file you want to taccess session
	//you should reewquire functions
	session_start();
	
	
	function login($user, $pass){
		//hash the pass
		$pass = hash("sha512", $pass);
		
		//GLOBALS - access outsde variable in function
		$mysql = new mysqli("localhost",$GLOBALS["db_username"], $GLOBALS["db_password"],"webpr2016_marvin");
		
		
		
		$stmt = $mysql->prepare("SELECT id FROM users WHERE username=? and password=?");
		
		echo $mysql->error;
		
		$stmt->bind_param("ss", $user, $pass);
		
		$stmt->bind_result($id);
		
		$stmt->execute();
		
		//get the data
		if($stmt->fetch()){
				echo "user with id".$id." logged in!";
				
			//create session variables
			//redirect user
			$_SESSION["user_id"] = $id;
			$_SESSION["username"] = $user;
			
			header("Location: restrict.php");
			
			
				
		}else{
			echo "wrong credentials";
		}
		
		
		
	}
	
	function signup($user, $pass){
		
		//hash the password
		$pass = hash("sha512", $pass);
		
		//GLOBALS - access outsde variable in function
		$mysql = new mysqli("localhost",$GLOBALS["db_username"], $GLOBALS["db_password"],"webpr2016_marvin");
	
		$stmt = $mysql->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
		
			echo $mysql->error;
			
			
		$stmt->bind_param("ss", $user, $pass);
		
		if($stmt->execute()){
			echo "user saved successfully!";
	}else{
		echo $stmt->error;
		}
		
		
		
}
















	//example of simple function
	/*$name = "Marika";



	hello($name);


	function hello($received_name){
		echo "hello"." ".$received_name."!";
	}*/

?>