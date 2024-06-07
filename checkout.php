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
	if (isset($_POST['order_btn'])) {
		$name = mysqli_real_escape_string($conn, $_POST['name']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$number = mysqli_real_escape_string($conn, $_POST['number']);
		$method = mysqli_real_escape_string($conn, $_POST['method']);
		$address = mysqli_real_escape_string($conn, 'flat no.'.$_POST['flate'].','.$_POST['street'].','.$_POST['city'].','.$_POST['state'].','.$_POST['country'].','.$_POST['pin']);
		$placed_on = date('d-M-Y');
		$cart_total=0;
		$cart_product[]='';
		$cart_query=mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id") or die('Запит не виконано');

		if(mysqli_num_rows($cart_query)>0) {
			while($cart_item=mysqli_fetch_assoc($cart_query)){
				$cart_product[]=$cart_item['name'].'('.$cart_item['quantity'].')';
				$sub_total = ($cart_item['price'] * $cart_item['quantity']);
				$cart_total+=$sub_total;
			}
		}
		$total_products = implode(',', $cart_product);
		mysqli_query($conn, "INSERT INTO `order` (`user_id`,`name`,`number`,`email`,`method`,`address`,`total_products`,`total_price`,`placed_on`) VALUES ('$user_id', '$name','$number','$email','$method','$address','$total_product','$cart_total','$placed_on')");
		mysqli_query($conn, "DELETE FROM `cart` WHERE user_id='$user_id'");
		$message[]='Замовлення успішно оформлено';
		header('location:checkout.php');
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
	<title>veggen - checkout</title>
</head>
<body>
	<?php include 'header.php';?>
	<div class="banner">
		<div class="detail">
			<h1>Ваше замовлення</h1>
			<p>Книга домчить до будь-яких берегів. (Ч. Діккенс)</p>
		</div>
	</div>
	<div class="line"></div>
	<div class="checkout-form">
		<?php
			if(isset($message)){
				foreach ($message as $message){
					echo '
						<div class="message">
							<span>'.$message.'</span>
							<i class="bi bi-x-circle" oneclick="this.parentElement.remove()"</i>
						</div>
					';
				}
			}
		?>
		<div class="display-order">
			<div class="box-container">
				<?php
				$select_cart=mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('Запит не виконано');
				$total=0;
				$grand_total = 0;
				if (mysqli_num_rows($select_cart)>0) {
					while($fetch_cart=mysqli_fetch_assoc($select_cart)>0) {
						$total_price=($fetch_cart['price']*$fetch_cart['quantity']);
						$grand_total=$total+=$total_price;
				?>
					<div class="box">
						<img src="image/<?php echo $fetch_cart['image'];?>">
						<span><?= $fetch_cart['name']; ?> (<?= $fetch_cart['quantity'];?>)</span>
					</div>
				<?php
						}
					}
				?>
			</div>
			<span class="grand-total">Загальна сума: $ <?= $grand_total; ?></span>
		</div>
		<form method="post">
			<div class="input-field">
				<label>Ім'я</label>
				<input type="text" name="name" placeholder="Введіть ім'я">
			</div>
			<div class="input-field">
				<label>Номер</label>
				<input type="number" name="number" placeholder="Введіть номер">
			</div>
			<div class="input-field">
				<label>Email</label>
				<input type="text" name="email" placeholder="Введіть email">
			</div>
			<div class="input-field">
				<label>Виберіть метод оплати</label>
				<select name="method">
					<option selected disabled>none</option>
					<option value="cash on delivery">Готівка</option>
					<option value="credit card">Кредитна картка</option>
				</select>
			</div>
			<div class="input-field">
				<label>Номер будинку</label>
				<input type="text" name="flate" placeholder="Наприклад, 1">
			</div>
			<div class="input-field">
				<label>Вулиця</label>
				<input type="text" name="flate" placeholder="Наприклад, Грушевського">
			</div>
			<div class="input-field">
				<label>Місто</label>
				<input type="text" name="city" placeholder="Наприклад, Київ">
			</div>
			<div class="input-field">
				<label>Область</label>
				<input type="text" name="state" placeholder="Наприклад, Київська">
			</div>
			<div class="input-field">
				<label>Країна</label>
				<input type="text" name="country" placeholder="Наприклад, Україна">
			</div>
			<div class="input-field">
				<label>Індекс</label>
				<input type="text" name="flate" placeholder="Наприклад, 56530">
			</div>
			<input type="submit" name="order-btn" class="btn" value="Замовити">
		</form>
	</div>
	
	<?php include 'footer.php';?>
	<script type="text/javascript" src="script.js"></script>
</body>
</html>