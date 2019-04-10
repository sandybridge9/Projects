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
							<a href=\"cart.php\"> KrepÅ¡elis </a>
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
			<p><a href="admin_games_data_edit.php"> Žaidimų registracija/redagavimas </a></p>
			<p><a href="admin_game_order_data_edit.php"> Žaidimų užsakymų registracija/redagavimas </a></p>
			<p><a href="admin_developer_data_edit.php"> Žaidimų  kūrėjų registracija/redagavimas </a></p>
			<p><a href="newspapers.php"> Naujienlaiškiai </a></p>
			<p><a href="game_search.php"> Žaidimų paieška </a></p>
			<p>" "</p>
			
			
			<p><a href="admin_users_edit.php"> Vartotojų redagavimas</a></p>					
			<p><a href=""> Ataskaitos </a></p>
			<p><a href=""> Reklamų siuntimas </a></p>
		</div>
		
	</body>
</html>