<?php
include_once 'inc/session_inc.php';
include_once('inc/db_inc.php');
include_once('inc/func_inc.php');
if (isset($_POST['yy'])){
	$cid = $_POST['cid'];
	$yy = $_POST['yy'];
	$basepay = $_POST['basepay'];
	$sql = "UPDATE tb_incom SET basepay={$basepay} WHERE cid='{$cid}' AND yy=" . $yy;
	$rs = mysql_query($sql, $conn);
	$url = 'basepay.php';
	header('Location:'. $url);
}else{

}
