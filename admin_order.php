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
	//delete products from database
	if (isset($_GET['delete'])){
		$delete_id = $_GET['delete'];
		
		mysqli_query($conn, "DELETE FROM `order` WHERE id='$delete_id'") or die('Запит не виконано');
		$message[] = 'order removed successfully';
		header('location:admin_order.php');
	}
	//updating payment status
	if (isset($_POST['update_order'])){
		$order_id = $_POST['order_id'];
		$update_payment = $_POST['update_payment'];

		mysqli_query($conn, "UPDATE `order` SET payment_status = '$update_payment' WHERE id = '$order_id'") or die('Запит не виконано');
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
	<title>admin pannel</title>
</head>
<body>
	<?php include 'admin_header.php';?>
	<?php
		if (isset($message)) {
			foreach($message as $message){
				echo '
					<div class="msg">
						<span>'.$msg.'</span>
						<i class="bi bi-x-circle" oneclick="this.parentElement.remove()"></i>
					</div>
				';
			}
		}
	?>
	<div class="line4"></div>
	<section class="order-container">
		<h1 class="title">Замовлення</h1>
		<div class="box-container">
			<?php
				$select_order = mysqli_query($conn, "SELECT * FROM `order`") or die('Запит не виконано');
				if(mysqli_num_rows($select_order)>0){
					while($fetch_order = mysqli_fetch_assoc($select_order)) {
			?>
			<div class="box">
				<p>Користувач: <span><?php echo $fetch_order['name'];?></span></p>
				<p>ID Користувача: <span><?php echo $fetch_order['user_id'];?></span></p>
				<p>Дата: <span><?php echo $fetch_order['placed_on'];?></span></p>
				<p>Номер: <span><?php echo $fetch_order['number'];?></span></p>
				<p>Email: <span><?php echo $fetch_order['email'];?></span></p>
				<p>Кількість книг: <span><?php echo $fetch_order['total_products'];?></span></p>
				<p>Ціна замовлення: <span><?php echo $fetch_order['total_price'];?></span></p>
				<p>Спосіб оплати: <span><?php echo $fetch_order['method'];?></span></p>
				<p>Адреса: <span><?php echo $fetch_order['address'];?></span></p>
				<form method="post">
					<input type="hidden" name="order_id" value="<?php echo $fetch_order['id'];?>">
					<select name="update_payment">
						<option disabled selected><?php echo $fetch_order['payment_status'];?></option>
						<option value="none"> </option>
						<option value="В обробці">В обробці</option>
						<option value="Виконано">Виконано</option>
					</select>
					<input type="submit" name="update_order" value="Оновити" class="btn">
					<a href="admin_order.php?delete=<?php echo $fetch_order['id'];?>;" onclick="return confirm('Видалити це замовлення');" class="delete">Видалити</a>
				</form>
			</div>
			<?php
					}
				}else{
						echo '
							<div class="empty">
								<p>Замовлень немає!</p>
							</div>
						';
				}
			?>
		</div>
	</section>
	<div class="line"></div>
	<script type="text/javascript" src="script.js"></script>
</body>
</html>