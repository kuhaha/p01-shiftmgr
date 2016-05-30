<?php
//include_once('lib/header_inc.php');
include_once('inc/db_inc.php');
include_once('inc/func_inc.php');

if (isset($_POST['ym'])){
	$a = $_POST['a'];
	$ym = $_POST['ym'];
	$y = (int)substr($ym, 0,4);
	$m = (int)substr($ym, 4);
	if ($a){
		$date1 = $y . '-' . $m . '-1';
		$date2 = $y . '-' . $m . '-31';
		$sql  = "UPDATE tb_wish SET decision=0 WHERE wdate<='{$date2}' AND wdate>='{$date1}'";
		$rs = mysql_query($sql, $conn);
		//echo $sql . '<br>';
	}
	foreach ($a as $userid=>$wish){
		foreach ($wish as $d => $tno){
			$wdate = $y . '-' . $m . '-' . $d;
			//echo $userid . '...' . $wdate . '...' . $tno . '<br>';
			$sql  = "UPDATE tb_wish SET decision=1 WHERE wdate='{$wdate}' AND userid='{$userid}' AND tno={$tno}";
			//echo $sql . '<br>';
			$rs = mysql_query($sql, $conn);
		}
		header("Location: index.php");
	}
}else{
	echo '<p>エラー';
}

?>