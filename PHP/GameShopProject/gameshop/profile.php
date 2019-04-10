<!DOCTYPE html>
<?php session_start(); 
$db = mysqli_connect("localhost", "root", "", "is") or die("Unable to connect to db");
		if(!$db){die ("Negaliu prisijungti prie MySQL:" .mysqli_error($db)); }
?>
<html>
	<head>
		<title>Game shop</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	<head>
	
	<style>
		h3 {
			text-align: center;
		}
		img {
			height:240px;
			width:240px;
		}
		
	</style>
	
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
			USER PROFILE
		</div>

		<br>
		<br>
		<br>
		
		<div class="profile-group">
			<?php
			$userId = $_SESSION['user_id'];
			$sql = "SELECT * FROM vartotojo_profilis WHERE fk_vartotojas = ".$userId."";	
			$result = mysqli_query($db, $sql);	
			$profile = mysqli_fetch_assoc($result);
			echo"
			<br><br>
			<table>
			  <tr>
				<td><h3>Avatar</h3></td>
			  </tr>
			  <tr>
				<th>
				<img src=".$profile['paveikslelio_nuoroda'].">
				<form action='change_avatar.php' method='POST'> 
				<input type=\"hidden\" name=\"id\" value=".$_SESSION['user_id'].">
				<input type='submit' id='avatar' name='avatar' value='Change avatar'>
				</form>
				</th>
			  </tr>
			  <tr>
				<td><h3>Profile description</h3></td>
			  </tr>
			  <tr>
				<td>".$profile['aprasas']."
				<form action='change_description.php' method='POST'> 
				<input type=\"hidden\" name=\"id\" value=".$_SESSION['user_id'].">
				<input type='submit' id='desc' name='desc' value='Change description'>
				</td>
			  </tr>
			  <tr>
				<td>
				<a href=\"gamelist.php\">Game list</a>
				</td>
			  </tr>
			  <tr>
				<td>
				<a href=\"friendlist.php\">Friends list</a>
				</td>
			  </tr>
			  <tr>
				<td>
				<a href=\"picturegalery.php\">Photo gallery</a>
				</td>
			  </tr>
			  <tr>
				<td>
				<a href=\"reviews.php\">Reviews</a>
				</td>
			  </tr>
			  <tr>
				<td>
				<a href=\"favoritegames.php\">Favorite games</a>
				</td>
			  </tr>
			  <tr>
				<td>
				<a href=\"achevements.php\">Achievements</a>
				</td>
			  </tr>
			</table>";
			?>
		</div>
		
	</body>
</html>