<?php
	require_once("../../configuration.php");
	$parameters = array(
		"breadcrumbs" => array(
			array(
				"title" => "About",
			)
		),
		"title" => "About - Avolitty"
	);
	require_once("../../includes/header.php");
?>
	<main>
		<?php require_once("../../includes/breadcrumbs.php"); ?>
		<section>
			<div class="container interface">
				<div>
					<p>Avolitty creates and maintains unique approaches to algorithms, data structures, libraries, modules, packages and systems with freemium open-source code.</p>
				</div>
				<div>
					<p>They're the missing fundamental components in all programming languages with unprecedented efficiency, performance, robustness, security and simplicity.</p>
				</div>
				<div>
					<p>Gradual implementation of Avolitty rapidly advances technology in all industries without rebuilding widely-adopted software.</p>
				</div>
			</div>
		</section>
	</main>
<?php
	require_once("../../includes/javascript.php");
	require_once("../../includes/footer.php");
?>
