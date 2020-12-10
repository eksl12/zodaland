<?php //k 2019 3
$relation = array(
	array("100", "ryan", "music", "2"),
	array("200", "apeach", "math", "2"),
	array("300", "tube", "computer", "3"),
	array("400", "con", "computer", "4"),
	array("500", "muzi", "music", "3"),
	array("600", "apeach", "music", "2")
);
function solution($relation) {
	$result_arr = array();
	$temp_arr = array();
	for ($i = 1; $i <= count($relation[0]); $i++) {

		$temp_arr = array_values(check($i, $relation, $result_arr));

		foreach($temp_arr as $val) {
			$result_arr[] = $val;
		}
	}
	
	return count($result_arr);
}
function check($cnt, $relation, $key_arr) {
	$st = array();
	$result_arr = array();
	$temp = 0;
	while(true) {

		//cnt만큼인지 확인한다
		//참이면 확인 함수 실행한후 pop
		if (count($st) == $cnt) {
			if (checkAlready($key_arr, $st)) {
				if (checkValid($st, $relation)) {
					$result_arr[] = $st;
				}
			}
			array_pop($st);
		}
		//temp >= len 이면 st비운다
		//그냥 temp = array_pop(st) + 1 하면됨
		if ($temp >= count($relation[0])) {
			while (count($st) > 0) {
				$temp = array_pop($st) + 1;
			}
			if ($temp == (count($relation[0]) - $cnt + 1)) {
				break;
			}
		}
		//push -> temp++
		array_push($st, $temp++);
	}

	return $result_arr;
}

function checkValid($location, $relation) {
	for ($i = 0; $i < count($relation); $i++) {
		for ($j = $i + 1; $j < count($relation); $j++) {
			if (!checkUnique($relation[$i], $relation[$j], $location)) {
				return false;
			}
		}
	}

	return true;
}

function checkUnique($col1, $col2, $location) {
	foreach ($location as $k) {
		if ($col1[$k] != $col2[$k]) {
			return true;
		}
	}

	return false;
}

function checkAlready($key_arr, $compare) {
	$temp_arr = array();
	foreach($key_arr as $val) {
		$temp_arr = array_diff($val, $compare);
		if (empty($temp_arr)) {
			return false;
		}
	}

	return true;
}

echo solution($relation);
?>
