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
	//delete products from database
	if (isset($_GET['delete'])){
		$delete_id = $_GET['delete'];
		
		mysqli_query($conn, "DELETE FROM `message` WHERE id='$delete_id'") or die('Запит не виконано');

		header('location:admin_message.php');
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
	<!--box icon link-->
	<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>admin pannel</title>
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
	<div class="line4"></div>
	<section class="message-container">
		<h1 class="title">Повідомлення</h1>
		<div class="box-container">
			<?php
				$select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('Запит не виконано');
				if(mysqli_num_rows($select_message)>0){
					while($fetch_message = mysqli_fetch_assoc($select_message)) {
			?>
			<div class="box">
				<p>ID: <span><?php echo $fetch_message['id'];?></span></p>
				<p>Ім'я: <span><?php echo $fetch_message['name'];?></span></p>
				<p>Email: <span><?php echo $fetch_message['email'];?></span></p>
				<p><?php echo $fetch_message['message'];?></p>
				<a href="admin_message.php?delete=<?php echo $fetch_message['id'];?>" onclick="return confirm('Видалити це повідомлення')" class="delete" ;>Видалити</a>
			</div>
			<?php
					}
				}else{
						echo '
							<div class="empty">
								<p>Повідомлень немає!</p>
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