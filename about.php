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
	<title>veggen - about us</title>
</head>
<body>
	<?php include 'header.php';?>
	<div class="banner">
		<div class="detail">
			<h1>Про нас</h1>
			<p>Книга домчить до будь-яких берегів. (Ч. Діккенс)</p>
		</div>
	</div>
	<!----------about us----------->
    <div class="line2"></div>
    <div class="about-us">
    	<div class="row">
    		<div class="box">
    			<div class="title">
    				<span>Про нас</span>
    			</div>
    			<p>Це мережа книгарень та інтернет-магазин з асортиментом понад 20 000 книг та товарів. У нас ви можете придбати різноманітні книги, підручники, колекційні видання, розвиваючі ігри, товари для творчості та багато іншого. Ми популяризуємо книги українських авторів та видавництв. Для нас важливо розвивати книжковий ринок України та пропонувати якісні видання українським читачам.</p>
    		</div>
    		<div class="img-box">
    			<img src="img/about.jpg">
    		</div>
    	</div>
    </div>
	<?php include 'footer.php';?>
	<script type="text/javascript" src="script.js"></script>
</body>
</html>