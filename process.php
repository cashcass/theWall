<?php
session_start();
include('./server.php');
$_SESSION['error']="";
$errName = "";
$errAddress = "";
$errEmail = "";
$errPhone = "";
$errDate = "";
$errUser = "";
$errConfirm = "";
$errPass = "";
$errLogin = "";
$valid = 0;
$errMatch="";
// // // // // // // // // // // // // // //  
//        REGISTRATION VERIFICATION       // 
// // // // // // // // // // // // // // // 
// var_dump($_POST);die();
if(isset($_POST['action'])&& $_POST['action'] == 'add'){

	if(preg_match("/^[A-Z][a-zA-Z -]+$/", $_POST['fname']) === 0){
		$errName = '<p class="errText">Names start with a capital; and may only contain letters, dashes, and spaces.</p>';
		$valid++;
	}
	if(preg_match("/^[A-Z][a-zA-Z -]+$/", $_POST['lname']) === 0){
		$errName = '<p class="errText">Names start with a capital; and may only contain letters, dashes, and spaces.</p>';
		$valid++;
	}
	$_SESSION['error'] .= $errName;

	if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false){
		$errEmail = '<p class="errText">The email address you entered was invalid.</p>';
		$valid++;
	}
	if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == true){
		$errEmail = '';
	}
	$_SESSION['error'].=$errEmail;
	if(preg_match("/[a-zA-Z0-9!@#$%^&*]/", $_POST['password']) == 0){
		$errPass = '<p class="errText">Passwords only contain lowercase and capital letters, number and special characters (!@#$%^&*).</p>';
		$valid++;
	}
	$_SESSION['error'].=$errPass;
	if($_POST['confirm']!=$_POST['password']){
		$errConfirm = '<p class="errText">Your passwords don\'t match!</p>';
		$valid++;
	}
	$_SESSION['error'].= $errConfirm;
///////////////////////////////
//   THIS ADDS A NEW USER    //
///////////////////////////////
	if($valid == 0){
		insert_new_user($_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['password']);
		$_SESSION['error'].='<p class="registered">Thank you for registering! You may now log in.</p>';
	}
	header('location: ./index.php');
}
/////////////////////////
//	   LOGIN CHECK     //
/////////////////////////
if(isset($_POST['action'])&& $_POST['action'] == 'login'){
	$query= 'SELECT * FROM users WHERE email = "'.($_POST['email']).'";';
	$user=fetch_record($query);

	if($user==null){
		$errLogin = "<p class='errText'>That email wasn't found in our database.</p>";
		$_SESSION['error'].= $errLogin;
		header('location: ./index.php');
	}
	else if($user['password']!=$_POST['password']){
		$errMatch = "<p class='errText'>The provided login info doesn't match.</p>";
		$_SESSION['error'].= $errMatch;
		header('location: ./index.php');
	}
	else{
		$_SESSION['user'] = $user;
		header('location: ./wall.php');
	}
}
////////////////////
//  SUBMIT A MSG  //
////////////////////
if($_POST['submission']=='comment'){
	$comment="INSERT INTO comments (comment,created_at,message_id,user_id) VALUES ('{$_POST['reply']}',NOW(),'{$_POST['msg_id']}','{$_SESSION['user']['id']}');";
	run_mysql_query($comment);
	header('location: ./wall.php');	
}
if($_POST['submission']=='msg'){
	$msg="INSERT INTO messages (message,created_at,user_id) VALUES ('{$_POST['msg']}',NOW(),'{$_SESSION['user']['id']}');";
	run_mysql_query($msg);
	header('location: ./wall.php');
}
?>