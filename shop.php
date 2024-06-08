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
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
	<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
	<link rel="stylesheet" href="main.css" />
	<title>Our shop</title>
</head>
<body>
	<?php include 'header.php';?>
	<div class="banner">
		<div class="detail">
			<h1>Магазин</h1>
			<p>Книга домчить до будь-яких берегів. (Ч. Діккенс)</p>
		</div>
	</div>
	<section class="shop">
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
		<div class="box-container">
			<?php
				$select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('Запит не виконано');
				if (mysqli_num_rows($select_products)>0) {
					while($fetch_products = mysqli_fetch_assoc($select_products)){
			?>
			<form method="post" class="box">
				<img src="image/<?php echo $fetch_products['image'];?>">
				<div class="price"><?php echo $fetch_products['price'];?> грн</div>
				<div class="name"><?php echo $fetch_products['name'];?></div>
				<input type="hidden" name="product_id" value="<?php echo $fetch_products['id'];?>">
				<input type="hidden" name="product_name" value="<?php echo $fetch_products['name'];?>">
				<input type="hidden" name="product_price" value="<?php echo $fetch_products['price'];?>">
				<input type="hidden" name="product_quantity" value="1" min="1">
				<input type="hidden" name="product_image" value="<?php echo $fetch_products['image'];?>">
				<div class="icon">
					<a href="view_page.php?pid=<?php echo $fetch_products['id'];?>" class="bi bi-eye-fill"></a>
					<button type="submit" name="add_to_wishlist" class="bi bi-heart"></button>
					<button type="submit" name="add_to_cart" class="bi bi-cart"></button>
				</div>
			</form>
			<?php
					}
				}else{
					echo '<p class="empty">Ви не додали жодної книги!</p>';
				}
			?>
		</div>
	</section>
	<?php include 'footer.php';?>
	<script type="text/javascript" src="script.js"></script>
</body>
</html>