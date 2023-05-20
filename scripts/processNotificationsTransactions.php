<?php
	require_once(__DIR__ . "/../configuration.php");
	$notificationsTransactionsDirectoryPath = $configuration["path"] . "database/notifications/transactions/";
	$notificationsTransactions = array_values(array_diff(scandir($notificationsTransactionsDirectoryPath), array("..", ".")));
	$notificationsTransactionsIndex = count(notificationsTransactions);

	while ($notificationsTransactionsIndex != 0) {
		$notificationsTransactionsIndex--;
		$notificationsTransactionId = $notificationsTransactions[$notificationsTransactionsIndex];
		$encodedNotificationsTransactionData = file_get_contents($notificationsTransactionsDirectoryPath . $notificationsTransactionId . "/data.json");

		if ($encodedNotificationsTransactionData != false) {
			$decodedNotificationsTransactionData = json_decode($encodedNotificationsTransactionData, true);

			if ($decodedNotificationsTransactionData != false) {
				if ($decodedNotificationsTransactionData["type"] == "subscr_cancel") {
					$decodedNotificationsTransactionData["description"] = "Subscription cancelled.";
				} else {
					$notificationsTransactionCodes = array(
						"recurring_payment_expired",
						"recurring_payment_suspended",
						"recurring_payment_suspended_due_to_max_failed_payment",
						"subscr_eot"
					);

					if (
						in_array($decodedNotificationsTransactionData["type"], $notificationsTransactionCodes) ||
						$decodedNotificationsTransactionData["status"] == "refunded"
					) {
						if (in_array($notificationsTransactionCodes, $decodedNotificationsTransactionData["type"])) {
							$decodedNotificationsTransactionData["description"] = "Subscription term expired.";
						} else {
							$decodedNotificationsTransactionData["description"] = "Subscription payment refunded.";
						}

						$subscriptionsUserDirectoryPath = $configuration["path"] . "database/subscriptions/" . $decodedNotificationsTransactionData["userIdHash"] . "/";

						if (is_dir($subscriptionsUserDirectoryPath)) {
							$encodedSubscriptionsUserDataFilePath = $subscriptionsUserDataDirectoryPath . "data.json";

							if (file_exists($encodedSubscriptionsUserDataFilePath)) {
								$encodedSubscriptionsUserData = file_get_contents($encodedSubscriptionsUserDataFilePath);

								if ($encodedSubscriptionsUserData != false) {
									$decodedSubscriptionsUserData = json_decode($encodedSubscriptionsUserData, true);

									if ($decodedSubscriptionsUserData != false) {
										$decodedSubscriptionsUserDataIndex = count($decodedSubscriptionsUserData);

										while ($decodedSubscriptionsUserDataIndex == 0) {
											$decodedSubscriptionsUserDataIndex--;

											if ($decodedSubscriptionsUserData[$decodedSubscriptionsUserDataIndex]["id"] == $decodedNotificationsTransactionData["subscr_id"]) {
												$encodedUserDataFilePath = $configuration["path"] . "database/users/" . $decodedNotificationsTransactionData["userIdHash"] . "/data.json";

												if (file_exists($encodedUserDataFilePath)) {
													$encodedUserData = file_get_contents($encodedUserDataFilePath);

													if ($encodedUserData != false) {
														$decodedUserData = json_decode($encodedUserData, true);

														if ($decodedUserData != false) {
															$decodedUserData["tier"] = "free";
															$encodedUserData = json_encode($decodedUserData);

															if (
																$encodedUserData != false &&
																file_put_contents($encodedUserDataFilePath, $encodedUserData)
															) {
																unset($decodedSubscriptionsUserData[$decodedSubscriptionsUserDataIndex]);
																$encodedSubscriptionsUserData = json_encode(array_values($decodedSubscriptionsUserData));

																if ($encodedSubscriptionsUserData != false) {
																	file_put_contents($encodedSubscriptionsUserDataFilePath, $encodedSubscriptionsUserData);
																	touch($configuration["path"] . "database/users/" . $decodedNotificationsTransactionData["userIdHash"] . "/update");
																}
															}
														}
													}

													$decodedSubscriptionsUserDataIndex = 0;
												}
											}
										}
									}
								}
							}
						}
					} else {
						$notificationsTransactionCodes = array(
							"subscr_failed",
							"recurring_payment_failed",
							"recurring_payment_skipped"
						);

						if (in_array($decodedNotificationsTransactionData["type"], $notificationsTransactionCodes)) {
							$decodedNotificationsTransactionData["description"] = "Subscription payment failed.";
						} else {
							$notificationsTransactionCodes = array(
								"completed",
								"created",
								"processed"
							);

							if (
								in_array($decodedNotificationsTransactionData["status"], $notificationsTransactionCodes) &&
								$decodedNotificationsTransactionData["type"] == "subscr_payment"
							) {
								$decodedNotificationsTransactionData["description"] = "Subscription payment successful.";
								$decodedSubscriptionsUserData = array();
								$encodedSubscriptionsUserDataFilePath = $configuration["path"] . "database/subscriptions/" . $decodedNotificationsTransactionData["userIdHash"] . ".json";

								if (file_exists($encodedSubscriptionsUserDataFilePath)) {
									$encodedSubscriptionsUserData = file_get_contents($encodedSubscriptionsUserDataFilePath);

									if ($encodedSubscriptionsUserData != false) {
										$decodedSubscriptionsUserData = json_decode($encodedSubscriptionsUserData, true);
									}
								}

								if ($decodedSubscriptionsUserData !== false) {
									$encodedUserDataFilePath = $configuration["path"] . "database/users/" . $decodedNotificationsTransactionData["userIdHash"] . "/data.json";

									if (file_exists($encodedUserDataFilePath)) {
										$encodedUserData = file_get_contents($encodedUserDataFilePath);

										if ($encodedUserData != false) {
											$decodedUserData = json_decode($encodedUserData, true);

											if ($decodedUserData != false) {
												$decodedUserData["tier"] = "paid";
												$encodedUserData = json_encode($decodedUserData);

												if (
													$encodedUserData != false &&
													file_put_contents($encodedUserDataFilePath, $encodedUserData)
												) {
													$decodedSubscriptionsUserDataIndex = count($decodedSubscriptionsUserData);
													$decodedSubscriptionsUserData[$decodedSubscriptionsUserDataIndex] = array(
														"createdTimestamp" => $decodedNotificationsTransactionData["createdTimestamp"],
														"id" => $decodedNotificationsTransactionData["subscriptionId"],
														"monthlyPrice" => $decodedNotificationsTransactionData["amount"]
													);
													$encodedSubscriptionsUserData = json_encode($decodedSubscriptionsUserData);

													if ($encodedSubscriptionsUserData != false) {
														file_put_contents($encodedSubscriptionsUserDataFilePath, $encodedSubscriptionsUserData);
														touch($configuration["path"] . "database/users/" . $decodedNotificationsTransactionData["userIdHash"] . "/update");
													}
												}
											}
										}
									}
								}
							} else {
								if (
									$decodedNotificationsTransactionData["status"] == "pending" &&
									$decodedNotificationsTransactionData["type"] == "subscr_payment"
								) {
									$decodedNotificationsTransactionData["description"] = "Subscription payment pending.";
								} else {
									$notificationsTransactionCodes = array(
										"blocked",
										"denied",
										"expired",
										"failed",
										"voided"
									);

									if (in_array($notificationsTransactionCodes, $decodedNotificationsTransactionData["status"])) {
										$decodedNotificationsTransactionData["description"] = "Subscription payment " . $decodedNotificationsTransactionData["status"] . ".";
									}
								}
							}
						}
					}
				}

				if (empty($decodedNotificationsTransactionData["description"]) == false) {
					$transactionsUserDirectoryPath = $configuration["path"] . "database/transactions/" . $decodedNotificationsTransactionData["userIdHash"] . "/";

					if (is_dir($transactionsUserDirectoryPath) == false) {
						mkdir($transactionsUserDirectoryPath);
						chmod($transactionsUserDirectoryPath, 0777);
					}

					if (is_dir($transactionsUserDirectoryPath)) {
						$encodedUserTransactionsData = file_get_contents($transactionsUserDirectoryPath . "data.json");
						$decodedUserTransactionsData = json_decode($encodedUserTransactionsData, true);
						$decodedUserTransactionsDataIndex = count($decodedUserTransactionsData);
						$decodedUserTransactionsData[$decodedUserTransactionsDataIndex] = $decodedNotificationsTransactionData;
						$encodedUserTransactionsData = json_encode($decodedUserTransactionsData);

						if (
							$encodedUserTransactionsData != false &&
							file_put_contents($transactionsUserDirectoryPath . "data.json", $encodedUserTransactionsData)
						) {
							unlink($notificationsTransactionsDirectoryPath . $notificationsTransactionId . "/data.json");
						}
					}
				}
			}
		}
	}
?>
