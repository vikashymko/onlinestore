<?php
	include 'connection.php';
	session_start();
	$admin_id = $_SESSION['admin_name'];

	if (!isset($admin_id)) {
		header('location:login.php');
	}
	if (isset($_POST['logout'])) {
		session_destroy();
		header('location:login.php');
	}
?>
<style type="text/css">
	<?php include 'style.css';?>
</style>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--box icon link-->
	<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Панель управління</title>
</head>
<body>
	<?php include 'admin_header.php';?>
	<div class="line4"></div>
	<section class="dashboard">
		<div class="box-container">
			<div class="box">
				<?php
					$select_pendings = mysqli_query($conn, "SELECT * FROM `order` WHERE payment_status = 'В обробці'") or die('Запит не виконано');
					$num_of_pendings = mysqli_num_rows($select_pendings);
				?>
				<h3><?php echo $num_of_pendings; ?></h3>
				<p>Замовлення в обробці</p>
			</div>
			<div class="box">
				<?php
					$select_completes = mysqli_query($conn, "SELECT * FROM `order` WHERE payment_status = 'Виконано'") or die('Запит не виконано');
					$num_of_completes = mysqli_num_rows($select_completes);
				?>
				<h3><?php echo $num_of_completes; ?></h3>
				<p>Виконані замовлення</p>
			</div>
			<div class="box">
				<?php
					$select_orders = mysqli_query($conn, "SELECT * FROM `order`") or die('Запит не виконано');
					$num_of_orders = mysqli_num_rows($select_orders);
				?>
				<h3><?php echo $num_of_orders; ?></h3>
				<p>Кількість замовлень</p>
			</div>
			<div class="box">
				<?php
					$select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('Запит не виконано');
					$num_of_products = mysqli_num_rows($select_products);
				?>
				<h3><?php echo $num_of_products; ?></h3>
				<p>Кількість доданих товарів</p>
			</div>
			<div class="box">
				<?php
					$select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('Запит не виконано');
					$num_of_users = mysqli_num_rows($select_users);
				?>
				<h3><?php echo $num_of_users; ?></h3>
				<p>Кількість покупців</p>
			</div>
			<div class="box">
				<?php
					$select_admin = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('Запит не виконано');
					$num_of_admin = mysqli_num_rows($select_admin);
				?>
				<h3><?php echo $num_of_admin; ?></h3>
				<p>Кількість адміністраторів</p>
			</div>
			<div class="box">
				<?php
					$select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('Запит не виконано');
					$num_of_users = mysqli_num_rows($select_users);
				?>
				<h3><?php echo $num_of_users; ?></h3>
				<p>Всього користувачів</p>
			</div>
			<div class="box">
				<?php
					$select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('Запит не виконано');
					$num_of_massege = mysqli_num_rows($select_message);
				?>
				<h3><?php echo $num_of_massege; ?></h3>
				<p>Нові повідомлення</p>
			</div>
		</div>
	</section>
	<script type="text/javascript" src="script.js"></script>
</body>
</html>