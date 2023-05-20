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
						if (isset($decodedData["input"]["userId"][99]) == false) {
							if (empty($decodedData["input"]["userPassword"]) == false) {
								if (isset($decodedData["input"]["userPassword"][99]) == false) {
									if (empty($decodedData["input"]["userPasswordConfirmation"]) == false) {
										if ($decodedData["input"]["userPasswordConfirmation"] == $decodedData["input"]["userPassword"]) {
											unset($decodedData["input"]["userPasswordConfirmation"]);
											$userIdHash = AvolittyHasher($decodedData["input"]["userId"] . $configuration["hashSalt"]);
											$userDirectoryPath = $configuration["path"] . "database/users/" . $userIdHash . "/";

											if (is_dir($userDirectoryPath) == false) {
												$decodedUserData = array(
													"id" => $decodedData["input"]["userId"],
													"idHash" => $userIdHash,
													"passwordHash" => AvolittyHasher($decodedData["input"]["userPassword"] . $configuration["hashSalt"]),
													"tier" => "free"
												);
												$encodedUserData = json_encode($decodedUserData);
												mkdir($userDirectoryPath);
												chmod($userDirectoryPath, 0777);
												$encodedUserDataFilePath = $userDirectoryPath . "data.json";

												if (
													$encodedUserData &&
													file_put_contents($encodedUserDataFilePath, $encodedUserData)
												) {
													$sessionIdFilePath = $configuration["path"] . "database/sessions/" . $decodedData["sessionId"];
													unlink($sessionIdFilePath);
													$temporarySessionId = AvolittyHasher($decodedUserData["id"] . time() . $configuration["hashSalt"]);
													$temporarySessionIdFilePath = $configuration["path"] . "database/sessions/" . $temporarySessionId;
													unlink($temporarySessionIdFilePath);

													if (
														link($encodedUserDataFilePath, $sessionIdFilePath) &&
														symlink($sessionIdFilePath, $temporarySessionIdFilePath)
													) {
														$decodedData["redirect"] = "/create-an-account/?sessionId=" . $temporarySessionId;
													} else {
														$decodedData["messages"]["global"] = "There was an error processing the request, try again.";
														rmdir($userDirectoryPath);
														unlink($sessionIdFilePath);
													}
												} else {
													$decodedData["messages"]["global"] = "There was an error processing the request, try again.";
													rmdir($userDirectoryPath);
												}
											} else {
												$decodedData["messages"]["userId"] = "User ID is already in use, try again.";
											}
										} else {
											$decodedData["messages"]["userPasswordConfirmation"] = "User Password Confirmation must match User Password, try again.";
										}
									} else {
										$decodedData["messages"]["userPasswordConfirmation"] = "User Password Confirmation is required, try again.";
									}
								} else {
									$decodedData["messages"]["userPassword"] = "User Password must be less than 100 characters, try again.";
								}
							} else {
								$decodedData["messages"]["userPassword"] = "User Password is required, try again.";
							}
						} else {
							$decodedData["messages"]["userId"] = "User ID must be less than 100 characters, try again.";
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
					"title" => "Create an Account",
				)
			),
			"title" => "Create an Account - Avolitty"
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
					<label for="user-password-confirmation">User Password Confirmation</label>
					<p class="hidden message" name="userPasswordConfirmation"></p>
					<input id="user-password-confirmation" name="userPasswordConfirmation" type="password">
				</div>
				<div>
					<a href="/sign-in/">Already have an account?</a>
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
