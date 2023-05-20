<?php
	require_once("../configuration.php");
	$parameters = array(
		"breadcrumbs" => array(
			array(
				"title" => "Page Not Found",
			)
		),
		"title" => "Page Not Found - Avolitty"
	);
	require_once("../includes/header.php");
?>
	<main>
		<?php require_once("../includes/breadcrumbs.php"); ?>
		<section>
			<div class="container">
				<p>The server returned a 404 error because this page doesn't exist.</p>
			</div>
		</section>
	</main>
<?php
	require_once("../includes/javascript.php");
	require_once("../includes/footer.php");
?>
