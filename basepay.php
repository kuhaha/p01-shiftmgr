<?php
include_once('inc/page_header.php');
include_once('inc/db_inc.php');
include_once('inc/func_inc.php');

if (!isset($_SESSION['urole']) or $_SESSION['urole']!=8){
	// stuffs public come here
	include('public.php');
	include_once('inc/page_footer.php');
	exit;
}
$cid = $userid;
echo '<h2>基本時給設定</h2>';
echo '<table class="table table-bordered table-hover">';
echo '<tr class="bg-danger"><th>年　度</th><th>予想売り上げ(万円)</th><th>基本時給(円)</th></tr>';
$sql = 'SELECT * FROM tb_incom WHERE cid=' .q1($cid);
//echo $sql;
$rs = mysql_query($sql, $conn);
$row = mysql_fetch_array($rs);

while ($row){
	$yy= $row['yy'];
	$money=$row['money'];
	$basepay=$row['basepay'];
	echo '<tr>';
	echo '<td>' .  $yy . '</td>';
	echo '<td>' .  $money . '</td>';
	echo '<td>' ;
	echo '<form action="basepay_save.php" method="post">';
	echo '<input type="hidden" name="cid" value='. q2($cid) .'>';
	echo '<input type="hidden" name="yy" value='. q2($yy) .'>';
	echo '<input type="text" name="basepay" size=6 value='. q2($basepay) .'>円';
	echo '<input type="submit" value="設定/再設定">';
	echo '</form>';

	echo '</td>';
	echo '</tr>';
	$row = mysql_fetch_array($rs);
}
/*
 echo '<tr>';
 $input = td('<input type="text" name="yy" value="'.(date('Y')+1).'">') ;
 $input .= td('<input type="text" name="money">') ;
 $input .= td('<input type="text" name="basepay">') ;
 echo ($input);
 echo '</tr>';
 */
echo '</table>';

include_once('inc/page_footer.php');

?>