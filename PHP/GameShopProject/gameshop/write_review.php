<!DOCTYPE html>
<?php session_start(); ?>
<html>
	<body>
		
		<?php
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			$db = mysqli_connect("localhost", "root", "", "is") or die("Unable to connect to db");
			if(!$db){die ("Negaliu prisijungti prie MySQL:" .mysqli_error($db)); }
		}

		if(isset($_POST['write'])){
			$game_id = $_POST['id'];
			$rate = 0;
			$date = date('Y-m-d H:i:s');
			echo"
			<form action='submit_review.php' method='POST'> 
				Review: <br>
				<textarea name='review' rows=\"4\" cols=\"50\"></textarea>
				<input type=\"hidden\" name=\"id\" value=".$game_id.">
				<br>
				Rating:
			<div class=\"input-group\">
			<select name=\"ivertinimas\">
			<option selected disabled>Ivertinimas</option>";					
			while($rate <= 10)
			{
				echo"<option value=".$rate.">".$rate."</option>";
				$rate++;
			}
			echo"
			</select>
			</div>
				<input type='submit' name='add' value='Submit review'>
			</form>";
		}
		?>
	</body>
</html>