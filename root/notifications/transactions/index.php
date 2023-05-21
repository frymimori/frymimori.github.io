<?php
	require_once("../../../configuration.php");

	function verifyTransactionNotification($notificationData) {
		$verificationUrl = "https://ipnpb.paypal.com/cgi-bin/webscr?cmd=_notify-validate&" . $notificationData;
		exec("curl \"" . str_replace("\"", 0, $verificationUrl) . "\" 2>&1", $verificationResponse);
		return strcasecmp(end($verificationResponse), "verified") == 0;
	}

	if (empty($_POST) == false) {
		$encodedParameters = file_get_contents('php://input');
		file_put_contents($configuration["path"] . "database/tmp/" . time(), $encodedParameters);

		if (empty($encodedParameters) == false) {
			$decodedNotificationsTransactionData = array();
			$decodedParameters = explode("&", $encodedParameters);
			$decodedParametersIndex = count($decodedParameters);

			while ($decodedParametersIndex != 0) {
				$decodedParametersIndex--;
				list($decodedParametersKey, $decodedParametersValue) = explode("=", $decodedParameters[$decodedParametersIndex]);

				if (empty($decodedParametersKey) == false) {
					$decodedNotificationsTransactionData[$decodedParametersKey] = urldecode(utf8_encode($decodedParametersValue));
				}
			}

			if (empty($decodedNotificationsTransactionData["verify_sign"]) == false) {
				$decodedNotificationsTransactionData = array(
					"amount" => $decodedNotificationsTransactionData["amount3"],
					"billingAddress" => $decodedNotificationsTransactionData["address_street"],
					"billingCity" => $decodedNotificationsTransactionData["address_city"],
					"billingCountryCode" => $decodedNotificationsTransactionData["address_country_code"],
					"billingName" => $decodedNotificationsTransactionData["address_name"],
					"billingRegion" => $decodedNotificationsTransactionData["address_state"],
					"billingZip" => $decodedNotificationsTransactionData["address_zip"],
					"createdTimestamp" => time(),
					"id" => $decodedNotificationsTransactionData["txn_id"],
					"notification" => $encodedParameters,
					"status" => strtolower($decodedNotificationsTransactionData["payment_status"]),
					"subscriberEmail" => $decodedNotificationsTransactionData["payer_email"],
					"subscriberId" => $decodedNotificationsTransactionData["payer_id"],
					"subscriberName" => $decodedNotificationsTransactionData["first_name"] . ($decodedNotificationsTransactionData["first_name"] != $decodedNotificationsTransactionData["last_name"] ? " " . $decodedNotificationsTransactionData["last_name"] : ""),
					"subscriptionId" => $decodedNotificationsTransactionData["subscr_id"],
					"type" => $decodedNotificationsTransactionData["txn_type"],
					"userIdHash" => $decodedNotificationsTransactionData["item_number"],
					"verificationSignature" => $decodedNotificationsTransactionData["verify_sign"]
				);
				$encodedNotificationsTransactionData = json_encode($decodedNotificationsTransactionData);

				if ($encodedNotificationsTransactionData != false) {
					$notificationsTransactionDirectoryPath = $configuration["path"] . "database/notifications/transactions/" . $decodedNotificationsTransactionData["id"] . "/";

					if (is_dir($notificationsTransactionDirectoryPath) == false) {
						if (
							mkdir($notificationsTransactionDirectoryPath) == false ||
							chmod($notificationsTransactionDirectoryPath, 0777) == false ||
							file_put_contents($notificationsTransactionDirectoryPath . "data.json", $encodedNotificationsTransactionData) == false
						) {
							rmdir($notificationsTransactionDirectoryPath);
						}
					}
				}
			} else {
				require_once("../../../includes/header.php");
			}
		} else {
			require_once("../../../includes/header.php");
		}
	} else {
		require_once("../../../includes/header.php");
	}

	exit;
?>
