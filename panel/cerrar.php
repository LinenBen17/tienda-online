<?php

	session_start();

	$_SESSION['usuario_info'] = array();

	session_destroy();

	header("Location: index.php");
?>