<?php
	$parameters = array(
		"metaDescription" => "Evaluate integral algorithms, data structures, libraries, modules, packages and systems with open-source code in 3 different programming languages.",
		"title" => "Avolitty - Open-Source Code"
	);
	require_once("../configuration.php");
	require_once("../includes/header.php");
?>
		<main>
			<section>
				<div class="container">
					<a class="button c container" href="/c/">
						<span class="label">4 Products</span>
						<span class="heading">C</span>
						<span class="description">Browse open-source C algorithms and modules.</span>
					</a>
					<a class="button container javascript" href="/javascript/">
						<span class="label">4 Products</span>
						<span class="heading">JavaScript</span>
						<span class="description">Browse open-source JavaScript algorithms, modules and NPM packages.</span>
					</a>
					<a class="button container php" href="/php/">
						<span class="label">1 Product</span>
						<span class="heading">PHP</span>
						<span class="description">Browse open-source PHP algorithms, modules and Composer packages.</span>
					</a>
				</div>
			</section>
		</main>
<?php
	require_once("../includes/javascript.php");
	require_once("../includes/footer.php");
?>
