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
	if (isset($_POST['order-btn'])) {
		$name = mysqli_real_escape_string($conn, $_POST['name']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$number = mysqli_real_escape_string($conn, $_POST['number']);
		$method = mysqli_real_escape_string($conn, $_POST['method']);
		$address = mysqli_real_escape_string($conn, 'Буд. '.$_POST['flate'].', вулиця '.$_POST['street'].', '.$_POST['city'].', '.$_POST['state'].' область ,'.$_POST['country'].', '.$_POST['pin']);
		$placed_on = date('d-m-Y'); // Змінено формат дати
		$cart_total = 0;
		$cart_product = array();
		$cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('Запит не виконано');

		if (mysqli_num_rows($cart_query) > 0) {
			while ($cart_item = mysqli_fetch_assoc($cart_query)) {
				$cart_product[] = $cart_item['name'].'('.$cart_item['quantity'].')';
				$sub_total = ($cart_item['price'] * $cart_item['quantity']);
				$cart_total += $sub_total;
			}
		}
		$total_products = implode(',', $cart_product);
		$order_query = "INSERT INTO `orders` (`user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES ('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on', 'В обробці')";

		mysqli_query($conn, $order_query) or die('Запит не виконано');
		mysqli_query($conn, "DELETE FROM `cart` WHERE user_id='$user_id'") or die('Запит не виконано');

		$message[] = 'Замовлення успішно оформлено';
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
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
	<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
	<link rel="stylesheet" href="main.css" />
	<title>Checkout</title>
</head>
<body>
	<?php include 'header.php';?>
	<div class="banner">
		<div class="detail">
			<h1>Ваше замовлення</h1>
			<p>Книга домчить до будь-яких берегів. (Ч. Діккенс)</p>
		</div>
	</div>
	<div class="checkout-form">
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
		<div class="display-order">
			<div class="box-container">
				<?php
				$select_cart=mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('Запит не виконано');
				$total=0;
				$grand_total = 0;
				if (mysqli_num_rows($select_cart)>0) {
					while($fetch_cart=mysqli_fetch_assoc($select_cart)) {
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
			<span class="grand-total">Загальна сума: <?= $grand_total; ?> грн</span>
		</div>
		<form method="post">
			<div class="input-field">
				<label>Ім'я</label>
				<input type="text" name="name" placeholder="Введіть ім'я">
			</div>
			<div class="input-field">
				<label>Номер телефону</label>
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
					<option value="Готівка">Готівка</option>
					<option value="Кредитна картка">Кредитна картка</option>
				</select>
			</div>
			<div class="input-field">
				<label>Номер будинку</label>
				<input type="text" name="flate" placeholder="Наприклад, 1">
			</div>
			<div class="input-field">
				<label>Вулиця</label>
				<input type="text" name="street" placeholder="Наприклад, Грушевського">
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
				<input type="text" name="pin" placeholder="Наприклад, 56530">
			</div>
			<input type="submit" name="order-btn" class="btn" value="Замовити">
		</form>
	</div>
	
	<?php include 'footer.php';?>
	<script type="text/javascript" src="script.js"></script>
</body>
</html>