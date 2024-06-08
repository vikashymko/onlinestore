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
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
	<link rel="stylesheet" href="main.css" />
	<title>Order</title>
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
				$select_orders=mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id='$user_id'") or die('Запит не виконано');
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
				<p>Сума: <span><?php echo $fetch_orders['total_price'];?> грн</span></p>
				<p>Статус: <span><?php echo $fetch_orders['payment_status'];?></span></p>
			</div>
			<?php
					}
				}else{
					echo '
						<div class"empty">
							<p>Ви ще нічого не замовили!</p>
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