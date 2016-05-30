<?php
include_once 'inc/session_inc.php';
include_once('inc/db_inc.php');
include_once('inc/func_inc.php');
if (isset($_SESSION['userid'])){
	$urole 	= $_SESSION['urole'];
	$userid = $_SESSION['userid'];
}else{
		// stuffs public come here
	include('public.php');
	include_once('inc/page_footer.php');
	exit;
}

$ym = $_POST['ym'];
$y = substr($ym, 0,4);
$m = substr($ym, 4);
$d = days($y, $m);

$day1 = $y . '-' . $m .'-1';
$day2 = $y . '-' . $m .'-' . $d;

$wish = $_POST['wish'];
$memo = $_POST['wcomment'];

$values = '';
$i=0;
foreach ($wish as $d=>$tno){
	$wdate = $y . '-' . $m . '-' . $d;
	$mem = (isset($memo)) ? $memo[$d] : '';
	$value = array(q1($wdate), $tno, q1($userid), q1($mem));
	if ($i > 0) $values .= ',';
	$values .= '(' .implode(',', $value) . ')';
	$i++;
}
// transaction begin
mysql_query( "set autocommit = 0", $conn);
mysql_query( "begin", $conn);

$sql = 'DELETE FROM tb_wish WHERE userid=' .q1($userid) . 'AND wdate>=' .q1($day1). ' AND wdate<=' .q1($day2);

$rs1 = mysql_query($sql, $conn);
$sql = "INSERT INTO tb_wish(wdate,tno,userid,wcomment) VALUES " . $values;

$rs2 = mysql_query($sql, $conn);
if ($rs1 and $rs2 ){
	mysql_query('commit', $conn );
}else{
	mysql_query('rollback', $conn );
}
//transaction end

$url = 'index.php?ym=' . $ym;
header('Location:'. $url);
?>