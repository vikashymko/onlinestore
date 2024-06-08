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
	//adding product in cart
	if(isset($_POST['add_to_cart'])) {
		$product_id = $_POST['product_id'];
		$product_name = $_POST['product_name'];
		$product_price = $_POST['product_price'];
		$product_image = $_POST['product_image'];
		$product_quantity = 1;

		$cart_num = mysqli_query($conn, "SELECT * FROM `cart` WHERE name='$product_name' AND user_id = '$user_id'") or die('Запит не виконано');
		if (mysqli_num_rows($cart_num)>0) {
			$message[]='Ви вже додали цю книгу до "Кошика"';
		}else{
			mysqli_query($conn, "INSERT INTO `cart`(`user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')");
				$message[]='Цю книгу успішно додано до "Кошика"';
		}
	}
	//delete product from wishlist
	if (isset($_GET['delete'])){
		$delete_id = $_GET['delete'];
		mysqli_query($conn, "DELETE FROM `wishlist` WHERE id='$delete_id'") or die('Запит не виконано');

		header('location:wishlist.php');
	}
	//delete all products from wishlist
	if (isset($_GET['delete_all'])){
		mysqli_query($conn, "DELETE FROM `wishlist` WHERE user_id='$user_id'") or die('Запит не виконано');

		header('location:wishlist.php');
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
	<title>Wishlist</title>
</head>
<body>
	<?php include 'header.php';?>
	<div class="banner">
		<div class="detail">
			<h1>Улюблені</h1>
			<p>Книга домчить до будь-яких берегів. (Ч. Діккенс)</p>
		</div>
	</div>
	<div class="line"></div>
	<section class="shop">
		<h1 class="title">Книги, додані до "Улюблених"</h1>
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
			<div class="love-container">
			<?php
				$grand_total=0;
				$select_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist`") or die('Запит не виконано');
				if (mysqli_num_rows($select_wishlist)>0) {
					while($fetch_wishlist = mysqli_fetch_assoc($select_wishlist)){
			?>
			<form method="post" class="box">
				<img src="image/<?php echo $fetch_wishlist['image'];?>">
				<div class="price">$<?php echo $fetch_wishlist['price'];?>/-</div>
				<div class="name"><?php echo $fetch_wishlist['name'];?></div>
				<input type="hidden" name="product_id" value="<?php echo $fetch_wishlist['id'];?>">
				<input type="hidden" name="product_name" value="<?php echo $fetch_wishlist['name'];?>">
				<input type="hidden" name="product_price" value="<?php echo $fetch_wishlist['price'];?>">
				<input type="hidden" name="product_image" value="<?php echo $fetch_wishlist['image'];?>">
				<div class="icon">
					<a href="view_page.php?pid=<?php echo $fetch_wishlist['id'];?>" class="bi bi-eye-fill"></a>
					<a href="wishlist.php?delete=<?php echo $fetch_wishlist['id'];?>" class="bi bi-x" onclick="return confirm('Ви дійсно хочете видалити цю книгу з "Улюблених"')"></a>
					<button type="submit" name="add_to_cart" class="bi bi-cart"></button>
				</div>
			</form>
			<?php
					$grand_total+=(float)$fetch_wishlist['price'];
					}
				}else{
					echo '<p class="empty">Ви не додали жодної книги!</p>';
				}
			?>
		</div>
		<div class="wishlist_total">
			<p>Загальна сума: <span><?php echo $grand_total;?> грн</span></p>
			<a href="shop.php" class="btn">Продовжити перегляд</a>
			<a href="wishlist.php?delete_all" class="btn <?php echo ($grand_total)?'':'disabled'?>" onclick="return confirm('Ви дійсно хочете видалити все з "Улюблених"')">Видалити всі</a>
		</div>
	</section>
	<?php include 'footer.php';?>
	<script type="text/javascript" src="script.js"></script>
</body>
</html>