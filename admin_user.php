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
	//delete products
	if (isset($_GET['delete'])){
		$delete_id = $_GET['delete'];
		
		mysqli_query($conn, "DELETE FROM `users` WHERE id='$delete_id'") or die('Запит не виконано');
		$message[] = 'Користувача успішно видалено';
		header('location:admin_user.php');
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
	<section class="message-container">
		<h1 class="title">Користувачі</h1>
		<div class="box-container">
			<?php
				$select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('Запит не виконано');
				if(mysqli_num_rows($select_users)>0){
					while($fetch_users = mysqli_fetch_assoc($select_users)) {
			?>
			<div class="box">
				<p>ID Користувача: <span><?php echo $fetch_users['id'];?></span></p>
				<p>Ім'я: <span><?php echo $fetch_users['name'];?></span></p>
				<p>Email: <span><?php echo $fetch_users['email'];?></span></p>
				<p>Роль: <span style="color:<?php if($fetch_users['user_type']=='admin'){echo '#a21caf';};?>"><?php echo $fetch_users['user_type'];?></span></p>
				<a href="admin_user.php?delete=<?php echo $fetch_users['id'];?>" onclick="return confirm('Видалити цього користувача');" class="delete">Видалити</a>
			</div>
			<?php
					}
				}else{
						echo '
							<div class="empty">
								<p>Користувачів ще немає!</p>
							</div>
						';
				}
			?>
		</div>
	</section>
	<div class="line"></div>
	<script type="text/javascript" src="script.js"></script>
</body>
</html>