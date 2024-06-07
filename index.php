<?php
	include 'connection.php';
	session_start();
	$admin_id = $_SESSION['user_name'];
	$user_id = $_SESSION['user_id'];

	if (!isset($admin_id)) {
		header('location:login.php');
	}
	if (isset($_POST['logout'])) {
		session_destroy();
		header('location:login.php');
	}
	//adding product in wishlist
	if(isset($_POST['add_to_wishlist'])) {
		$product_id = $_POST['product_id'];
		$product_name = $_POST['product_name'];
		$product_price = $_POST['product_price'];
		$product_image = $_POST['product_image'];

		$wishlist_number = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name='$product_name' AND user_id = '$user_id'") or die('Запит не виконано');
		$cart_num = mysqli_query($conn, "SELECT * FROM `cart` WHERE name='$product_name' AND user_id = '$user_id'") or die('Запит не виконано');
		if (mysqli_num_rows($wishlist_number)>0) {
			$message[]='Ви вже додали цю книгу до "Улюблених"';
		}else{
			mysqli_query($conn, "INSERT INTO `wishlist`(`user_id`, `pid`, `name`, `price`, `image`) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')");
			$message[]='Цю книгу успішно додано до "Улюблених"';
		}
	}
	//adding product in cart
	if(isset($_POST['add_to_cart'])) {
		$product_id = $_POST['product_id'];
		$product_name = $_POST['product_name'];
		$product_price = $_POST['product_price'];
		$product_image = $_POST['product_image'];
		$product_quantity = $_POST['product_quantity'];

		$cart_num = mysqli_query($conn, "SELECT * FROM `cart` WHERE name='$product_name' AND user_id = '$user_id'") or die('Запит не виконано');
		if (mysqli_num_rows($cart_num)>0) {
			$message[]='Ви вже додали цю книгу до "Кошика"';
		}else{
			mysqli_query($conn, "INSERT INTO `cart`(`user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')");
				$message[]='Цю книгу успішно додано до "Кошика"';
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
	<title>veggen - home page</title>
</head>
<body>
	<?php include 'header.php';?>
	<div class="banner">
		<div class="detail">
			<h1>Головна</h1>
			<p>Книга домчить до будь-яких берегів. (Ч. Діккенс)</p>
		</div>
	</div>
	<div class="line4"></div>
	<?php
		if (isset($message)) {
			foreach ($message as $msg) {
				echo '
					<div class="message">
						<span>'.$msg.'</span>
						<i class="bx bx-x-circle close-msg" onclick="this.parentElement.remove()"></i>
					</div>
				';
			}
		}
	?>
	<!----------home slider----------->
	<?php include 'advertising.php';?>
	<!-------discover section------->
	<div class="line4"></div>
	<?php include 'homeshop.php';?>
	<div class="line2"></div>
	<?php include 'footer.php';?>


	<script type="text/javascript"><?php include 'script2.js'?></script>
</body>
</html>