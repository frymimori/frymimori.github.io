<?php
	$parameters = array(
		"breadcrumbs" => array(
			array(
				"title" => "C",
			)
		),
		"title" => "C - Avolitty"
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
						<span class="label">v1.2.4</span>
						<span class="heading">Hasher</span>
						<span class="description">Create secure and variable-length checksums.</span>
					</a>
					<a class="button c container" href="https://github.com/avolitty/c-avolitty-pathfinder" target="_blank">
						<span class="label">v1.2.5</span>
						<span class="heading">Pathfinder</span>
						<span class="description">Create shortest path traversals in grid graphs.</span>
					</a>
					<a class="button c container" href="https://github.com/avolitty/c-avolitty-randomizer" target="_blank">
						<span class="label">v1.2.5</span>
						<span class="heading">Randomizer</span>
						<span class="description">Create random integers from timestamps and standard I/O.</span>
					</a>
					<a class="button c container" href="https://github.com/avolitty/c-avolitty-reader" target="_blank">
						<span class="label">v1.3.1</span>
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
