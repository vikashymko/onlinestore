<?php
	include 'connection.php';
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
			$message[]='Ви додали цю книгу до "Улюблених"';
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
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-------------------bootstrap icon link-------------------->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
	<!-------------------bootstrap css link-------------------->
	<!--box icon link-->
	<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
	<!-------------------default css link-------------------->
	<link rel="stylesheet" href="main.css">
	<title>Home page</title>
</head>
<body>
	<section class="popular-brands">
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
		<h1 class="title">Бестселлери</h1>
		<div class="controls">
			<button class="left" onclick="slide('left')"><i class="bi bi-chevron-left"></i></button>
			<button class="right" onclick="slide('right')"><i class="bi bi-chevron-right"></i></button>
		</div>
		<div class="popular-brands-content">
			<?php
				$select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('Запит не виконано');
				if (mysqli_num_rows($select_products) > 0) {
					while($fetch_products = mysqli_fetch_assoc($select_products)){
			?>
			<div class="card">
	            <img src="image/<?php echo $fetch_products['image'];?>">
	            <div class="price"><?php echo $fetch_products['price'];?> грн</div>
	            <div class="name"><?php echo $fetch_products['name'];?></div>
	            <div class="icon">
	                <a href="view_page.php?pid=<?php echo $fetch_products['id'];?>" class="bi bi-eye-fill"></a>
	                <form method="post" class="wishlist-form">
	                    <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
	                    <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
	                    <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
	                    <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
	                    <button type="submit" name="add_to_wishlist" class="bi bi-heart"></button>
	                </form>
	                <form method="post" class="cart-form">
	                    <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
	                    <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
	                    <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
	                    <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
	                    <input type="hidden" name="product_quantity" value="1">
	                    <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
	                </form>
	            </div>
	        </div>
			<?php
					}
				} else {
					echo "Книг поки немає";
				}
			?>
		</div>
	</section>

	<script>
		function slide(direction) {
			const container = document.querySelector('.popular-brands-content');
			const cardWidth = document.querySelector('.card').offsetWidth;
			const scrollAmount = direction === 'left' ? -cardWidth : cardWidth;

			let newScrollLeft = container.scrollLeft + scrollAmount;

			if (newScrollLeft < 0) {
				newScrollLeft = container.scrollWidth - container.clientWidth;
			} else if (newScrollLeft >= container.scrollWidth - container.clientWidth) {
				newScrollLeft = 0;
			}

			container.scrollTo({
				left: newScrollLeft,
				behavior: 'smooth'
			});
		}
	</script>
	<script type="text/javascript" src="script.js"></script>

</body>
</html>
