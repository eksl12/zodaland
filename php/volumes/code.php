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
