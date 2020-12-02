<?php
//html문서에 그려보기
function makeTable($arr, $str) {
	$len = 5;
	$table = "<p>{$str}</p><table style='width:50px;'>";
	$is_set = 0;
	
	for ($i = 0; $i < $len; $i++) {
		$table .= "<tr>";
		for ($j = 0; $j < $len; $j++) {
			foreach ($arr as $v) {
				if ($v[0] == $i && $v[1] == $j) {
					$is_set = 1;
				}
			}
			$table .= "<td>{$is_set}</td>";
			$is_set = 0;
		}
		$table .= "</tr>";
	}

	$table .= "</table>";

	echo $table;
}

$lock =	array(
			array(1, 1, 1, 1, 1),
			array(1, 1, 0, 1, 1),
			array(1, 0, 0, 1, 1),
			array(0, 1, 1, 1, 1),
			array(1, 1, 1, 1, 1)
		);
$key =	array(
			array(0, 0, 1, 0, 0),
			array(1, 1, 0, 0, 0),
			array(1, 0, 0, 0, 0),
			array(0, 0, 0, 0, 0),
			array(0, 0, 1, 0, 0)
		);
//솔루션
function sol($lock, $key) {
	$temp_key = $key;
	$shift = array();
	$unlock = 0;
	$es_cnt = 0;
	$lock_dim = chgOneDim($lock, 0);
	$key_dim = array();
	$ex_i = 0;
	$ex_j = 0;

	//시계방향으로 회전하며 확인
	for ($i = 0; $i < 4; $i++) {
		//좌표형식으로 변경
		$key_dim = chgOneDim($temp_key, 1);
		//key의 1갯수만큼 반복하며 찍음
		for ($m = 0; $m < count($key_dim); $m++) {
			//첫 좌표계의 lock과 key의 차
			$ex_i = $key_dim[0][0] - $lock_dim[0][0];
			$ex_j = $key_dim[0][1] - $lock_dim[0][1];
			//key의 좌표를 lock의 첫좌표 기준으로 맞춤
			foreach ($key_dim as $k => $v) {
				$key_dim[$k][0] = $v[0] - $ex_i;
				$key_dim[$k][1] = $v[1] - $ex_j;
			}
			//key와 lock의 좌표를 비교
			for ($k = 0; $k < count($lock_dim); $k++) {
				if (($key_dim[$k][0] == $lock_dim[$k][0]) &&
					 ($key_dim[$k][1] == $lock_dim[$k][1])) {
					$unlock++;
				}
			}
			//lock의 모든 좌표가 key와 같으면
			if ($unlock == count($lock_dim)) {
				//key의 남은 좌표가 lock의 좌표에서 벗어나있는지 확인
				for ($l = count($lock_dim); $l < count($key_dim); $l++) {
					if ($key_dim[$l][0] < 0 || $key_dim[$l][0] > (count($lock) - 1) ||
						$key_dim[$l][1] < 0 || $key_dim[$l][1] > (count($lock[0]) - 1)) {
						$es_cnt++;
					}
				}
				//벗어나 있으면 성공
				if ($es_cnt == (count($key_dim) - count($lock_dim))) {
					return 'true';
				}
			}
			//맞지 않으면 key의 첫좌표를 맨뒤로 보낸뒤 다음 좌표로 비교
			$shift = array_shift($key_dim);
			array_push($key_dim, $shift);
			//체크 변수 초기화
			$unlock = 0;
			$es_cnt = 0;
		}
		//한 방향에서 안맞으면 90도 회전후 다시 확인
		$temp_key = rotate($temp_key);
	}
	//모두 안맞으면 실패
	return 'false';
}
//시계방향으로 회전한다
function rotate($arr) {
	$nArr = array();
	$col = array();

	for ($i = 0; $i < count($arr); $i++) {
		for ($j = count($arr) - 1; $j >= 0; $j--) {
			array_push($col, $arr[$j][$i]);
		}
		array_push($nArr, $col);
		$col = array();
	}

	return $nArr;
}
//2차원 배열 형태를 좌표형식으로 바꾼다
function chgOneDim($arr, $num) {
	$dim = array();

	for ($i = 0; $i < count($arr); $i++) {
		for ($j = 0; $j < count($arr[0]); $j++) {
			if ($arr[$i][$j] == $num) {
				$dim[] = array($i, $j);
			}
		}
	}

	return $dim;
}

echo sol($lock, $key);
?>

<?php
$n = 12;
$weak = array(1, 5, 6, 10);
$dist = array(1, 2, 3, 4);

//n 200 weak 15 n-1 dist 8 100

function generateDummy(&$n, &$weak, &$dist) {
	$n = mt_rand(1, 200);
	
	for ($i = 0; $i < mt_rand(1, 15); $i++) {
		$temp = mt_rand(1, $n - 1);
		
		if (!in_array($temp, $weak)) {
			$weak[] = $temp;
		}
	}
	sort($weak);

	for ($i = 0; $i < mt_rand(1, 8); $i++) {
		$temp = mt_rand(1, 100);

		if (!in_array($temp, $dist)) {
			$dist[] = $temp;
		}
	}
	sort($dist);
}

function printTxt($var, $p = 1) {
	if (is_array($var)) {
		if ($p == 1) {
			echo "<xmp>";
			print_r($var);
			echo "</xmp>";
		} else if ($p == 2) {
			$table = "<table style='width:50px;'>";
			
			for ($i = 0; $i < count($var); $i++) {
				$table .= "<tr>";
				for ($j = 0; $j < count($var[$i]); $j++) {
					$table .= "<td>{$var[$i][$j]}</td>";
				}
				$table .= "</tr>";
			}

			$table .= "</table>";

			echo $table;
		}
	} else {
		echo $var;
	}
	echo "<p>";
}

function sol($n, $weak, $dist) {
	$roots = array();
	$result = 0;
	$temp = array();
	$temp2 = array();
	
	for ($i = 0; $i < count($dist); $i++) {
		$roots[] = findWeaks($n, $weak, $dist[$i]);

	}

	for ($i = 0; $i < count($dist); $i++) {
		$result = isSolve(array(), 0, $i, $weak , $roots);
		if($result != 0) {
			return $result;
			exit;
		}
	}

	return $result;
}

function isSolve($temp, $cnt, $amo, $weak, $roots) {
	$tarr = $temp;
	$result = array();
	if ($cnt == $amo) {
		for ($i = ($cnt); $i < count($roots); $i++) {
			for ($j = 0; $j < count($roots[$i]); $j++) {
				$tarr[] = $roots[$i][$j];
				for ($k = 0; $k < count($tarr); $k++) {
					$result = array_merge($result, $tarr[$k]);
				}
				$result = array_unique($result);
				sort($result);

				if ($weak == $result) {
					return ($cnt + 1);
				}
				$tarr = $temp;
				$result = array();
				$diff = array();
			}
		}

		
		return 0;
	}

	for ($i = $cnt; $i < count($roots); $i++) {
		for ($j = 0; $j < count($roots[$i]); $j++) {
			$tarr[] = $roots[$i][$j];
			isSolve($tarr, $cnt + 1, $amo, $weak, $roots);
			$tarr = $temp;
		}
	}
}

function findWeaks($n, $weak, $distOne) {
	$sour = 0;
	$temp = 0;
	$root = array();
	$pl_root = array();
	$mi_root = array();
	$weaks = array();

	for ($i = 0; $i < count($weak); $i++) {
		$sour = $weak[$i];

		for ($j = 0; $j <= $distOne; $j++) {
			$temp = $sour + $j;
			if ($temp >= $n) {
				$temp = $temp % $n;
			}
			if (in_array($temp, $weak)) {
				$pl_root[] = $temp;
			}

			$temp = $sour - $j;
			if ($temp < 0) {
				$temp = $n + $temp;
			}
			if (in_array($temp, $weak)) {
				$mi_root[] = $temp;
			}
		}
		$root[] = $pl_root;
		$root[] = $mi_root;
		$pl_root = array();
		$mi_root = array();
	}

	return $root;
}
?>



<?php
//k2017 1
/*
	$n = 5;
	$arr1 = array(9, 20, 28, 18, 11);
	$arr2 = array(30, 1, 21, 17, 28);
*/

	$n = 6;
	$arr1 = array(46, 33, 33, 22, 31, 50);
	$arr2 = array(27, 56, 19, 14, 14, 10);

	function toBi($dec, $n) {
		$rem = 0;
		$temp = '';

		while ($dec > 1) {
			$rem = $dec % 2;
			ceil($dec = $dec / 2);

			if ($rem == 1) {
				$temp = '1' . $temp;
			} else {
				$temp = '0' . $temp;
			}
		}

		if ($dec == 1) {
			$temp = '1' . $temp;
		}

		$temp = str_pad($temp, $n, "0", STR_PAD_LEFT);

		return $temp;
	}
	function sol($n, $arr1, $arr2) {
		$temp1 = '';
		$temp2 = '';
		$part1 = '';
		$part2 = '';
		$complete_parts = '';
		$complete_arr = array();
		$temp_parts = '';

		for ($i = 0; $i < $n; $i++) {
			$temp1 = toBi($arr1[$i], $n);
			$temp2 = toBi($arr2[$i], $n);
			for ($j = 0; $j < $n; $j++) {
				$part1 = substr($temp1, $j, 1);
				$part2 = substr($temp2, $j, 1);
				if ($part1 == '1' || $part2 == '1') {
					$complete_parts .= '1';
				} else {
					$complete_parts .= '0';
				}
			}
			$temp_parts = str_replace("1", "#", $complete_parts);
			$temp_parts = str_replace("0", " ", $temp_parts);
			$complete_parts = '';

			$complete_arr[] = $temp_parts;
		}

		print_r($complete_arr);
	}
	sol($n, $arr1, $arr2);
?>

<?php //k 2017 2
	$dr = '1S2D*3T';
	$dr2 = '1D2S#10S';
	$dr3 = '1D2S0T';
	$dr4 = '1S*2T*3S';
	$dr5 = '1D#2S*3S';
	$dr6 = '1T2D3D#';
	$dr7 = '1D2S3T*';

	function sol($dr) {
		$arr = array();
		$result = 0;
		$temp = '';
		for ($i = 0; $i < strlen($dr); $i++) {
			$temp = substr($dr, $i, 1);

			if (is_numeric($temp)) {
				if ($temp == '1' && substr($dr, ($i + 1), 1) == '0') {
					$arr[] = 10;
					$i++;
					continue;
				}
				$arr[] = $temp;
				continue;
			}

			switch ($temp) {
				case 'D' :
					double($arr[count($arr) - 1]);
					break;
				case 'T' :
					trifle($arr[count($arr) - 1]);
					break;
				case '*' :
					star($arr);
					break;
				case '#' :
					acha($arr[count($arr) - 1]);
			}
		}

		for ($i = 0; $i < count($arr); $i++) {
			$result += $arr[$i];
		}

		echo $result;
	}

	function star(&$arr) {
		$arr[count($arr) - 1] *= 2;
		if (!empty($arr[count($arr) - 2])) {
			$arr[count($arr) - 2] *= 2;
		}
	}

	function acha(&$score) {
		$score *= -1;
	}

	function double(&$score) {
		$score = $score * $score;
	}

	function trifle(&$score) {
		$score = $score * $score * $score;
	}

	sol($dr3);
?>

<?php //k 2017 3
	$cacheSize = 2;
	$cities = array("newyork", "newyork", "NewYork", "newyork");

	function sol($cacheSize, $cities) {
		$cache = array();
		$proc_time = 0;
		$temp = "";

		for ($i = 0; $i < count($cities); $i++) {
			$temp = strtolower($cities[$i]);
			$proc_time += check($cache, $cacheSize, $temp);
			echo "<xmp>";
			print_r($cache);
			echo "</xmp>";
		}

		return $proc_time;
	}

	function check(&$cache, $cacheSize, $city) {

		if (in_array($city, $cache)) {
			array_splice($cache, array_search($city, $cache), 1);
			array_push($cache, $city);

			return 1;
		}

		if (count($cache) >= $cacheSize) {
			array_shift($cache);
		}

		if ($cacheSize > 0) {
			array_push($cache, $city);
		}

		return 5;
	}

	echo sol($cacheSize, $cities);
?>

<?php //k 2017 4
	$n = array(1, 2, 2, 1, 1, 10);
	$t = array(1, 10, 1, 1, 1, 60);
	$m = array(5, 2, 2, 5, 1, 45);
	$timetable = array(
		array("08:01", "08:02", "08:03"),
		array("09:10", "09:09", "08:00"),
		array("09:00", "09:00", "09:00", "09:00"),
		array("00:01", "00:01", "00:01", "00:01", "00:01"),
		array("23:59"),
		array("23:59", "23:59", "23:59", "23:59", "23:59", "23:59", "23:59", "23:59", "23:59", "23:59", "23:59", "23:59", "23:59", "23:59", "23:59", "23:59")
	);
	//09:00
	//09:09
	//08:59
	//00:00
	//09:00
	//18:00

	//마지막
	//

	function sol($n, $t, $m, $timetable) {
		$last_pass = 0;
		$pass_cnt = 0;
		$bus_time = "0900";
		$temp_time = "";
		$result_time = "";

		for ($i = 0; $i < count($timetable); $i++) {
			$timetable[$i] = str_replace(":", "", $timetable[$i]);
		}
		sort($timetable);

		for ($i = 0; $i < $n; $i++) {
			for ($j = 0; $j < $m; $j++) {
				if ($pass_cnt >= count($timetable)) {
					continue;
				}
				$temp_time = str_replace(":", "", $timetable[$pass_cnt]);
				$temp_time = makeTime($temp_time, 0);

				if ($bus_time >= $temp_time) {
					$pass_cnt++;
					if ($i == $n - 1) {
						$last_pass++;
					}
				}
			}

			$bus_time = makeTime($bus_time, $t);
		}
		if ($last_pass >= $m) {
			$result_time = str_replace(":", "", $timetable[$pass_cnt - 1]);
			$result_time = makeTime($result_time, -1);
		} else {
			$result_time = makeTime("0900", ($n - 1) * $t);
		}

		return $result_time;
	}

	function makeTime($time, $v) {
		$result = 0;
		$temp = substr($time, 2, 2) + $v;

		if ($temp >= 60) {
			$result = substr($time, 0, 2) + (floor($temp / 60));
			$result = str_pad($result, 2, "0", STR_PAD_LEFT);
			$result .= str_pad(($temp % 60), 2, "0", STR_PAD_LEFT);
		} else if ($temp < 0) {
			$result = substr($time, 0, 2) + (floor($temp / 60));
			$result = str_pad($result, 2, "0", STR_PAD_LEFT);
			$result .= str_pad((60 + $temp), "0", STR_PAD_LEFT);
		} else {
			$result = str_pad(($time + $v), 4, "0", STR_PAD_LEFT);
		}

		return $result;
	}

	$q = 0;

	echo sol($n[$q], $t[$q], $m[$q], $timetable[$q]);
?>

<?php	//k 2017 5
$str1 = array('france', 'handshake', 'aa1+aa2', 'E=M*C^2');
$str2 = array('FRENCH', 'shake hands', 'AAAA12', 'E=M*C^2');
//16384, 65536, 43690, 65536
function pushStr(&$arr, $str) {
	$str = strtolower($str);

	if (!is_array($arr)) {
				echo 'asdsadas';
		return;
	}
	if (!preg_match("/[a-z]{2}/", $str)) {
		return;
	}
	
	array_push($arr, $str);

	return;
}

function makeStrToSlicedArr($str) {
	$arr = array();
	$temp = "";
	$len = strlen($str) - 1;

	for ($i = 0; $i < $len; $i++) {
		$temp = substr($str, $i, 2);
		
		if (strlen($temp) < 2) {
			continue;
		}
		pushStr($arr, $temp);
	}

	return $arr;
}
function makeDiff($arr1, $arr2) {
	$idx = 0;

	for ($i = 0; $i < count($arr1); $i++) {
		$idx = array_search($arr1[$i], $arr2);
		if ($idx === false) {
			continue;
		}
		array_splice($arr2, $idx, 1);
	}

	return $arr2;
}

function makeUnion($arr1, $arr2) {
	$arr = array();
	$diff_arr1 = makeDiff($arr1, $arr2);
	$diff_arr2 = makeDiff($arr2, $arr1);
	$inter_arr = makeInterSection($arr1, $arr2);
	$arr = array_merge($diff_arr1, $diff_arr2, $inter_arr);

	return $arr;
}

function makeInterSection($arr1, $arr2) {
	$temp = "";
	$arr = array();
	$idx = 0;

	for ($i = 0; $i < count($arr1); $i++) {
		$idx = array_search($arr1[$i], $arr2);
		if ($idx === false) {
			continue;
		}
		$temp = array_splice($arr2, $idx, 1);
		array_push($arr, $temp[0]);
	}

	return $arr;
}

function sol($str1, $str2) {
	$answer = 0;
	$arr1 = makeStrToSlicedArr($str1);
	$arr2 = makeStrToSlicedArr($str2);
	$inter_arr = makeInterSection($arr1, $arr2);
	$union_arr = makeUnion($arr1, $arr2);

	if (count($union_arr) != 0) {
		$answer = count($inter_arr) / count($union_arr);
	} else {
		$answer = 1;
	}
	$answer =  floor($answer * 65536);

	return $answer;
}

$t = 0;
$result['an'] = json_encode(sol($str1[$t], $str2[$t]));
?>

<?php //k 2017 6
	$m = array(4, 6);
	$n = array(5, 6);
	$board = array(
		 array("CCBDE", "AAADE", "AAABF", "CCBBF"),
		 array("TTTANT", "RRFACC", "RRRFCC", "TRRRAA", "TTMMMF", "TMMTTJ")
	);

	function sol($m, $n, $board) {
		$score = 0;
		$arr = splitArr($board);
		$arr2 = array();

		while (true) {
			$arr2 = removeProcess($m, $n, $arr, $score);

			if (empty($arr2)) {
				break;
			}
			moveDownProcess($m, $n, $arr, $arr2);		
		}
		return $score;
	}
	//return bool
	function moveDownProcess($m, $n, &$board, $el_arr) {
		$empty_depth = 0;

		for ($j = 0; $j < count($el_arr); $j++) {
			while ($empty_depth != -1) {
				$empty_depth = checkEmpty($board, $el_arr[$j], $m);
				moveDownBlock($board, $el_arr[$j], $m, $empty_depth);
			}
			$empty_depth = 0;
		}
	}

	function moveDownBlock(&$board, $l, $m, $depth) {
		$temp = 0;

		for ($d = $depth; $d >= 0; $d--) {
			if ($board[$d][$l] != "@") {
				$temp = $d;
				break;
			}
		}

		for ($i = $temp; $i < $depth; $i++) {
			$board[$i + 1][$l] = $board[$i][$l];
			$board[$i][$l] = "@";
		}
	}

	function checkEmpty($board, $l, $m) {
		$temp = 0;
		for ($d = ($m - 1); $d >= 0; $d--) {
			if ($board[$d][$l] == "@") {
				$temp = $d;
				break;
			}
		}

		for ($d = $temp; $d >= 0; $d--) {
			if ($board[$d][$l] != "@") {
				return $temp;
			}
		}
		return -1;
	}


	function removeProcess($m, $n, &$board, &$score) {
		$arr = array();
		$arr2 = array();
		
		for ($i = 0; $i < ($m - 1); $i++) {
			for ($j = 0; $j < ($n - 1); $j++) {
				if ($board[$i][$j] == "@") {
					continue;
				}
				if (checkSquare($board, $i, $j)) {
					$arr[] = array($i, $j);
					$arr2[] = $j;
					$arr2[] = $j + 1;
				}
			}
		}
		$score += removeBlock($arr, $board);
		$arr2 = array_unique($arr2);
		$arr2 = array_values($arr2);

		return $arr2;
	}

	function removeBlock($arr, &$board) {
		$score = 0;
		$x = array(0, 1, 0, 1);
		$y = array(0, 0, 1, 1);

		$mod_x = 0;
		$mod_y = 0;

		for ($i = 0; $i < count($arr); $i++) {
			for ($j = 0; $j < 4; $j++) {
				$mod_x = $arr[$i][1] + $x[$j];
				$mod_y = $arr[$i][0] + $y[$j];

				if ($board[$mod_y][$mod_x] != "@") {
					$board[$mod_y][$mod_x] = "@";
					$score++;
				}
			}
		}

		return $score;
	}

	function checkSquare($board, $h, $l) {
		$x = array(1, 0, 1);
		$y = array(0, 1, 1);

		$mod_x = 0;
		$mod_y = 0;

		for ($i = 0; $i < 3; $i++) {
			$mod_x = $l + $x[$i];
			$mod_y = $h + $y[$i];
			if ($board[$h][$l] != $board[$mod_y][$mod_x]) {
				return false;
			}
		}
		return true;
	}

	function splitArr($board) {

		for ($i = 0; $i < count($board); $i++) {
			$str_to_arr[] = str_split($board[$i]);
		}

		return $str_to_arr;
	}

	function mkt($board) {
		$table = "<table>";

		for ($i = 0; $i < count($board); $i++) {
			$table .= "<tr>";
			for ($j = 0; $j < count($board[$i]); $j++) {
				$table .= "<td>" . $board[$i][$j] . "</td>";
			}
			$table .= "</tr>";
		}
		$table .= "</table><br>";

		echo $table;
	}
	$t = 0;
	echo sol($m[$t], $n[$t], $board[$t]);
?>

<?php //k 2017 7
	$lines = array(
		array(
			"2016-09-15 01:00:02.001 2.0s",
			"2016-09-15 01:00:07.000 2s" //1
		),
		array(
			"2016-09-15 01:00:04.002 2.0s",
			"2016-09-15 01:00:07.000 2s" //2
		),
		array(
			"2016-09-15 20:59:57.421 0.351s",
			"2016-09-15 20:59:58.233 1.181s",
			"2016-09-15 20:59:58.299 0.8s",
			"2016-09-15 20:59:58.688 1.041s",
			"2016-09-15 20:59:59.591 1.412s",
			"2016-09-15 21:00:00.464 1.466s",
			"2016-09-15 21:00:00.741 1.581s",
			"2016-09-15 21:00:00.748 2.31s",
			"2016-09-15 21:00:00.966 0.381s",
			"2016-09-15 21:00:02.066 2.62s" //7
		)
	);

	function cleanArr($t) {
		$temp = explode(" ", $t);
		$t1 = str_replace(":", "", $temp[1]);
		$t2 = minusTime($t1, $temp[2]);
		$result = array();

		$result[] = $t1;
		$result[] = $t2;

		return $result;
	}

	function minusTime($t, $mi) {
		$h = substr($t, 0, 2);
		$m = substr($t, 2, 2);
		$s = substr($t, 4);
		$result = 0;
		$proc_t = round($mi - 0.001, 3);

		$s = round($s - $proc_t, 3);

		if ($s < 0) {
			$m = $m - 1;
			$s = round(60 + $s, 3);

			if ($m < 0) {
				$h = $h - 1;
				$m = 60 + $m;

				if ($h < 10) {
					$m = "0" . $h;
				}
			}

			if ($m < 10) {
				$m = "0" . $m;
			}
		}

		if ($s < 10) {
			$s = "0" . $s;
		}

		$result = $h . $m . $s;

		return $result;
	}

	function countProc($logs, $t) {
		$cnt = 0;

		$et = $t;
		$st = minusTime($t, 1);

		for ($i = 0; $i < count($logs); $i++) {
			if (($st >= $logs[$i][0] && $st <= $logs[$i][1]) ||
				($et >= $logs[$i][0] && $et <= $logs[$i][1]) ||
				($st <= $logs[$i][0] && $et >= $logs[$i][1]) ||
				($st >= $logs[$i][0] && $et <= $logs[$i][1])) {
				$cnt++;
			}
		}
		return $cnt;
	}
	function sol($lines) {
		$cnt = 0;
		$logs = array();
		$t = 0.0;

		for ($i = 0; $i < count($lines); $i++) {
			$logs[] = cleanArr($lines[$i]);
		}

		for ($i = 0; $i < count($logs); $i++) {
			for ($j = 0; $j < 2; $j++) {
				$cnt = max($cnt, countProc($logs, $logs[$i][$j]));
			}
		}
		
		return $cnt;
	}

	$t = 2;
	echo(sol($lines[$t]));
?>

<?php //k 2018 1
	$record = array("Enter uid1234 Muzi", "Enter uid4567 Prodo", "Leave uid1234", "Enter uid1234 Prodo", "Change uid4567 Ryan");

	function solution($record) {
		$nic = array();
		$result = array();
		$temp = array();
		$key = "";
		$pos = "";

		for ($i = 0; $i < count($record); $i++) {
			$temp = explode(" ", $record[$i]);

			if (!isset($nic[$temp[1]])) {
				$nic[$temp[1]] = $temp[2];
			}

			switch($temp[0]) {
				case "Enter" :
					$result[] = $temp[1] . "님이 들어왔습니다.";
					break;
				case "Leave" :
					$result[] = $temp[1] . "님이 나갔습니다.";
				case "Change" :
					$nic[$temp[1]] = $temp[2];
			}
		}

		for ($i = 0; $i < count($result); $i++) {
			$pos = strpos($result[$i], "님");
			$key = substr($result[$i], 0, $pos);
			$result[$i] = str_replace($key, $nic[$key], $result[$i]);
		}

		return $result;
	}
	print_r(solution($record));
?>


<?php //k 2018 2
	$n = array(5, 4);
	$stages = array(
		 array(2, 1, 2, 6, 2, 4, 3, 3),
		 array(4, 4, 4, 4, 4)
		 );

	function solution($n, $stages) {
		$arr = array();
		$result = array();
		$score = 0;
		$no = 0;
		$compare = 0;
		$key = 0;

		for ($i = 1; $i <= $n; $i++) {
			for ($j = 0; $j < count($stages); $j++) {
				if ($stages[$j] == $i) {
					$no++;
				}
			}
			$score = $no / $n;
			$arr[] = $score;
			$no = 0;
		}
			echo "<xmp>";
			print_r($arr);
			echo "</xmp>";
		while (count($arr) > 0) {
			$compare = (count($stages) + 1) / $n;

			foreach ($arr as $k => $v) {
				if ($compare > $v) {
					$compare = $v;
					$key = $k;
				}
			}
			$result[] = $key + 1;
			unset($arr[$key]);
			echo "<xmp>";
			print_r($arr);
			echo "</xmp>";
		}

		print_r($result);
	}

	$t = 1;

	solution($n[$t], $stages[$t]);
?>