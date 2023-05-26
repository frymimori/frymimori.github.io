<?php
	$parameters = array(
		"title" => "Fry Mimori - Open-Source Development"
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
						<span class="description">Browse open-source C code.</span>
					</a>
					<a class="button container javascript" href="/javascript/">
						<span class="label">4 Products</span>
						<span class="heading">JavaScript</span>
						<span class="description">Browse open-source JavaScript code.</span>
					</a>
					<a class="button container php" href="/php/">
						<span class="label">1 Product</span>
						<span class="heading">PHP</span>
						<span class="description">Browse open-source PHP code.</span>
					</a>
				</div>
			</section>
		</main>
<?php
	require_once("../includes/javascript.php");
	require_once("../includes/footer.php");
?>
