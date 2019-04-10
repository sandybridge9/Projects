<!DOCTYPE html>
<?php session_start(); 
$db = mysqli_connect("localhost", "root", "", "is") or die("Unable to connect to db");
		if(!$db){die ("Negaliu prisijungti prie MySQL:" .mysqli_error($db)); }
?>
<html>
	<head>
		<title>Game shop</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<style>
		img {
		display: block;
		max-width:300px;
		max-height:100px;
		}	

		div {
			width: 160px;
		}
		
		</style>
		<link rel="stylesheet" type="text/css" href="tableStyle.css">
		
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

		<br>
		<br>

		<div class= "title">
			GAMES LIST
		</div>

		<br>
		
		<div class="friends">
		<?php
			$userId = $_SESSION['user_id'];
			$sql = "SELECT * FROM draugai WHERE fk_vartotojas = ".$userId." OR fk_vartotojas1 = ".$userId."";
			$result = mysqli_query($db, $sql);	
			echo"
			<table>
			";
			$rowCount = 1;
			while($row = mysqli_fetch_assoc($result))
			{
				$friendId = $row['fk_vartotojas'];
				if ($friendId == $userId){
				$friendId = $row['fk_vartotojas1'];
				}

				$sql2 = "SELECT * FROM vartotojas WHERE id = ".$friendId."";
				$result2 = mysqli_query($db, $sql2);
				$friend_user = mysqli_fetch_assoc($result2);
				
				$sql3 = "SELECT * FROM vartotojo_profilis WHERE fk_vartotojas = ".$friendId."";
				$result3 = mysqli_query($db, $sql3);
				$friend_profile = mysqli_fetch_assoc($result3);

				if($rowCount % 8 == 0){
					echo"<tr> </tr>";
				}
				echo"
				<th>
					<div class=\"game\">
						<p> ".$friend_user['prisijungimo_vardas']." </p>";
						if ($friend_profile['paveikslelio_nuoroda']){
						echo"<img src=".$friend_profile['paveikslelio_nuoroda'].">";
						}
						echo"<form action='friend_games.php' method='POST'> 
						<input type=\"hidden\" name=\"id\" value=".$friend_user['id'].">
						<input type='submit' id='game' name='game' value='Games'>
						</form>
						<form action='friend_photos.php' method='POST'> 
						<input type=\"hidden\" name=\"id\" value=".$friend_profile['id'].">
						<input type='submit' id='pic' name='pic' value='Picture galleries'>
						</form>
						<form action='friend_reviews.php' method='POST'> 
						<input type=\"hidden\" name=\"id\" value=".$friend_user['id'].">
						<input type='submit' id='review' name='review' value='Reviews'>
						</form>
						<form action='friend_favorites.php' method='POST'> 
						<input type=\"hidden\" name=\"id\" value=".$friend_profile['id'].">
						<input type='submit' id='fav' name='fav' value='Favorites'>
						</form>
						<form action='friend_achievements.php' method='POST'> 
						<input type=\"hidden\" name=\"id\" value=".$friend_profile['id'].">
						<input type='submit' id='ach' name='ach' value='Achievements'>
						</form>
						<form action='remove_friend.php' method='POST'> 
						<input type=\"hidden\" name=\"id\" value=".$friend_profile['id'].">
						<input type='submit' id='remove' name='remove' value='Remove'>
						</form>
					</div>
				</th>
				";
				$rowCount = $rowCount + 1;
			} 	
			echo"
			</table>
			";
			?>
		</div>	

		<div class="add-friend">
			<?php
			echo"
			<form action='add_friend.php' method='POST'> 
			Friend username:
			<br>
			<input type='text' name='friend_name'>
			<br>
			<input type='submit' name='friend' value='Add friend'>
			</form>";
			?>
		</div>
	</body>
</html>