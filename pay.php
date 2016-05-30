<?php
include_once('inc/page_header.php');
include_once('inc/db_inc.php');
include_once('inc/func_inc.php');

$userid=$_SESSION['userid'] ;
$urole=$_SESSION['urole'] ;
if($urole!=8){
	exit;
}
echo '<h2>時給設定（個人）</h2>';
echo '※勤務態度の評価は5段階である';
echo '<table class="table table-bordered table-hover">';
echo '<tr class="bg-danger"><th>氏名</th><th>勤続日数</th><th>評価</th><th>プラス時給</th></tr>';
$sql = 'SELECT p.*,u.uname FROM tb_personpay p, tb_user u WHERE p.userid=u.userid' ;
//echo $sql;
$rs = mysql_query($sql, $conn);
$row = mysql_fetch_array($rs);

while ($row){
	$uid= $row['userid'];
	$uname= $row['uname'];
	$workdays=$row['workdays'];
	$valuation=$row['valuation'];
	$pay=$row['pay'];
	echo '<tr>';
	echo '<td>' .  $uname. '</td>';
	echo '<td>' .  $workdays. '</td>';
	echo '<td>' .  $valuation. '</td>';
	echo '<td>' ;
	echo '<form action="pay_save.php" method="post">';
	echo '<input type="hidden" name="userid" value='. q2($uid) .'>';
	echo '+<input type="text" name="pay" size=6 value='. q2($pay) .'>円';
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