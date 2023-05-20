<?php
	require_once("../../../configuration.php");
	$parameters = array(
		"breadcrumbs" => array(
			array(
				"title" => "Dashboard",
				"url" => "/dashboard/"
			),
			array(
				"title" => "Transactions"
			)
		),
		"title" => "Transactions - Avolitty"
	);
	require_once("../../../includes/header.php");

	if (empty($_SESSION["id"])) {
		$data["redirect"] = "/sign-in/";
	} else {
		if (file_exists($configuration["path"] . "database/transactions/" . $decodedUserData["idHash"] . "/data.json")) {
			$encodedTransactionsData = file_get_contents($configuration["path"] . "database/transactions/" . $decodedUserData["idHash"] . "/data.json");
			$decodedTransactionsData = json_decode($encodedTransactionsData, true);
			$decodedTransactionsDataIndex = count($decodedTransactionsData);
		}
	}
?>
		<main>
			<?php require_once("../../../includes/breadcrumbs.php"); ?>
			<section>
				<div class="container">
					<?php if (empty($decodedTransactionsData) == false): ?>
					<?php
						while ($decodedTransactionsDataIndex != 0) {
							$decodedTransactionsDataIndex--;
							echo "<div class=\"output\">";
							echo "<div class=\"output-item\">";
							echo "<label>Transaction Description</label>";
							echo "<input disabled value=\"" . $decodedTransactionsData[$decodedTransactionsDataIndex]["description"] . "\">";
							echo "</div>";
							echo "<div class=\"output-item\">";
							echo "<label>Transaction ID</label>";
							echo "<input disabled value=\"" . $decodedTransactionsData[$decodedTransactionsDataIndex]["id"] . "\">";
							echo "</div>";
							echo "<div class=\"output-item\">";
							echo "<label>Transaction Subscription ID</label>";
							echo "<input disabled value=\"" . $decodedTransactionsData[$decodedTransactionsDataIndex]["subscriptionId"] . "\">";
							echo "</div>";
							echo "<div class=\"output-item\">";
							echo "<label>Transaction Date</label>";
							echo "<input disabled value=\"" . date("F j, Y g:ia T", $decodedTransactionsData[$decodedTransactionsDataIndex]["createdTimestamp"]) . "\">";
							echo "</div>";
							echo "<div class=\"output-item\">";
							echo "<label>Transaction Amount</label>";
							echo "<input disabled value=\"$" . ceil($decodedTransactionsData[$decodedTransactionsDataIndex]["amount"]) . "\">";
							echo "</div>";
							echo "</div>";
						}
 					?>
					<?php else: ?>
					<p>There are no transactions to display.</p>
					<?php endif; ?>
				</div>
			</section>
		</main>
<?php
	require_once("../../../includes/javascript.php");
	require_once("../../../includes/footer.php");
?>
