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
		$mysql = new mysqli("localhost", $GLOBALS["db_username"], $GLOBALS["db_password"],"webpr2016_marvin");
		
		
		
		$stmt = $mysql->prepare("SELECT id, name FROM users WHERE username=? and password=?");
		
		echo $mysql->error;
		
		$stmt->bind_param("ss", $user, $pass);
		
		$stmt->bind_result($id, $name);
		
		$stmt->execute();
		
		//get the data
		if($stmt->fetch()){
				echo "user with id".$id." logged in!";
				
			//create session variables
			//redirect user
			$_SESSION["name"] = $name;
			$_SESSION["user_id"] = $id;
			$_SESSION["username"] = $user;
			
			header("Location: restrict.php");
			
			
				
		}else{
			echo "wrong credentials";
		}
		
		
		
	}
	
	function signup($name, $user, $pass){
		
		//hash the password
		$pass = hash("sha512", $pass);
		
		//GLOBALS - access outsde variable in function
		$mysql = new mysqli("localhost", $GLOBALS["db_username"], $GLOBALS["db_password"],"webpr2016_marvin");
	
		$stmt = $mysql->prepare("INSERT INTO users (name, username, password) VALUES (?, ?, ?)");
		
			echo $mysql->error;
			
			
		$stmt->bind_param("sss", $name, $user, $pass);
		
		if($stmt->execute()){
			echo "user saved successfully!";
	}else{
		echo $stmt->error;
		}
		
		
		
}

	function saveInterest($interest) {
		
		$mysql = new mysqli("localhost", $GLOBALS["db_username"], $GLOBALS["db_password"],"webpr2016_marvin");
		
		$stmt = $mysql->prepare("INSERT INTO interests (name) VALUE (?)");
		
		echo $mysql->error;
		
		$stmt->bind_param("s", $interest);
		
		if($stmt->execute()){
			echo "inrterest saved successfully!";
		}else{
			echo $stmt->error;
		
		}
		
	}

	function createInterestDropdown(){
	
		//query all interests
		
		$mysql = new mysqli("localhost", $GLOBALS["db_username"], $GLOBALS["db_password"],"webpr2016_marvin");
	
		$stmt = $mysql->prepare("SELECT id, name FROM interests ORDER BY name ASC");
		
		echo $mysql->error;
		
		$stmt->bind_result($id, $name);
		
		$stmt->execute();
		
		//dropdown html
		$html = "<select name='user_interest'>";
		
		//for each interest
		while($stmt->fetch()){
			$html .= "<option value='".$id."'>".$name."</option>";
		}
		
		$html .="</select>";
		
		echo $html;
	}

	function saveUserInterest ($interest_id){
		
	$mysql = new mysqli("localhost", $GLOBALS["db_username"], $GLOBALS["db_password"],"webpr2016_marvin");
	
	$stmt = $mysql->prepare("INSERT INTO users_interests(user_id, interests_id) VALUES (?, ?");
	
	//$_SESSION ["user_id"] logged in user's ID
	$stmt->bind_param("ii", $_SESSION ,$interest_id);
	
	if($stmt->execute()){
			echo "saved successfully!";
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