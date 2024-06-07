<?php
	include 'connection.php';
	session_start();
	$admin_id = $_SESSION['user_name'];

	if (!isset($admin_id)) {
		header('location:login.php');
	}
	if (isset($_POST['logout'])) {
		session_destroy();
		header('location:login.php');
	}
	if (isset($_POST['submit-btn'])) {
		$name = mysqli_real_escape_string($conn, $_POST['name']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$number = mysqli_real_escape_string($conn, $_POST['number']);
		$message = mysqli_real_escape_string($conn, $_POST['message']);

		$select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name='$name' AND email='$email' AND number = '$number' AND message = '$message'") or die('Запит не виконано');
		if (mysqli_num_rows($select_message)>0){
			echo 'Повідомлення вже надіслано';
		}else{
			mysqli_query($conn, "INSERT INTO `message`(`user_id`, `name`, `email`, `number`, `message`) VALUES ('$user_id', '$name', '$email', '$number', '$message')") or die('Запит не виконано');
		}
	}
?>
<style type="text/css">
	<?php include 'main.css';?>
</style>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!----------bootstrap icon link----------->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
	<link rel="stylesheet" href="main.css" />
	<title>veggen - contact us</title>
</head>
<body>
	<?php include 'header.php';?>
	<div class="banner">
		<div class="detail">
			<h1>Зворотній зв'язок</h1>
			<p>Книга домчить до будь-яких берегів. (Ч. Діккенс)</p>
		</div>
	</div>
	<div class="line3"></div>
	<h1 class="title">Залиште повідомлення</h1>
	<div class="contact-container">
		<form method="post">
			<div class="input-field">
				<label>Ім'я</label><br>
				<input type="text" name="name">
			</div>
			<div class="input-field">
				<label>Email</label><br>
				<input type="text" name="email">
			</div>
			<div class="input-field">
				<label>Номер</label><br>
				<input type="number" name="number">
			</div>
			<div class="input-field">
				<label>Повідомлення</label><br>
				<textarea name="message"></textarea>
			</div>
			<button type="submit" name="submit-btn">Надіслати</button>
		</form>
	</div>
	<div class="line3"></div>

	<?php include 'footer.php';?>
	<script type="text/javascript" src="script.js"></script>
</body>
</html>