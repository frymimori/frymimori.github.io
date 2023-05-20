<?php
	$parameters = array(
		"breadcrumbs" => array(
			array(
				"title" => "Dashboard",
			)
		),
		"title" => "Dashboard - Avolitty"
	);
	require_once("../../configuration.php");
	require_once("../../includes/header.php");

	if (empty($_SESSION["id"]) == true) {
		$data["redirect"] = "/sign-in/";
	}
?>
		<main>
			<?php require_once("../../includes/breadcrumbs.php"); ?>
			<section>
				<div class="container">
					<a class="align-left button container" href="/">
						<span class="heading">Open-Source Algorithms</span>
					</a>
					<a class="align-left button container" href="/dashboard/subscriptions/">
						<span class="heading">Subscriptions</span>
					</a>
					<a class="align-left button container" href="/dashboard/transactions/">
						<span class="heading">Transactions</span>
					</a>
				</div>
			</section>
		</main>
<?php
	require_once("../../includes/javascript.php");
	require_once("../../includes/footer.php");
?>
