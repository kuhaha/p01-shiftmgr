<?php
if (!ini_get('lib/session.auto_start')) {
	session_start();
}
unset($_SESSION);
session_destroy();
header('Location:index.php');