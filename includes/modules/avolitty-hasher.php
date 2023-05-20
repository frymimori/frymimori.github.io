<?php
	function AvolittyHasherA($a) {
		$b = array_fill(0, 64, 254);
		$c = strlen($a);
		$d = 63;
		$e = 0;
		$f = 0;

		while ($c != $f) {
			$d = (((ord($a[$f]) + $d + (($d + 2) >> 1))) & 16383) + 2;
			$g = $e & 63;
			$b[$g] = ($b[$g] + $d) & 1023;
			$e++;
			$f++;
		}

		return array(
			$b,
			$d
		);
	}

	function AvolittyHasherB($a) {
		$b = array_fill(0, 16, 254);
		$c = strlen($a);
		$d = 15;
		$e = 0;
		$f = 0;

		while ($c != $f) {
			$d = (((ord($a[$f]) + $d + (($d + 2) >> 1))) & 16383) + 2;
			$g = $e & 15;
			$b[$g] = ($b[$g] + $d) & 1023;
			$e++;
			$f++;
		}

		return array(
			$b,
			$d
		);
	}

	function AvolittyHasherC($a, $b) {
		$c = "";
		$d = $a[0];
		$e = $a[1];
		$f = 0;

		while ($b != 0) {
			$b--;
			$d[$b] = $e;
			$e = (($d[$b] + $d[$f] + $b + (($e + $b) >> 1)) & 16383) + 2;
			$d[$f] = $e;
			$c .= base_convert($e % 36, 10, 36);
			$f++;
		}

		return $c;
	}

	function AvolittyHasherD($a) {
		$b = "";
		$c = $a[0];
		$d = $a[1];
		$e = 64;
		$f = 0;

		while ($e != 0) {
			$e--;
			$c[$e] = $d;
			$d = (($c[$e] + $c[$f] + $e + (($d + $e) >> 1)) & 16383) + 2;
			$c[$f] = $d;
			$b .= dechex($d & 15);
			$f++;
		}

		return $b;
	}

	function AvolittyHasher($a) {
		$a = AvolittyHasherA($a);
		$a = AvolittyHasherD($a);
		return $a;
	}
?>
