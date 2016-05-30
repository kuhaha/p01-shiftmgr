<?php
include_once 'inc/session_inc.php';
include_once('inc/db_inc.php');
include_once('inc/func_inc.php');
if (isset($_POST['userid'])){
	$userid = $_POST['userid'];
	$pay = $_POST['pay'];
	$sql = "UPDATE tb_personpay SET pay={$pay} WHERE userid='{$userid}'" ;
	$rs = mysql_query($sql, $conn);
	$url = 'pay.php';
	header('Location:'. $url);
}
?>