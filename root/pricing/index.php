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
					<label>Free Tier</label>
					<div class="output">
						<span>
							<span><span class="value">$0</span> for evaluation and testing before subscribing to Paid Tier.</span>
						</span>
					</div>
					<label>Paid Tier</label>
					<div class="output">
						<span>
							<span><span class="value">$10 monthly subscription</span> for business and personal usage.</span>
						</span>
					</div>
					<div class="form">
						<a class="button" href="/subscribe/">Subscribe</a>
					</div>
				</div>
			</div>
		</section>
	</main>
<?php
	require_once("../../includes/javascript.php");
	require_once("../../includes/footer.php");
?>
