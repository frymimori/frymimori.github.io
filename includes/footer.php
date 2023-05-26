		<footer>
			<section>
				<div class="container">
					<p>&copy; <?php echo date("Y", time()); ?> Fry Mimori</p>
					<nav class="align-right">
						<ul>
							<li><a href="https://discord.gg/YH7apK7DBD" rel="external" target="_blank"><img alt="Discord" src="/discord.svg"></a></li>
							<li><a href="https://github.com/frymimori" rel="external" target="_blank"><img alt="GitHub" src="/github.svg"></a></li>
							<li><a href="https://www.linkedin.com/in/frymimori/" rel="external" target="_blank"><img alt="GitHub" src="/linkedin.svg"></a></li>
							<li><a href="https://twitter.com/frymimori" rel="external" target="_blank"><img alt="Twitter" src="/twitter.svg"></a></li>
						</ul>
					</nav>
				</div>
			</section>
<?php if (empty($data["redirect"]) == false): ?>
			<div class="hidden redirect"><?php echo $data["redirect"]; ?></div>
<?php endif; ?>
		</footer>
	</body>
</html>
