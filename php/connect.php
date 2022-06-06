<?php

function db_connect()
{
	$dbConn = mysqli_connect('localhost', 'farm', 'farm1234', 'farm') or ('error');
	//mysqli_connect('連線位置','帳號','密碼','資料庫名稱')
	mysqli_query($dbConn, "SET NAMES 'utf8'");
	//設定連線過程傳輸編碼使用 utf8

	if ($dbConn) {
		return $dbConn;
	} else {
		die("連接失敗: " . mysqli_connect_error());
	}
}

function getClientIP()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

function uuid()
{
	$chars = md5(uniqid(mt_rand(), true));
	$uuid = substr($chars, 0, 8) . '-'
		. substr($chars, 8, 4) . '-'
		. substr($chars, 12, 4) . '-'
		. substr($chars, 16, 4) . '-'
		. substr($chars, 20, 12);
	return $uuid;
}
