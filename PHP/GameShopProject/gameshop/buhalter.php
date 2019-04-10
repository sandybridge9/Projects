<!DOCTYPE html>
<?php session_start(); ?>
<html>
	<head>
		<title>Game shop</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	<head>
	
	<body>
		<div class= "title">
			<a href ="index.php"> GAME SHOP </a>
		</div>
		<div>		
			<?php
				if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
					$username = $_SESSION['username'];
					if($_SESSION['user_level'] == "registruotas_vartotojas"){
						echo "
						<div class=\"llu\">
							<a href=\"cart.php\"> Krepšelis </a>
							<a href=\"profile.php\"> $username </a>
							<a href=\"logout.php\"> Logout </a>
						</div>
						";
					}
					elseif($_SESSION['user_level'] == "administratorius"){
						echo "
						<div class=\"llu\">
							<a href=\"admin.php\"> Admin </a>
							<a href=\"profile.php\"> $username </a>
							<a href=\"logout.php\"> Logout </a>
						</div>
						";
					}
					elseif($_SESSION['user_level'] == "buhalteris"){
						echo "
						<div class=\"llu\">
							<a href=\"buhalter.php\"> Buhalter stuff </a>
							<a href=\"profile.php\"> $username </a>
							<a href=\"logout.php\"> Logout </a>
						</div>
						";
					}
				}else{
					echo "
						<div class=\"llu\">
							<a href=\"login.php\"> Login </a>
							<a href=\"register.php\"> Register </a>
						</div>
					";
				}
			?>
		</div>
		
		<div class="admin-group">
			<p><a href="buhalter_game_order_list.php"> Užsakymai </a></p>
			<p><a href="payment_edit.php"> Apmokėjimų administravimas </a></p>
			<p><a href="discount_edit.php"> Nuolaidų valdymas </a></p>
			<p><a href="bundle_edit.php"> Žaidimu kolekcijos valdymas </a></p>
			<p><a href="bundleGame_edit.php"> Žaidimų įdėjimas į žaidimų kolekcijas </a></p>
			<p><a href=""> Užsakymų ataskaitos</a></p>
		</div>
		
	</body>
</html>