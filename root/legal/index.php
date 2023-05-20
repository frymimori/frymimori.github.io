<?php
	require_once("../../configuration.php");
	$parameters = array(
		"breadcrumbs" => array(
			array(
				"title" => "Legal",
			)
		),
		"title" => "Legal - Avolitty"
	);
	require_once("../../includes/header.php");
?>
	<main>
		<?php require_once("../../includes/breadcrumbs.php"); ?>
		<section>
			<div class="container interface">
				<div>
					<p>Redistribution of Avolitty products, with or without modification, is forbidden.</p>
				</div>
				<div>
					<p>Refunds are granted on request for PayPal payments sent within 30 days of requesting.</p>
				</div>
				<div>
					<p>Subscription cancellations are granted on request.</p>
				</div>
				<div>
					<p>Client IP addresses are logged temporarily to mitigate denial-of-service attacks.<p>
				</div>
				<div>
					<p>User IDs are stored as strings of text.</p>
				</div>
				<div>
					<p>User passwords are hashed securely and stored as strings of digits.</p>
				</div>
			</div>
		</section>
	</main>
<?php
	require_once("../../includes/javascript.php");
	require_once("../../includes/footer.php");
?>
