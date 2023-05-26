		<footer>
			<section>
				<div class="container">
					<p><a class="logo" href="/"><img alt="Avolitty Logo" src="/logo.jpg"></a> &copy; <?php echo date("Y", time()); ?> Avolitty</p>
					<nav class="align-right">
						<ul>
							<li><a href="https://discord.gg/YH7apK7DBD" rel="external" target="_blank"><img alt="Discord" src="/discord.svg"></a></li>
							<li><a href="https://github.com/avolitty" rel="external" target="_blank"><img alt="GitHub" src="/github.svg"></a></li>
							<li><a href="https://www.linkedin.com/in/avolitty" rel="external" target="_blank"><img alt="GitHub" src="/linkedin.svg"></a></li>
							<li><a href="https://twitter.com/avolitty" rel="external" target="_blank"><img alt="Twitter" src="/twitter.svg"></a></li>
						</ul>
					</nav>
				</div>
			</section>
			<section>
				<div class="container statistics">
					<span>
<?php
	if (empty($configuration["statistics"]) == false):
		foreach ($configuration["statistics"] as $statisticLabel => $statisticValue):
?>
						<span><span><?php echo $statisticValue; ?></span> <?php echo $statisticLabel; ?></span>
<?php
		endforeach;
	endif;
?>
					</span>
				</div>
			</section>
<?php if (empty($data["redirect"]) == false): ?>
			<div class="hidden redirect"><?php echo $data["redirect"]; ?></div>
<?php endif; ?>
		</footer>
	</body>
</html>
