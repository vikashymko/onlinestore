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
	//updating qty
	if (isset($_POST['update_qty_btn'])){
		$update_qty_id = $_POST['update_qty_id'];
		$update_value = $_POST['update_qty'];

		$update_query = mysqli_query($conn, "UPDATE `cart` SET quantity='$update_value' WHERE id='$update_qty_id'") or die('Запит не виконано');
		if ($update_query){
			header('location:cart.php');
		}
	}
	//delete product from wishlist
	if (isset($_GET['delete'])){
		$delete_id = $_GET['delete'];
		mysqli_query($conn, "DELETE FROM `cart` WHERE id='$delete_id'") or die('Запит не виконано');

		header('location:cart.php');
	}
	//delete product from wishlist
	if (isset($_GET['delete_all'])){
		mysqli_query($conn, "DELETE FROM `cart` WHERE user_id='$user_id'") or die('Запит не виконано');

		header('location:cart.php');
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
	<title>veggen - our shop</title>
</head>
<body>
	<?php include 'header.php';?>
	<div class="banner">
		<div class="detail">
			<h1>Кошик</h1>
			<p>Книга домчить до будь-яких берегів. (Ч. Діккенс)</p>
		</div>
	</div>
	<div class="line"></div>
	<!----------about us----------->
	<section class="shop">
		<h1 class="title">Книги, додані до кошика</h1>
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
			<div class="box-container">
			<?php
				$grand_total=0;
				$select_cart = mysqli_query($conn, "SELECT * FROM `cart`") or die('Запит не виконано');
				if (mysqli_num_rows($select_cart)>0) {
					while($fetch_cart = mysqli_fetch_assoc($select_cart)){
			?>
			<div class="box">
				<img src="image/<?php echo $fetch_cart['image'];?>">
				<div class="icon">
					<a href="view_page.php?pid=<?php echo $fetch_cart['id'];?>" class="bi bi-eye-fill"></a>
					<a href="cart.php?delete=<?php echo $fetch_cart['id'];?>" class="bi bi-x" onclick="return confirm('do you want to delete this product from you wishlist')"></a>
					<button type="submit" name="add_to_cart" class="bi bi-cart"></button>
				</div>
				<div class="price">$<?php echo $fetch_cart['price'];?>/-</div>
				<div class="name"><?php echo $fetch_cart['name'];?></div>
				<form method="post">
					<input type="hidden" name="update_qty_id" value="<?php echo $fetch_cart['id'];?>">
					<div class="qty">
						<input type="number" min="1" name="update_qty" value="<?php echo $fetch_cart['quantity'];?>">
						<input type="submit" name="update_qty_btn" value="Оновити">
					</div>
				</form>
				<div class="total-amt">
					Сума : <span><?php echo $total_amt = ((float)$fetch_cart['price']*(float)$fetch_cart['quantity'])?></span>
				</div>
			</div>
			<?php
					$grand_total+=$total_amt;
					}
				}else{
					echo '<p class="empty">Ще не додано жодної книги!</p>';
				}
			?>
		</div>
		<div class="dlt">
			<a href="cart.php?delete_all" class="btn2" onclick="return confirm('Ви дійсно хочете видалити всі книги з кошика')">Видалити все</a>
		</div>
		<div class="wishlist_total">
			<p>Загальна сума: <span>$<?php echo $grand_total;?>/-</span></p>
			<a href="shop.php" class="btn">Продовжити перегляд</a>
			<a href="checkout.php" class="btn <?php echo ($grand_total>1)?'':'disabled'?>">Купити</a>
		</div>
	</section>
	<div class="line4"></div>
	<?php include 'footer.php';?>
	<script type="text/javascript" src="script.js"></script>
</body>
</html>