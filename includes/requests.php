<?php
	session_start(array(
		"cookie_lifetime" => 100000000
	));

	if (empty($_SESSION["user"]) == false) {
		if (file_exists($configuration["path"] . "database/users/" . $_SESSION["user"]["idHash"] . "/update")) {
			$encodedUserData = file_get_contents($configuration["path"] . "database/users/" . $_SESSION["user"]["idHash"] . "/data.json");

			if ($encodedUserData) {
				$decodedUserData = json_decode($encodedUserData, true);

				if ($decodedUserData) {
					$_SESSION["user"] = $decodedUserData;
					unlink($configuration["path"] . "database/users/" . $decodedUserData["idHash"] . "/update");
				}
			}
		}

		$decodedUserData = $_SESSION["user"];
	}

	if (empty($decodedUserData) == false) {
		$requestsDirectoryPath = $configuration["path"] . "database/requests/users/" . $decodedUserData["idHash"] . "/" ;
	} else {
		$requestsDirectoryPath = $configuration["path"] . "database/requests/visitors/" . $_SERVER["REMOTE_ADDR"] . "/";
	}

	if (is_dir($requestsDirectoryPath) == false) {
		mkdir($requestsDirectoryPath);
		chmod($requestsDirectoryPath, 0777);
	}

	touch($requestsDirectoryPath . time() . rand(0, 10000000));
	$requestsDirectoryPathFiles = scandir($requestsDirectoryPath);

	if ($requestsDirectoryPathFiles != false) {
		$requestsDirectoryPathFiles = array_values(array_diff($requestsDirectoryPathFiles, array("..", ".")));
		$requestsDirectoryPathFilesCount = count($requestsDirectoryPathFiles);
		unset($requestsDirectoryPathFiles);
		gc_collect_cycles();

		if ($requestsDirectoryPathFilesCount > $requestsLimit) {
			touch($configuration["path"] . "database/requests/attackers/" . $_SERVER["REMOTE_ADDR"]);
		} else {
			unset($requestsLimit);
		}
	} else {
		unset($requestsLimit);
	}
?>
