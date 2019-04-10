<!DOCTYPE html>
<?php session_start(); ?>
<html>
	<body>
		
		<?php
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			$db = mysqli_connect("localhost", "root", "", "is") or die("Unable to connect to db");
			if(!$db){die ("Negaliu prisijungti prie MySQL:" .mysqli_error($db)); }
		}

		if(isset($_POST['friend'])){
			$friend_username = $_POST['friend_name'];
			$userId = $_SESSION['user_id'];	
			$sql = "SELECT * FROM vartotojas WHERE prisijungimo_vardas =\"".$friend_username."\"";
			echo $sql;
			$result = mysqli_query($db, $sql);	
			$friend = mysqli_fetch_assoc($result);	
			$friendId = $friend['id'];
			if ($friendId) {

				$sqlv = "SELECT * FROM vartotojo_profilis WHERE fk_vartotojas = ".$_SESSION['user_id']."";
				$resultv = mysqli_query($db, $sqlv);
				$profile = mysqli_fetch_assoc($resultv);
				$profileId = $profile['id'];
	
				$userId = $_SESSION['user_id'];
				$sqla = "INSERT INTO pasiekimas_vartotojo_profilis (fk_pasiekimas, fk_vartotojo_profilis) VALUES ( 3, '$profileId')";	
				mysqli_query($db, $sqla);

			$sql1 = "INSERT INTO draugai (fk_vartotojas, fk_vartotojas1) VALUES ('$userId', '$friendId')";
			mysqli_query($db, $sql1);
			}
			$_POST = null;
			header("Location:friendlist.php");
		}
		?>
	</body>
</html>