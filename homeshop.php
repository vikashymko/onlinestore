<?php
	include 'connection.php';
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
	<!-------------------default css link-------------------->
	<link rel="stylesheet" href="main.css">
	<title>veggen - home page</title>
</head>
<body>
	<section class="popular-brands">
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
				<div class="price">$<?php echo $fetch_products['price'];?>/-</div>
				<div class="name"><?php echo $fetch_products['name'];?></div>
				<div class="icon">
					<a href="view_page.php?pid=<?php echo $fetch_products['id'];?>" class="bi bi-eye-fill"></a>
					<button type="submit" name="add_to_wishlist" class="bi bi-heart"></button>
					<button type="submit" name="add_to_cart" class="bi bi-cart"></button>
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

			// Визначення нового значення scrollLeft
			let newScrollLeft = container.scrollLeft + scrollAmount;

			// Перевірка, чи дійшли до кінця контейнера
			if (newScrollLeft < 0) {
				// Якщо виходимо за лівий край, перемістимо на кінець справа
				newScrollLeft = container.scrollWidth - container.clientWidth;
			} else if (newScrollLeft >= container.scrollWidth - container.clientWidth) {
				// Якщо виходимо за правий край, перемістимо на початок зліва
				newScrollLeft = 0;
			}

			// Плавне прокручування до нового значення scrollLeft
			container.scrollTo({
				left: newScrollLeft,
				behavior: 'smooth'
			});
		}
	</script>

</body>
</html>
