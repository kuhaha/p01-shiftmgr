<?php
include_once('inc/session_inc.php');
include_once('inc/db_inc.php'); //データベースに接続する。接続ID：$conn

if (isset($_POST['user']) and isset($_POST['pass']))  {
	$user = $_POST['user'];
	$pass = $_POST['pass'];
	$sql = "SELECT * FROM tb_user WHERE userid= '{$user}'  AND passwd='{$pass}'";
	$rs = mysql_query($sql, $conn);
	if (!$rs) {
		die('エラー: ' . mysql_error());
	}
	$row = mysql_fetch_object($rs);

	if ($row){ // 認証成功:  認証済みユーザのIDをセッション変数に保持
		$_SESSION['userid'] 	= $row->userid; // 認証済みユーザのID
		$_SESSION['uname'] 	= $row->uname; 	// 認証済みユーザの名前
		$_SESSION['urole'] 	= $row->urole; 	// 認証済みユーザの役割
		header('Location:index.php'); // トップページへ遷移
		exit;
	}
}
$url = 'login.php';
header('Location:' . $url);
?>