<?php
session_start();
include('./server.php');
$messages = array();
$comments = array();

$query = 'SELECT messages.id as messageID, users.fname, messages.created_at, messages.message FROM messages left join users on messages.user_id=users.id;';
$messages=fetch_all($query);

//$query_comments = 'SELECT * FROM comments left join messages on messages.id=comments.message_id left join users on comments.user_id=users.id;';
$query_comments = 'SELECT comments.comment, messages.created_at,comments.created_at as comment_time, users.fname,comments.message_id,messages.id,users.id as users_id
FROM comments left join messages on messages.id=comments.message_id left join users on comments.user_id=users.id;';

$comments = fetch_all($query_comments);


?>

<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
	*{
		font-family: arial,sans-serif;
	}
	html{
		background-color: whitesmoke;	
	}
	#container{
		width: 1000px;
		margin: 0 auto;
	}
	#msg-group{
		min-height: 160px;
		margin: 20px 0 0 0;
		margin-left: auto;
		margin-right: auto;
		width: 585px;
	}
	#header{
		background-color: darkgrey;
	}
	h1{
		margin: 10px 400px 0 20px;
		padding: 0;
		display: inline-block;
	}
	#login{
		display: inline-block;
		width: 150px;
		padding: 20px 0 0 10px;
		background-color: blue;
		width: 200px;
		height: 50px;
		vertical-align: top;
	}
	#logout{
		display: inline-block;
		vertical-align: top;
	}
	.msg-label{
		font-weight: bold;
		font-size: 18px;
	}
	.msg-box{
		border-color: solid	black 2px;
		font-size: 16px;
	}
	#space{
		min-height: 500px;
		background-color: lightgreen;
	}
	.messages{
		border: solid black 1px;
		background-color: rgb(200,100,100)
	}
	.messages p{
		text-indent: 15px;
		margin: 10px 0 0 0;
	}
	.comments{
		background-color: lightblue;
		margin-left: 20px;
	}
	</style>
	<title>Wall</title>
</head>
<body>
<div id="container">
	<div id="header">
		<h1>Coding Dojo Wall</h1>
		<div id="login">
			Welcome <?php echo $_SESSION['user']['fname'] ;?>
		</div>
		<div id="logout">
			<a href="#">Log out</a>
		</div>
	</div>
	<div id="msg-group">
		<form method="post" action="./process.php">
			<div><label for="msg" class="msg-label">Submit a message: </label></div>
			<input type="hidden" name="submission" value="msg">
			<textarea name="msg" class="msg-box" value="" rows="5" cols="80"></textarea>
			<input type="submit" name="Submit">
		</form>
	</div>
	<div id="space">
		<?php foreach($messages as $message){?>
			<div class="messages">
			<h4><?=$message['fname']?> - <?=$message['created_at']?>  </h4>
 			<p><?= $message['message']?></p>
<?php 			foreach($comments as $comment){
					if ($comment['message_id'] == $message['messageID']){?>
 				<div class="comments"><h4><?=$comment['fname']?> - <?=$comment['comment_time']?>  </h4>
 					<p><?= $comment['comment']?></p>
 				</div>
<?php 				}
				}?>
				<form method="post" action="./process.php">
					<input type="hidden" name="submission" value="comment">
					<input type='hidden' value="<?=$message['messageID']?>" name='msg_id'>
					<label for="reply">Post a reply: </label>
					<textarea name="reply" cols="60"></textarea>
					<input type="submit" name="Reply">
				</form>
 			</div>
<?php      } ?>
	</div>
<div>
</body>
</html>
	