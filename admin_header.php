<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
	<title>Document</title>
</head>
<body>
	<header class="header">
		<div class="flex">
			<nav class="navbar">
				<a href="admin_pannel.php">Головна</a>
				<a href="admin_product.php">Товари</a>
				<a href="admin_order.php">Замовлення</a>
				<a href="admin_user.php">Користувачі</a>
				<a href="admin_message.php">Повідомлення</a>				
			</nav>
			<div class="icons">
				<i class="bi bi-person" id="user-btn"></i>
				<i class="bi bi-list" id="menu-btn"></i>
			</div>
			<div class="user-box">
				<p>Користувач: <span><?php echo $_SESSION['admin_name'];?></span></p>
				<p>Email: <span><?php echo $_SESSION['admin_email'];?></span></p>
				<form method="post">
					<button type="submit" name="logout" class="logout-btn">Вийти</button>
				</form>
			</div>
		</div>
	</header>
	<div class="banner">
		<div class="detail">
			<h1>Панель управління</h1>
			<p>Книга домчить до будь-яких берегів. (Ч. Діккенс)</p>
		</div>
	</div>
	<div class="line"></div>
</body>
</html>