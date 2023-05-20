<?php
	require_once(__DIR__ . "/../configuration.php");
	$visitsAttackersDirectoryPath = $configuration["path"] . "database/visits/attackers/";
	shell_exec("sudo rm -rf " . $visitsAttackersDirectoryPath . "*");
	$visitsVisitorsDirectoryPath = $configuration["path"] . "database/visits/visitors/";
	$visitors = array_values(array_diff(scandir($visitsVisitorsDirectoryPath), array("..", ".")));
	$visitorsIndex = count($visitors);

	while ($visitorsIndex != 0) {
		$visitorsIndex--;
		$visitorId = $visitors[$visitorsIndex];
		$visitorVisits = scandir($visitsVisitorsDirectoryPath . $visitorId . "/");

		if ($visitorVisits != false) {
			$visitorVisitsCount = count($visitorVisits);

			if ($visitorVisitsCount > 100) {
				touch($visitsAttackersDirectoryPath . $visitorId);
			}
		}
	}

	shell_exec("rm -rf " . $configuration["path"] . "database/visits/visitors/*");
?>
