<?php
include_once('inc/page_header.php');
include_once('inc/db_inc.php');
include_once('inc/func_inc.php');

	$y = date('Y');
	$m = date('m');
	$ym = $y . $m;
	$vars = array_merge($_POST, $_GET);
	if (isset($vars['ym'])){
		$ym = $vars['ym'];
		$y = substr($ym, 0,4);
		$m = substr($ym, 4);
	}
	changeMonth("index.php", $y, $m);

	$sql  = "SELECT * FROM tb_timespan ORDER BY tno";
	$rs = mysql_query($sql, $conn);
	$row = mysql_fetch_array($rs);
	$timespan = array();
	while ($row){
		$tname = $row['tname'];
		$timespan[$tname] = $row['intime'] . '～' .$row['outime'];
		$row = mysql_fetch_array($rs);
	}
	if ($urole==1){
		echo '<p><form action="entry.php" method="post">';
		echo '<input type="hidden" name="ym" value="'.$ym.'">';
		echo '<input type="submit" value="希望登録">';
		echo '</form>';
	}else {
		echo '<p><form action="holiday.php" method="post">';
		echo '<input type="hidden" name="ym" value="'.$ym.'">';
		echo '</form>';
	}

	echo '<form action="decide_save.php" method="post">';
	echo '<input type="hidden" name="ym" value="'.$ym.'">';
	echo '<table border=1>';
	printMonth($y, $m);

	$d = days($y, $m);

	$day1 = $y . '-' . $m .'-1';
	$day2 = $y . '-' . $m .'-' . $d;

	$sql = 'SELECT * FROM tb_schedule WHERE sdate>=' .q1($day1). ' AND sdate<=' .q1($day2);
	$rs = mysql_query($sql, $conn);
	$row = mysql_fetch_array($rs);

	$hday = array();
	while ($row){
		$day = explode('-', $row['sdate']);
		$t = (int)$day[2];
		$hday[$t] = $row ['sname'];
		$row = mysql_fetch_array($rs);
	}
	echo '<tr>';
	echo th('<br/>');
	for ($i=1; $i<=$d; $i++){
		$day = '<br/>';
		if (isset($hday[$i])){
			$day = $hday[$i];
		}
		echo th( $day);

	}
	echo '</tr>';

	$sql  = 'SELECT * FROM tb_wish NATURAL JOIN tb_timespan WHERE wdate>=' . q1($day1) .' AND wdate<=' .q1($day2);

	$rs = mysql_query($sql, $conn);
	$row = mysql_fetch_array($rs);

	$wish = array();
	$total = array();
	while ($row){
		$userid = $row['userid'];
		$tno = $row['tno'];
		$tname = $row['tname'];
		$decision = $row['decision'];
		//if ($w > 0){
		$day = explode('-', $row['wdate']);
		$t = (int)$day[2];
		$wish[$userid][$t] = array($tno,$tname,$decision);
		if (isset($total[$t][$tno])){
			$total[$t][$tno]++;
		}else{
			$total[$t][$tno] = 1;
		}
		//}
		$row = mysql_fetch_array($rs);
	}

	//ユーザごとのシフト希望

	$sql  = "SELECT * FROM tb_user WHERE urole=1";
	$rs = mysql_query($sql, $conn);
	$row = mysql_fetch_array($rs);
	while ($row){
		echo '<tr>';
		$uname = $row['uname'];
		$userid = $row['userid'];
		echo th($uname);
		for ($t=1; $t<=$d; $t++){
			$th = '<br/>';
			if (isset($wish[$userid][$t])){
				$day = $wish[$userid][$t];
				$tno = $day[0];
				$tname = $day[1];
				$decision = $day[2];
				$option = array('type'=>'checkbox','name'=>'a['.$userid.']['.$t.']','value'=>$tno);
				if ($decision) $option['checked'] = 'checked';
				$th = tag('input','',$option) . $tname;
			}
			echo th($th);
		}
		echo '</tr>';
		$row = mysql_fetch_array($rs);
	}
	//集計
//	echo '<tr>';
//	echo th('合計',array('colspan'=>$d+1)) ;
//	echo '</tr>';
//	printMonth($y, $m);
//
//	foreach ($timespan as $w=>$span){
//		echo '<tr>';
//		echo th($w ." : " . $span);
//		for ($t=1; $t<=$d; $t++){
//			$sum = '<br/>';
//			if (isset($total[$t][$w])){
//				$sum = $total[$t][$w];
//			}
//			echo th($sum);
//		}
//		echo '</tr>';
//	}
	echo '</table>';

echo tag('input','',array('type'=>'submit','value'=>'決定'));
echo '</form>';
include_once('inc/page_footer.php');
?>