<?php
	session_start(array(
                "cookie_lifetime" => 100000000
        ));

	if (empty($_SESSION["id"]) == false) {
		unlink("../../database/sessions/" . $_SESSION["id"]);
		unset($_SESSION["id"]);
		unset($_SESSION["user"]);
		header("Location: /", true, 301);
	} else {
		require_once("../../configuration.php");
		require_once($configuration["path"] . "includes/header.php");
	}

	exit;
?>
