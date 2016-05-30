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
//echo $userid . ' ' . $ym;
changeMonth("entry.php", $y, $m);

$d = days($y, $m);
$day1 = $y . '-' . $m .'-1';
$day2 = $y . '-' . $m .'-' . $d;

// Check work schedule of this month
$sql = 'SELECT * FROM tb_schedule WHERE sdate>=' .q1($day1). ' AND sdate<=' .q1($day2);
$rs = mysql_query($sql, $conn);
$row = mysql_fetch_array($rs);
$hday = array();
$hpay = array();
while ($row){
	$day = explode('-', $row['sdate']);
	$t = (int)$day[2];
	$hday[$t] = $row ['sname'];
	$hpay[$t] = $row ['addpay'];
	$row = mysql_fetch_array($rs);
}

// Check existing wish list
$sql = 'SELECT * FROM tb_wish WHERE userid='.q1($userid).' AND wdate>=' .q1($day1). ' AND wdate<=' .q1($day2);
$rs = mysql_query($sql, $conn);
$row = mysql_fetch_array($rs);

$wished = array();
while ($row){
	$tno = $row ['tno'];
	$day = explode('-', $row['wdate']);
	$t = (int)$day[2];
	if ($tno > 0){
		$cmt = $row ['wcomment'];
		if (empty($cmt)) $cmt = '';
		$wished[$t][$tno] = $cmt;
	}
	$row = mysql_fetch_array($rs);
}

$sql  = "SELECT * FROM tb_timespan ORDER BY tno";
$rs = mysql_query($sql, $conn);
$row = mysql_fetch_array($rs);

$timespan = array();
$timespan[0] = 'OFF';
$span = array();
while ($row){
	$tno = $row['tno'];
	$timespan[$tno] = $row['tname'] ;
	$span[$tno] = $row['tname']. ' : ' . $row['intime'] . '～' .$row['outime'];
	$row = mysql_fetch_array($rs);
}
echo '<th>＊OFFに関しては希望なしとする＊';
echo '<form action="entry_save.php" method="post">';
echo '<input type="hidden" name="ym" value='. q2($ym) .'>';
echo '<table class="table table-bordered table-hover">';
echo '<tr><th>日</th><th>曜日</th><th>営業予定</th><th>追加時給</th>';
echo '<th>希望';
foreach ($span as $t=>$s){
	echo '<br/>' . $s;
}
echo '</th>';
echo '<th>備考※スケジュールに要望がある際に記入</th></tr>';

$month = getMonth($y, $m);

//	echo th("希望");
//echo '<pre>';
//print_r($wished);
//echo '</pre>';
foreach($month as $t=>$th){
	echo '<tr>';
	echo $th;
	if (isset($hday[$t])){
		echo th($hday[$t],array("class"=>"sun"));
	}else{
		echo th('<br/>');
	}
	$cmt = '';
	$pay = isset($hpay[$t]) ? $hpay[$t] : 0;
	if ($pay>0) {
		$pay = '+' . ($pay);
	}else{
		$pay='';
	}
	echo '<td>'. $pay .'</td>';
	$radio = '';

	foreach ($timespan as $tno=>$span){
		$checked = '';
		if (isset($wished[$t][$tno])) {
			$checked ="checked";
			$cmt = $wished[$t][$tno];
		}
		$radio .= '<input type="radio" name="wish['.$t.']" value='.q2($tno).' '.$checked .'>' . $span;
	}
	echo td($radio);
	$input = '<input type="text" size=64 name="wcomment['.$t.']" value=' . q2($cmt) . '>' ;
	echo td($input);
	echo '</tr>';

}
echo '</table>';
echo '<p><input type="submit" value="登録">';
echo '</form>';

include_once('inc/page_footer.php');
?>