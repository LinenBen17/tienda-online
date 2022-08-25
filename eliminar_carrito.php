<?php
	session_start();
	
	if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {
		header("Location: carrito.php");
		die();
	}else{
		$id = $_GET['id'];

		if (isset($_SESSION['carrito'])) {
			unset($_SESSION['carrito'][$id]);
			header('Location: carrito.php');
			die();
		}else{
			header("Location: index.php");
			die();
		}
	}
?>