<?php
	session_start(array(
		"cookie_lifetime" => 100000000
	));

	if (file_exists($configuration["path"] . "database/visits/attackers/" . $_SERVER["REMOTE_ADDR"])) {
		echo "Limit of 100 visits per minute exceeded, try again in 1 minute.";
		exit;
	}

	$visitsDirectoryPath = $configuration["path"] . "database/visits/visitors/" . $_SERVER["REMOTE_ADDR"] . "/";

	if (is_dir($visitsDirectoryPath) == false) {
		mkdir($visitsDirectoryPath);
		chmod($visitsDirectoryPath, 0777);
	}

	touch($visitsDirectoryPath . time() . rand(0, 10000000));
	$data = array(
		"messages" => array()
	);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $parameters["title"]; ?></title>
		<link href="/logo.png" rel="icon" type="image/png">
		<meta content="initial-scale=1, width=device-width" name="viewport">
		<meta content="noindex" name="robots">
		<meta charset="utf-8">
<?php if (empty($parameters["breadcrumbs"]) == false): ?>
		<script type="application/ld+json">
			{
				"@context": "https://schema.org",
				"@type": "BreadcrumbList",
				"itemListElement": [
					{
						"@type": "ListItem",
						"name": "Home",
						"position": 1,
						"item": "https://<?php echo $configuration["domain"]; ?>/"
					},
<?php
	$breadcrumbs = $parameters["breadcrumbs"];
	$breadcrumbsCount = count($breadcrumbs) - 1;
	$breadcrumbsIndex = 0;

	while ($breadcrumbsCount != $breadcrumbsIndex):
?>
					{
						"@type": "ListItem",
						"name": "<?php echo $breadcrumbs[$breadcrumbsIndex]["title"]; ?>",
						"position": <?php echo $breadcrumbsIndex + 2; ?>,
						"item": "https://<?php echo $configuration["domain"] . $breadcrumbs[$breadcrumbsIndex]["url"]; ?>"
					},
<?php
	$breadcrumbsIndex++;
	endwhile;
?>
					{
						"@type": "ListItem",
						"position": <?php echo $breadcrumbsIndex + 2; ?>,
						"name": "<?php echo $breadcrumbs[$breadcrumbsIndex]["title"]; ?>"
					}
				]
			}
		</script>
<?php endif; ?>
		<style type="text/css">
			a {
				color: #ffffff;
				font-weight: bold;
				text-decoration: none;
			}
			body,
			html {
				background: #050505;
				color: #a2a2a2;
				font-family: sans-serif;
				font-size: 13px;
				font-weight: normal;
				line-height: 20px;
				margin: 0;
				width: 100%;
			}
			footer {
				margin-bottom: 90px;
			}
				footer img {
					float: left;
					height: 22px;
				}
				footer section {
					margin-bottom: 63px;
				}
					footer section:last-child {
						margin-bottom: 0;
					}
				footer nav,
				footer ul {
					display: inline-block;
				}
				footer ul {
					margin: 0;
					padding: 0;
				}
					footer ul li {
						display: inline-block;
						float: left;
						margin-right: 15px;
					}
						footer ul li:last-child {
							margin-right: 0;
						}
						footer ul li a {
							display: block;
							float: left;
						}
			footer,
			header {
				clear: both;
				float: left;
				width: 100%;
			}
			header section {
				padding: 105px 0 85px;
			}
				header section ul {
					margin: -1px 0 0;
					padding: 0;
				}
					header section ul li {
						float: left;
						margin-right: 15px;
					}
						header section ul li:last-child {
							margin-right: 0;
						}
			label {
				display: block;
				margin-bottom: 7px;
			}
			main {
				float: left;
				margin-top: 110px;
				width: 100%;
			}
				main p {
					margin-bottom: 7px;
				}
				main section {
					margin-bottom: 95px;
				}
			p {
				display: inline-block;
				margin: 0 0 15px;
			}
			section {
				float: left;
				width: 100%;
			}
				section .container {
					box-sizing: border-box;
					margin: 0 auto;
					max-width: 450px;
					padding: 0 25px;
					width: 100%;
				}
			ul {
				line-height: 22px;
				list-style: none;
				margin: 0 0 -15px;
				padding: 0 0 0 25px;
			}
				ul li {
					margin-bottom: 15px;
				}
			.align-right {
				float: right;
			}
			.breadcrumbs {
				margin-top: 110px;
			}
				.breadcrumbs ol {
					float: left;
					list-style: none;
					margin: 0 0 -5px;
					padding: 0;
					width: 100%;
				}
					.breadcrumbs ol li {
						float: left;
						font-weight: normal;
						margin: 0 10px 15px 0;
						padding: 0;
					}
						.breadcrumbs ol li:last-child {
							background: #0d0d0d;
							color: #808080;
						}
						.breadcrumbs ol li:last-child,
						.breadcrumbs ol li a {
							border-radius: 3px;
							font-size: 11px;
							letter-spacing: 0.3px;
							line-height: 20px;
							margin-right: 0;
							padding: 3px 8px 2px;
						}
						.breadcrumbs ol li a {
							background: #202020;
							color: #bcbcbc;
							float: left;
							font-weight: normal;
						}
							.breadcrumbs ol li a:hover {
								background: #262626;
							}
			.button {
				background: #111;
				border: 2px solid #191919;
				border-radius: 5px;
				box-sizing: border-box;
				cursor: pointer;
				display: inline-block;
				margin: 0 0 17px !important;
				padding: 15px 25px 13px !important;
				text-align: center;
			}
				.button:hover {
					background: #131313;
				}
				.button span {
					display: inline-block;
					width: 100%;
				}
				.button.container {
					float: left;
					text-align: left;
				}
					.button.container:last-child {
						margin-bottom: 10px !important;
					}
					.button.container.c {
						border-left-color: #bcbcbc;
					}
						.button.container.c:hover {
							border-left-color: #dcdcdc;
						}
					.button.container.javascript {
						border-left-color: #f1e05a;
					}
						.button.container.javascript:hover {
							border-left-color: #fff185;
						}
					.button.container.php {
						border-left-color: #4f5d95;
					}
						.button.container.php:hover {
							border-left-color: #6070b2;
						}
				.button .description {
					color: #a2a2a2;
					font-weight: 300;
					margin: 0 0 5px;
				}
					.button .description span {
						background: #202020;
						color: #bcbcbc;
						float: none;
						margin: 0 3px !important;
						width: auto;
					}
						.button .description span:first-child {
							margin-left: 0 !important;
						}
				.button .heading {
					color: #ffffff;
					font-weight: 700;
					line-height: 30px;
				}
			.hidden {
				display: none !important;
			}
			.label {
				background: #202020;
				border-radius: 3px;
				box-sizing: border-box;
				color: #bcbcbc;
				display: inline-block;
				float: left;
				font-size: 11px;
				font-weight: normal;
				letter-spacing: 0.3px;
				margin: 10px 10px 8px 0;
				padding: 3px 8px 2px;
				width: auto !important;
			}
			@media (max-width: 480px) {
				footer section .align-right,
				header section .align-right {
					float: left !important;
					margin-top: 80px;
					width: 100%;
				}
			}
		</style>
	</head>
	<body>
