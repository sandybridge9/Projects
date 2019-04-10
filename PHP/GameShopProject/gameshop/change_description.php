<!DOCTYPE html>
<?php session_start(); ?>
<html>
	<body>
		
		<?php
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			$db = mysqli_connect("localhost", "root", "", "is") or die("Unable to connect to db");
			if(!$db){die ("Negaliu prisijungti prie MySQL:" .mysqli_error($db)); }
		}

		if(isset($_POST['desc'])){
			$profile_id = $_POST['id'];
			echo"
			<form action='submit_description.php' method='POST'> 
				Description: <br>
				<textarea name='desc' rows=\"4\" cols=\"50\"></textarea>
				<input type=\"hidden\" name=\"id\" value=".$profile_id.">
				<br>
				<input type='submit' name='add' value='Submit'>
			</form>";
		}
		?>
	</body>
</html>