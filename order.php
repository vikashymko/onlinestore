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
	$user_id = $_SESSION['user_id'];
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
	<title>veggen - order</title>
</head>
<body>
	<?php include 'header.php';?>
	<div class="banner">
		<div class="detail">
			<h1>Ваші замовлення</h1>
			<p>Книга домчить до будь-яких берегів. (Ч. Діккенс)</p>
		</div>
	</div>
	<div class="order-section">
		<div class="box-container">
			<?php
				$select_orders=mysqli_query($conn, "SELECT * FROM `order` WHERE user_id='$user_id'") or die('Запит не виконано');
				if (mysqli_num_rows($select_orders)>0) {
					while($fetch_orders = mysqli_fetch_assoc($select_orders)) {				
			?>
			<div class="box">
				<p>Дата: <span><?php echo $fetch_orders['placed_on'];?></span></p>
				<p>Ім'я: <span><?php echo $fetch_orders['name'];?></span></p>
				<p>Номер: <span><?php echo $fetch_orders['number'];?></span></p>
				<p>Email: <span><?php echo $fetch_orders['email'];?></span></p>
				<p>Адреса: <span><?php echo $fetch_orders['address'];?></span></p>
				<p>Спосіб оплати: <span><?php echo $fetch_orders['method'];?></span></p>
				<p>Ваше замовлення: <span><?php echo $fetch_orders['total_products'];?></span></p>
				<p>Сума: <span><?php echo $fetch_orders['total_price'];?></span></p>
				<p>Статус: <span><?php echo $fetch_orders['payment_status'];?></span></p>
			</div>
			<?php
					}
				}else{
					echo '
						<div class"empty">
							<p>no order placed yet!</p>
						</div>
					';
				}
			?>
		</div>
	</div>
	
	<?php include 'footer.php';?>
	<script type="text/javascript" src="script.js"></script>
</body>
</html>