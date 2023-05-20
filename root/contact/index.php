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

				if (empty($decodedData["input"]["contactEmail"]) == false) {
					if (empty($decodedData["input"]["contactMessage"]) == false) {
						if (strlen(utf8_decode($decodedData["input"]["contactMessage"])) < 9999) {
							$decodedMessageData = array(
								"email" => $decodedData["input"]["contactEmail"],
								"message" => $decodedData["input"]["contactMessage"]
							);
							$encodedMessageData = json_encode($decodedMessageData);

							if ($encodedMessageData != false) {
								if (file_put_contents($configuration["path"] . "database/messages/" . AvolittyHasher($decodedMessageData["email"] . time() . $configuration["hashSalt"]) . ".json", $encodedMessageData)) {
									$decodedData["messages"]["global"] = "Message sent successfully.";
								} else {
									$decodedData["messages"]["global"] = "There was an error processing the request, try again.";
								}
							} else {
								$decodedData["messages"]["global"] = "There was an error processing the request, try again.";
							}
						} else {
							$decodedData["messages"]["contactMessage"] = "Message must be less than 10000 characters, try again.";
						}
					} else {
						$decodedData["messages"]["contactMessage"] = "Message is required, try again.";
					}
				} else {
					$decodedData["messages"]["contactEmail"] = "Email is required, try again.";
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
					"title" => "Contact",
				)
			),
			"title" => "Contact - Avolitty"
		);
		require_once("../../includes/header.php");
?>
	<main>
		<?php require_once("../../includes/breadcrumbs.php"); ?>
		<section>
			<div class="container form">
				<p class="hidden message" name="global"></p>
				<div>
					<label for="contact-email">Contact Email</label>
					<p class="hidden message" name="contactEmail"></p>
					<input id="contact-email" name="contactEmail" type="text">
				</div>
				<div>
					<label for="contact-message">Contact Message</label>
					<p class="hidden message" name="contactMessage"></p>
					<textarea id="contact-message" name="contactMessage"></textarea>
				</div>
				<span class="button"><span class="heading">Submit</span></span>
			</div>
		</section>
	</main>
<?php
	require_once("../../includes/javascript.php");
	require_once("../../includes/footer.php");
	endif;
?>
