<?php
	require_once("../../configuration.php");
	$parameters = array(
		"breadcrumbs" => array(
			array(
				"title" => "Jobs",
			)
		),
		"title" => "Jobs - Avolitty"
	);
	require_once("../../includes/header.php");
?>
	<main>
		<?php require_once("../../includes/breadcrumbs.php"); ?>
		<section>
			<div class="container">
				<p>There are no jobs to display.</p>
			</div>
		</section>
	</main>
<?php
	require_once("../../includes/javascript.php");
	require_once("../../includes/footer.php");
?>
