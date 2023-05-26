<?php
	$parameters = array(
		"breadcrumbs" => array(
			array(
				"title" => "PHP",
			)
		),
		"title" => "PHP - Avolitty"
	);
	require_once("../../configuration.php");
	require_once("../../includes/header.php");
?>
		<main>
			<?php require_once("../../includes/breadcrumbs.php"); ?>
			<section>
				<div class="container">
					<a class="button container php" href="https://github.com/avolitty/php-avolitty-pathfinder" target="_blank">
						<span class="label">v1.0.3</span>
						<span class="heading">Pathfinder</span>
						<span class="description">Create shortest path traversals in grid graphs.</span>
					</a>
				</div>
			</section>
		</main>
<?php
	require_once("../../includes/javascript.php");
	require_once("../../includes/footer.php");
?>
