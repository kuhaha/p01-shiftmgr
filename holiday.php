<?php
include_once('lib/header_inc.php');
include_once('lib/db_inc.php');
include_once('lib/func_inc.php');

if (isset($userid) and isset($urole) ){
	if($urole > 1){
		$y = date('Y');
		$m = date('m');
		$ym = $y . $m;
		$vars = array_merge($_POST, $_GET);
		if (isset($vars['ym'])){
			$ym = $vars['ym'];
			$y = (int)substr($ym, 0,4);
			$m = (int)substr($ym, 4);
		}
		changeMonth("holiday.php", $y, $m);

		$d = days($y, $m);
		$day1 = $y . '-' . $m .'-1';
		$day2 = $y . '-' . $m .'-' . $d;

		// Check work schedule of this month
		$sql = 'SELECT * FROM tb_schedule WHERE sdate>=' .q1($day1). ' AND sdate<=' .q1($day2);
		$rs = mysql_query($sql, $conn);
		$row = mysql_fetch_array($rs);
		$hday = array();
		while ($row){
			$day = explode('-', $row['sdate']);
			$t = (int)$day[2];
			$hday[$t] = array($row['sname'],$row['addpay'],$row['scomment']);
			$row = mysql_fetch_array($rs);
		}
		echo '<form action="holiday_save.php" method="post">';
		echo '<input type="hidden" name="ym" value='. q2($ym) .'>';
		echo '<table border=1>';
		echo '<tr><th>日</th><th>曜日</th><th>営業予定</th><th>ィベント</th><th>追加時給</th>';
		$month = getMonth($y, $m);

		//	echo th("希望");
		foreach($month as $t=>$th){
			echo '<tr>';
			echo $th;
			$cmt = '';
			$pay = '';
			$nme = '';
			if (isset($hday[$t])){
				$nme = $hday[$t][0];
				$pay = $hday[$t][1];
				$cmt = $hday[$t][2];
			}
			$input = '<input type="text" size=4 name="hday['.$t.']" value='.q2($nme).'>';
			echo td($input);

			$input = '<input type="text" name="scomment[' . $t .']" value=' . q2($cmt) . '>' ;
			echo td($input);

			$input = '<input type="text" name="addpay[' . $t .']" value=' . q2($pay) . '>' ;
			echo td($input);

			echo '</tr>';
		}
		echo '</table>';
		echo '<p><input type="submit" value="登録">';
		echo '</form>';
	}
	echo '<p><a href="logout.php">ログアウト</a>';
}else{
	echo '<p><a href="login.php">ログイン</a>';
}