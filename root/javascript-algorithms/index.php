<?php
	$parameters = array(
		"breadcrumbs" => array(
			array(
				"title" => "JavaScript Algorithms",
			)
		),
		"metaDescription" => "Evaluate and purchase a subscription for unique JavaScript algorithms, modules and NPM packages with freemium open-source code.",
		"title" => "JavaScript Algorithms - Avolitty"
	);
	require_once("../../configuration.php");
	require_once("../../includes/header.php");
?>
		<main>
			<?php require_once("../../includes/breadcrumbs.php"); ?>
			<section>
				<div class="container">
					<a class="button container javascript" href="https://github.com/avolitty/javascript-avolitty-byte-reverser" target="_blank">
						<span class="label">v1.0.0</span>
						<span class="heading">Byte Reverser</span>
						<span class="description">Create reverse-endian byte sequences.</span>
					</a>
					<a class="button container javascript" href="https://github.com/avolitty/javascript-avolitty-concatenator" target="_blank">
						<span class="label">v1.0.9</span>
						<span class="heading">Concatenator</span>
						<span class="description">Create repeated text patterns.</span>
					</a>
					<a class="button container javascript" href="https://github.com/avolitty/javascript-avolitty-hasher" target="_blank">
						<span class="label">v1.1.5</span>
						<span class="heading">Hasher</span>
						<span class="description">Create variable-length checksums from all data types.</span>
					</a>
					<a class="button container javascript" href="https://github.com/avolitty/javascript-avolitty-unicode-converter" target="_blank">
						<span class="label">v1.0.1</span>
						<span class="heading">Unicode Converter</span>
						<span class="description">Create conversions between UTF-8, UTF-16 and UTF-32 encoding.</span>
					</a>
				</div>
			</section>
		</main>
<?php
	require_once("../../includes/javascript.php");
	require_once("../../includes/footer.php");
?>
