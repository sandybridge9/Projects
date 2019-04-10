<!DOCTYPE html>
<?php session_start(); ?>
<html>
	<body>
		
		<?php
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			$db = mysqli_connect("localhost", "root", "", "is") or die("Unable to connect to db");
			if(!$db){die ("Negaliu prisijungti prie MySQL:" .mysqli_error($db)); }
		}

		if(isset($_POST['avatar'])){
			$profile_id = $_POST['id'];
			echo"
			<form action='submit_avatar.php' method='POST'> 
				Link to new avatar: <br>
				<input type='text' name='link'>
				<br>
				<input type=\"hidden\" name=\"id\" value=".$profile_id.">
				<input type='submit' name='avatar' value='Submit'>
			</form>";
		}
		?>
	</body>
</html>