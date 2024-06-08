<?php
	include 'connection.php';
	session_start();
	$admin_id = $_SESSION['admin_name'];

	if (!isset($admin_id)) {
		header('location:login.php');
	}
	if (isset($_POST['logout'])) {
		session_destroy();
		header('location:login.php');
	}
	//adding products
	if (isset($_POST['add_product'])){
		$product_name = mysqli_real_escape_string($conn, $_POST['name']);
		$product_author = mysqli_real_escape_string($conn, $_POST['author']);
		$product_price = mysqli_real_escape_string($conn, $_POST['price']);
		$product_category = mysqli_real_escape_string($conn, $_POST['category']);
		$product_detail = mysqli_real_escape_string($conn, $_POST['detail']);
		$image = $_FILES['image']['name'];
		$image_size = $_FILES['image']['size'];
		$image_tmp_name = $_FILES['image']['tmp_name'];
		$image_folder = 'image/'.$image;

		$select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name ='$product_name'") or die('Запит не виконано');
		if(mysqli_num_rows($select_product_name)>0){
			$message[] = 'Книга з такою назвою вже існує';
		}else{
			$insert_product = mysqli_query($conn, "INSERT INTO `products` (`name`, `author`, `category`, `price`, `product_detail`, `image`) VALUES ('$product_name', '$product_author', '$product_category', '$product_price', '$product_detail', '$image')") or die('Запит не виконано');
			if ($insert_product) {
				if ($image_size > 2000000) {
					$message[] = 'Зображення завелике';
				} else{
					move_uploaded_file($image_tmp_name, $image_folder);
					$message[] = 'Книгу успішно додано';
				}
			}
		}
	}
	//delete products
	if (isset($_GET['delete'])){
		$delete_id = $_GET['delete'];
		$select_delete_image = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('Запит не виконано');
		$fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
		unlink('image/'.$fetch_delete_image['image']);

		mysqli_query($conn, "DELETE FROM `products` WHERE id='$delete_id'") or die('Запит не виконано');
		mysqli_query($conn, "DELETE FROM `cart` WHERE pid='$delete_id'") or die('Запит не виконано');
		mysqli_query($conn, "DELETE FROM `wishlist` WHERE pid='$delete_id'") or die('Запит не виконано');

		header('location:admin_product.php');
	}
	//update product
	if (isset($_POST['update_product'])){
		$update_id = $_POST['update_id'];
		$update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
	    $update_author = mysqli_real_escape_string($conn, $_POST['update_author']);
	    $update_category = mysqli_real_escape_string($conn, $_POST['update_category']);
	    $update_price = mysqli_real_escape_string($conn, $_POST['update_price']);
	    $update_detail = mysqli_real_escape_string($conn, $_POST['update_detail']);
		$update_image = $_FILES['update_image']['name'];
		$update_image_tmp_name = $_FILES['update_image']['tmp_name'];
		$update_image_folder = 'image/'.$update_image;

		if (!empty($update_image)) {
        // Update with new image
        $update_query = "UPDATE `products` SET `name`='$update_name', `author`='$update_author', `category`='$update_category', `price`='$update_price', `product_detail`='$update_detail', `image`='$update_image' WHERE id='$update_id'";
        mysqli_query($conn, $update_query) or die('Запит не виконано');
        move_uploaded_file($update_image_tmp_name, $update_image_folder);
	    } else {
	    // Update without changing the image
	        $update_query = "UPDATE `products` SET `name`='$update_name', `author`='$update_author', `category`='$update_category', `price`='$update_price', `product_detail`='$update_detail' WHERE id='$update_id'";
	        mysqli_query($conn, $update_query) or die('Запит не виконано');
	    }

	    header('location:admin_product.php');
	}
?>
<style type="text/css">
	<?php include 'style.css';?>
</style>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
	<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Admin pannel</title>
</head>
<body>
	<?php include 'admin_header.php';?>
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
	<h1 class="title">Додати товар</h1>
	<section class="add-poducts form-container">
		<form method="POST" action="" enctype="multipart/form-data">
			<div class="input-field">
				<label>Назва</label>
				<input type="text" name="name" required>
			</div>
			<div class="input-field">
				<label>Автор</label>
				<input type="text" name="author" required>
			</div>
			<label>Категорія</label>
			<select name="category">
				<option value="none"></option>
				<option value="Детектив">Детектив</option>
				<option value="Роман">Роман</option>
				<option value="Триллер">Триллер</option>
				<option value="Художня література">Художня література</option>
				<option value="Поезія">Поезія</option>
				<option value="Сучасна проза">Сучасна проза</option>
				<option value="Класична проза">Класична проза</option>
				<option value="Фантастика">Фантастика</option>
				<option value="Фентезі">Фентезі</option>
				<option value="Міфи">Міфи</option>
				<option value="Історія">Історія</option>
				<option value="Нон-фікшн">Нон-фікшн</option>
			</select>
			<div class="input-field">
				<label>Ціна</label>
				<input type="text" name="price" required>
			</div>
			<div class="input-field">
				<label>Опис</label>
				<textarea name="detail" required></textarea>
			</div>
			<div class="input-field">
				<label>Зображення</label>
				<input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" required>
			</div>
			<input type="submit" name="add_product" value="Додати книгу" class="btn">
		</form>
	</section>
	<h1 class="title">Додані товари</h1>
	<section class="show-products">
		<div class="box-container">
			<?php
				$select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('Запит не виконано');
				if (mysqli_num_rows($select_products)>0){
					while($fetch_products = mysqli_fetch_assoc($select_products)){
			?>
			<div class="box" >
				<img src="image/<?php echo $fetch_products['image']; ?>">
				<h4><?php echo $fetch_products['name']; ?></h4>
				<p>Автор : <?php echo $fetch_products['author']; ?></p>
				<p>Категорія : <?php echo $fetch_products['category']; ?></p>
				<p>Ціна : <?php echo $fetch_products['price']; ?> грн</p>
				<details>
					<summary>Опис</summary>
					<?php echo $fetch_products['product_detail']; ?>
				</details>
				<a href="admin_product.php?edit=<?php echo $fetch_products['id']; ?>" class="edit">Змінити</a>
				<a href="admin_product.php?delete=<?php echo $fetch_products['id']; ?>" class="delete" onclick="return confirm('Видалити цю книгу');">Видалити</a>
			</div>
			<?php
					}
				}else{
						echo '
							<div class="empty">
								<p>Ще нічого не додано!</p>
							</div>
						';
				}
			?>
		</div>
	</section>
	<div class="line"></div>
	<section class="update-container">
		<?php
			if (isset($_GET['edit'])) {
				$edit_id = $_GET['edit'];
				$edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id='$edit_id'") or die('Запит не виконано');
				if (mysqli_num_rows($edit_query)>0) {
					while($fetch_edit = mysqli_fetch_assoc($edit_query)){

		?>
		<form method="POST" enctype="multipart/form-data">
			<img src="image/<?php echo $fetch_edit['image'];?>">
			<input type="hidden" name="update_id" value="<?php echo $fetch_edit['id']; ?>">
			<input type="text" name="update_name" value="<?php echo $fetch_edit['name']; ?>">
			<input type="text" name="update_author" value="<?php echo $fetch_edit['author']; ?>">
			<div class="input-field">
				<select name="update_category" required>
					<option value="none" <?php if($fetch_edit['category'] == 'none'){echo 'selected';} ?>></option>
					<option value="Детектив" <?php if($fetch_edit['category'] == 'detective'){echo 'selected';} ?>>Детектив</option>
					<option value="Роман" <?php if($fetch_edit['category'] == 'fiction'){echo 'selected';} ?>>Роман</option>
					<option value="Художня література" <?php if($fetch_edit['category'] == 'roman'){echo 'selected';} ?>>Художня література</option>
					<option value="Поезія" <?php if($fetch_edit['category'] == 'poetry'){echo 'selected';} ?>>Поезія</option>
					<option value="Сучасна проза" <?php if($fetch_edit['category'] == 'modern prose'){echo 'selected';} ?>>Сучасна проза</option>
					<option value="Класична проза" <?php if($fetch_edit['category'] == 'clasic prose'){echo 'selected';} ?>>Класична проза</option>
					<option value="Фантастика" <?php if($fetch_edit['category'] == 'fantastic'){echo 'selected';} ?>>Фантастика</option>
					<option value="Фентезі" <?php if($fetch_edit['category'] == 'fentesi'){echo 'selected';} ?>>Фентезі</option>
					<option value="Міфи" <?php if($fetch_edit['category'] == 'miths'){echo 'selected';} ?>>Міфи</option>
					<option value="Історія" <?php if($fetch_edit['category'] == 'history'){echo 'selected';} ?>>Історія</option>
					<option value="Нон-фікшн" <?php if($fetch_edit['category'] == 'non-fiction'){echo 'selected';} ?>>Нон-фікшн</option>
					<option value="Триллер" <?php if($fetch_edit['category'] == 'thriller'){echo 'selected';} ?>>Триллер</option>
				</select>
			</div>
			<input type="number" name="update_price" min="0" value="<?php echo $fetch_edit['price']; ?>">
			<textarea name="update_detail"><?php echo $fetch_edit['product_detail'];?></textarea>
			<input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png, image/webp">
			<input type="submit" name="update_product" value="Змінити" class="edit">
			<input type="reset" name="" value="Скасувати" class="option-btn btn" id="close-form">
		</form>
		<?php
					}
				}
				echo "<script>document.querySelector('.update-container').style.display='block'</script>";
			}
		?>
	</section>
	<script type="text/javascript" src="script.js"></script>
</body>
</html>