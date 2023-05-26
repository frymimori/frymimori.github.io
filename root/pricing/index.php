<?php
	require_once("../../configuration.php");
	$parameters = array(
		"breadcrumbs" => array(
			array(
				"title" => "Pricing",
			)
		),
		"title" => "Pricing - Avolitty"
	);
	require_once("../../includes/header.php");
?>
	<main>
		<?php require_once("../../includes/breadcrumbs.php"); ?>
		<section>
			<div class="container interface">
				<div>
					<span>Subscription payments are disabled while changes are made to license tiers.</span>
				</div>
			</div>
		</section>
	</main>
<?php
	require_once("../../includes/javascript.php");
	require_once("../../includes/footer.php");
?>
