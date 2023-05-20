<?php
	require_once("../../configuration.php");
	require_once("../../includes/modules/avolitty-hasher.php");

	if (empty($_POST["encodedData"]) == false):
		header("Access-Control-Allow-Origin: https://" . $configuration["domain"]);
		header("Content-type: application/json");
		$requestsLimit = 2;
		require_once("../../includes/requests.php");

		if (empty($requestsLimit)) {
			$decodedData = json_decode($_POST["encodedData"], true);

			if (empty($decodedData) == false) {
				$decodedData["messages"] = array();

				if (empty($decodedData["sessionId"] == false)) {
					if (empty($decodedData["input"]["userId"]) == false) {
						if (empty($decodedData["input"]["userPassword"]) == false) {
							$userIdHash = AvolittyHasher($decodedData["input"]["userId"] . $configuration["hashSalt"]);
							$userDirectoryPath = $configuration["path"] . "database/users/" . $userIdHash . "/";

							if (is_dir($userDirectoryPath)) {
								$encodedUserDataFilePath = $userDirectoryPath . "data.json";
								$encodedUserData = file_get_contents($encodedUserDataFilePath);

								if ($encodedUserData) {
									$decodedUserData = json_decode($encodedUserData, true);

									if ($decodedUserData) {
										if ($decodedUserData["passwordHash"] == AvolittyHasher($decodedData["input"]["userPassword"] . $configuration["hashSalt"])) {
											$sessionIdFilePath = $configuration["path"] . "database/sessions/" . $decodedData["sessionId"];
											unlink($sessionIdFilePath);
											$temporarySessionId = AvolittyHasher($userData["id"] . time() . $configuration["hashSalt"]);
											$temporarySessionIdFilePath = $configuration["path"] . "database/sessions/" . $temporarySessionId;
											unlink($temporarySessionIdFilePath);

											if (
												link($encodedUserDataFilePath, $sessionIdFilePath) &&
												symlink($sessionIdFilePath, $temporarySessionIdFilePath)
											) {
												$decodedData["redirect"] = "/sign-in/?sessionId=" . $temporarySessionId;
											} else {
												$decodedData["messages"]["global"] = "There was an error processing the request, try again.";
												unlink($sessionIdFilePath);
											}
										} else {
											$decodedData["messages"]["global"] = "User ID or User Password is invalid, try again.";
										}
									} else {
										$decodedData["messages"]["global"] = "There was an error processing the request, try again.";
									}
								} else {
									$decodedData["messages"]["global"] = "There was an error processing the request, try again.";
								}
							} else {
								$decodedData["messages"]["global"] = "User ID or User Password is invalid, try again.";
							}
						} else {
							$decodedData["messages"]["userPassword"] = "User Password is required, try again.";
						}
					} else {
						$decodedData["messages"]["userId"] = "User ID is required, try again.";
					}
				} else {
					$decodedData["messages"]["global"] = "Cookies are required, try again.";
				}
			} else {
				$decodedData = array(
					"messages" => array(
						"global" => "There was an error processing the request, try again."
					)
				);
			}
		} else {
			$decodedData = array(
				"messages" => array(
					"global" => "Requests limit of " . $requestsLimit . " per minute exceeded, wait 1 minute and try again."
				)
			);
		}

		unset($decodedData["input"]);
		$encodedData = json_encode($decodedData);

		if ($encodedData == false) {
			$encodedData = "{\"messages\": {\"global\": \"There was an error processing the request, try again.\"}}";
		}

		echo $encodedData;
		exit;
	else:
		$parameters = array(
			"breadcrumbs" => array(
				array(
					"title" => "Sign In",
				)
			),
			"title" => "Sign In - Avolitty"
		);
		require_once("../../includes/header.php");

		if (empty($_SESSION["id"]) == false) {
			$data["redirect"] = "/dashboard/";
		}

		if (
			empty($_GET["sessionId"]) == false &&
			is_link($configuration["path"] . "database/sessions/" . $_GET["sessionId"])
		) {
			$temporarySessionIdFilePath = $configuration["path"] . "database/sessions/" . $_GET["sessionId"];
			$sessionIdFilePath = readlink($temporarySessionIdFilePath);
			unlink($temporarySessionIdFilePath);

			if ($sessionIdFilePath) {
				$sessionId = basename($sessionIdFilePath);
				$encodedUserData = file_get_contents($sessionIdFilePath);
				unlink($sessionIdFilePath);

				if ($encodedUserData) {
					$decodedUserData = json_decode($encodedUserData, true);

					if (
						$decodedUserData &&
						symlink($configuration["path"] . "database/users/" . $decodedUserData["idHash"], $sessionIdFilePath)
					) {
						$_SESSION["id"] = $sessionId;
						$_SESSION["user"] = $decodedUserData;
						$data["redirect"] = "/dashboard/";
					} else {
						$data["messages"]["global"] = "There was an error processing the request, try again.";
					}
				} else {
					$data["messages"]["global"] = "There was an error processing the request, try again.";
				}
			} else {
				$data["messages"]["global"] = "There was an error processing the request, try again.";
			}
		}
?>
	<main>
		<?php require_once("../../includes/breadcrumbs.php"); ?>
		<section>
			<div class="container form">
<?php if (empty($data["messages"]["global"]) == true): ?>
				<p class="hidden message" name="global"></p>
<?php else: ?>
				<p class="message" name="global"><?php echo $data["messages"]["global"]; ?></p>
<?php endif; ?>
				<div>
					<label for="user-id">User ID</label>
					<p class="hidden message" name="userId"></p>
					<input id="user-id" name="userId" type="text">
				</div>
				<div>
					<label for="user-password">User Password</label>
					<p class="hidden message" name="userPassword"></p>
					<input id="user-password" name="userPassword" type="password">
				</div>
				<div>
					<a href="/create-an-account/">Don't have an account?</a>
				</div>
				<span class="button">Submit</span>
			</div>
		</section>
	</main>
<?php
	require_once("../../includes/javascript.php");
	require_once("../../includes/footer.php");
	endif;
?>
