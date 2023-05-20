		<section>
			<div class="breadcrumbs container">
				<ol>
					<li><a href="/">Home</a></li>
<?php
	$breadcrumbsCount = count($breadcrumbs) - 1;
	$breadcrumbsIndex = 0;

	while ($breadcrumbsCount != $breadcrumbsIndex):
?>
					<li><a href="<?php echo $breadcrumbs[$breadcrumbsIndex]["url"]; ?>"><?php echo $breadcrumbs[$breadcrumbsIndex]["title"]; ?></a></li>
<?php
	$breadcrumbsIndex++;
	endwhile;
?>
					<li><?php echo $breadcrumbs[$breadcrumbsIndex]["title"]; ?></li>
				</ol>
			</div>
		</section>
