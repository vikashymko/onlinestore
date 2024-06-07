<?php
	$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap Icons link -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
	<title>Document</title>
</head>
<body>
	<header class="header">
		<div class="flex">
			<nav class="navbar">
				<a href="index.php">Головна</a>
				<a href="about.php">Про нас</a>
				<a href="shop.php">Магазин</a>
				<a href="order.php">Замовлення</a>
				<a href="contact.php">Зв'язок</a>
			</nav>
			<div class="icons">
				<i class="bi bi-person" id="user-btn"></i>
				<?php
					$select_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id='$user_id'") or die('Запит не виконано');
					$wishlist_num_rows = mysqli_num_rows($select_wishlist);
				?>
				<a href="wishlist.php"><i class="bi bi-heart"></i><sup><?php echo $wishlist_num_rows;?></sup></a>
				<?php
					$select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('Запит не виконано');
					$cart_num_rows = mysqli_num_rows($select_cart);
				?>
				<a href="cart.php"><i class="bi bi-cart"></i><sup><?php echo $cart_num_rows;?></sup></a>
				<i class="bi bi-list" id="menu-btn"></i>
			</div>
			<div class="user-box">
				<p>Користувач : <span><?php echo $_SESSION['user_name'];?></span></p>
				<p>Email : <span><?php echo $_SESSION['user_email'];?></span></p>
				<form method="post">
					<button type="submit" name="logout" class="logout-btn">Вийти</button>
				</form>
			</div>
		</div>
	</header>
</body>
</html>