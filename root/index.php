<?php
	$parameters = array(
		"metaDescription" => "Evaluate and purchase a subscription for essential algorithms, data structures, libraries, modules, packages and systems with freemium open-source code in 3 different programming languages.",
		"title" => "Avolitty - Freemium Open-Source Code"
	);
	require_once("../configuration.php");
	require_once("../includes/header.php");
?>
		<main>
			<section>
				<div class="container">
					<a class="button c container" href="/c-algorithms/">
						<span class="label">4 Algorithms</span>
						<span class="heading">C Algorithms</span>
						<span class="description">Browse C algorithms and modules.</span>
					</a>
					<a class="button container javascript" href="/javascript-algorithms/">
						<span class="label">4 Algorithms</span>
						<span class="heading">JavaScript Algorithms</span>
						<span class="description">Browse JavaScript algorithms, modules and NPM packages.</span>
					</a>
					<a class="button container php" href="/php-algorithms/">
						<span class="label">1 Algorithm</span>
						<span class="heading">PHP Algorithms</span>
						<span class="description">Browse PHP algorithms, modules and Composer packages.</span>
					</a>
				</div>
			</section>
		</main>
<?php
	require_once("../includes/javascript.php");
	require_once("../includes/footer.php");
?>
