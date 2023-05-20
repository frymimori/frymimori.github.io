<?php
	require_once("../../../configuration.php");

	function verifyTransactionNotification($notificationData) {
		$verificationUrl = "https://ipnpb.paypal.com/cgi-bin/webscr?cmd=_notify-validate&" . $notificationData;
		exec("curl \"" . str_replace("\"", 0, $verificationUrl) . "\" 2>&1", $verificationResponse);
		return strcasecmp(end($verificationResponse), "verified") == 0;
	}

//	$encodedParameters = "mc_gross=19.95&protection_eligibility=Eligible&address_status=confirmed&payer_id=LPLWNMTBWMFAY&tax=0.00&address_street=1+Main+St&payment_date=20%3A12%3A59+Jan+13%2C+2009+PST&subscr_id=1234&payment_status=Completed&charset=windows-1252&address_zip=95131&first_name=Test&mc_fee=0.88&address_country_code=US&address_name=Test+User&notify_version=2.6&custom=&payer_status=verified&address_country=United+States&address_city=San+Jose&quantity=1&verify_sign=AtkOfCXbDm2hu0ZELryHFjY-Vb7PAUvS6nMXgysbElEn9v-1XcmSoGtf&payer_email=gpmac_1231902590_per%40paypal.com&txn_id=61E67681CH3238416&payment_type=instant&last_name=User&address_state=CA&receiver_email=gpmac_1231902686_biz%40paypal.com&payment_fee=0.88&receiver_id=S8XGHLYDW9T3S&txn_type=subscr_payment&item_name=subscription+test&mc_currency=USD&item_number=12aa0ffe5a708c1eea2d4553734ce019fdf6fad4fe2007c2cd9975ce0a869c6e&residence_country=US&test_ipn=1&handling_amount=0.00&transaction_subject=&payment_gross=19.95&shipping=0.00&amount3=10.00&verify_sign=12345";

//	if ($encodedParameters) { 
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
