<?php
	require_once("../../../configuration.php");

	$parameters = array(
		"breadcrumbs" => array(
			array(
				"title" => "Dashboard",
				"url" => "/dashboard/"
			),
			array(
				"title" => "Subscriptions"
			)
		),
		"title" => "Subscriptions - Dashboard - Avolitty"
	);
	require_once("../../../includes/header.php");

	if (empty($_SESSION["id"])) {
		$data["redirect"] = "/sign-in/";
	} else {
		if (file_exists($configuration["path"] . "database/subscriptions/" . $decodedUserData["idHash"] . ".json")) {
			$encodedSubscriptionsData = file_get_contents($configuration["path"] . "database/subscriptions/" . $decodedUserData["idHash"] . ".json");
			$decodedSubscriptionsData = json_decode($encodedSubscriptionsData, true);
			$decodedSubscriptionsDataIndex = count($decodedSubscriptionsData);
		}
	}
?>
		<main>
			<?php require_once("../../../includes/breadcrumbs.php"); ?>
			<section>
				<div class="container">
					<?php if (empty($decodedSubscriptionsData) == false): ?>
					<?php
						while ($decodedSubscriptionsDataIndex != 0) {
							$decodedSubscriptionsDataIndex--;
							echo "<div class=\"output\">";
							echo "<div>";
							echo "<span>";
							echo "<span>Subscription ID</span>";
							echo "<span class=\"value\">" . $decodedSubscriptionsData[$decodedSubscriptionsDataIndex]["id"] . "</span>";
							echo "</span>";
							echo "<span>";
							echo "<span>Days Remaining Until Next Subscription Payment</span>";
							echo "<span class=\"value\">" . max(ceil((strtotime("+1 month", $decodedSubscriptionsData[$decodedSubscriptionsDataIndex]["createdTimestamp"]) - time()) / 86400), 0) . "</span>";
							echo "</span>";
							echo "<span>";
							echo "<span>Monthly Subscription Price</span>";
							echo "<span class=\"value\">$" . $decodedSubscriptionsData[$decodedSubscriptionsDataIndex]["monthlyPrice"] . "</span>";
							echo "</span>";
							echo "</div>";
							echo "</div>";
						}
 					?>
					<?php else:
						if (empty($data["redirect"])) {
							$data["redirect"] = "/pricing/";
						}
					endif; ?>
				</div>
			</section>
		</main>
<?php
	require_once("../../../includes/javascript.php");
	require_once("../../../includes/footer.php");
?>
