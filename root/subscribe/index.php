<?php
	require_once("../../configuration.php");
	$parameters = array(
		"breadcrumbs" => array(
			array(
				"title" => "Subscriptions"
			)
		),
		"title" => "Subscribe - Avolitty"
	);
	require_once("../../includes/header.php");
	$data = array(
		"redirect" => "https://www.paypal.com/cgi-bin/webscr?" . http_build_query(array(
			"a3" => 10,
			"business" => $configuration["merchantId"],
			"cancel_return" => "https://" . $configuration["domain"] . "/pricing/",
			"cmd" => "_xclick-subscriptions",
			"item_name" => "Avolitty Paid Tier",
			"item_number" => $decodedUserData["idHash"],
			"notify_url" => "https://" . $configuration["domain"] . "/notifications/transactions/",
			"p3" => 1,
			"return" => "https://" . $configuration["domain"] . "/dashboard/",
			"src" => "1",
			"t3" => "M"
		))
	);

	if (empty($_SESSION["id"])) {
		$data["redirect"] = "/create-an-account/";
	}
?>
		<main>
			<?php require_once("../../includes/breadcrumbs.php"); ?>
			<section>
				<div class="container interface">
					<div>
						<div class="output">
							<span>
								<span>Processing request &hellip;</span>
							</span>
						</div>
					</div>
				</div>
			</section>
		</main>
<?php
	require_once("../../includes/javascript.php");
	require_once("../../includes/footer.php");
?>
