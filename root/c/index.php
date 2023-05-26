<?php
	$parameters = array(
		"breadcrumbs" => array(
			array(
				"title" => "Open-Source C Code",
			)
		),
		"title" => "Open-Source C Code - Fry Mimori"
	);
	require_once("../../configuration.php");
	require_once("../../includes/header.php");
?>
		<main>
			<?php require_once("../../includes/breadcrumbs.php"); ?>
			<section>
				<div class="container">
					<a class="button c container" href="https://github.com/avolitty/c-avolitty-associator" target="_blank">
						<span class="label">In Development</span>
						<span class="heading">Associator</span>
						<span class="description">Create secure multidimensional hash tables.</span>
					</a>
					<a class="button c container" href="https://github.com/avolitty/c-avolitty-hasher" target="_blank">
						<span class="label">v1.0.0</span>
						<span class="heading">Hasher</span>
						<span class="description">Create secure and variable-length checksums.</span>
					</a>
					<a class="button c container" href="https://github.com/avolitty/c-avolitty-pathfinder" target="_blank">
						<span class="label">v1.0.0</span>
						<span class="heading">Pathfinder</span>
						<span class="description">Create shortest path traversals in grid graphs.</span>
					</a>
					<a class="button c container" href="https://github.com/avolitty/c-avolitty-randomizer" target="_blank">
						<span class="label">v1.0.0</span>
						<span class="heading">Randomizer</span>
						<span class="description">Create random integers with additional entropy.</span>
					</a>
					<a class="button c container" href="https://github.com/avolitty/c-avolitty-reader" target="_blank">
						<span class="label">v1.0.0</span>
						<span class="heading">Reader</span>
						<span class="description">Create byte arrays from file streams.</span>
					</a>
				</div>
			</section>
		</main>
<?php
	require_once("../../includes/javascript.php");
	require_once("../../includes/footer.php");
?>
