<?php
//DBサーバへ接続。接続IDを変数$connに代入
$conn = mysql_connect("localhost","root","");  //ユーザ名：root/パスワード：なし
mysql_select_db("p01shift", $conn);  // 使用するデータベースをに指定
mysql_query('set names utf8', $conn);  //接続時の文字コードをutf8に設定
