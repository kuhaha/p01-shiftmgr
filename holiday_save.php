<?php
include_once 'inc/session_inc.php';
include_once('inc/db_inc.php');
include_once('inc/func_inc.php');
if (isset($_SESSION['userid'])){
	$urole 	= $_SESSION['urole'];
	$userid = $_SESSION['userid'];

	$vars = array_merge($_POST, $_GET);
	if (isset($vars['ym'])){
		$ym = $vars['ym'];
		$y = (int)substr($ym, 0,4);
		$m = (int)substr($ym, 4);
		$d = days($y, $m);
		$day1 = $y . '-' . $m .'-1';
		$day2 = $y . '-' . $m .'-' . $d;


		//		echo '<pre>';
		//		print_r($vars);
		//		echo '</pre>';
		$hday = $vars['hday'];
		$memo = $vars['scomment'];
		$hpay = $vars['addpay'];

		$values = '';
		$i=0;
		foreach ($hday as $d=>$sname){
			if (strlen($sname)==0){
				continue;
			}
			$sdate = $y . '-' . $m . '-' . $d;
			$pay = (isset($hpay)) ? $hpay[$d] : 0;
			$mem = (isset($memo))? $memo[$d] : '';
			$value = array(q1($sdate), q1($sname),q1($pay), q1($mem));
			if ($i > 0) $values .= ',';
			$values .= '(' .implode(',', $value) . ')';
			$i++;
		}
		//echo $values;
		// transaction begin
		mysql_query( "set autocommit = 0", $conn);
		mysql_query( "begin", $conn);
		$sql = 'DELETE FROM tb_schedule WHERE sdate>=' .q1($day1). ' AND sdate<=' .q1($day2);
		$rs1 = mysql_query($sql, $conn);
		$sql = "INSERT INTO tb_schedule(sdate,sname,addpay,scomment) VALUES " . $values;
		$rs2 = mysql_query($sql, $conn);
		if ($rs1 and $rs2 ){
			mysql_query('commit', $conn );
		}else{
			mysql_query('rollback', $conn );
		}
		//echo $sql;
		//transaction end
		$url = 'index.php?ym='.$ym;
		header('Location:'. $url);

	}
}
?>