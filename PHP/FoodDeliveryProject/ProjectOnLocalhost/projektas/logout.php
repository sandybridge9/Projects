<?php
	session_start();
	unset($_SESSION["loggedin"]);
	header('Location: http://localhost/projektas/index.php');
?>