<?php

function db_connect()
{
	$dbConn = mysqli_connect('localhost', 'farm', 'farm1234', 'farm') or ('error');
	//mysqli_connect('連線位置','帳號','密碼','資料庫名稱')
	mysqli_query( $dbConn, "SET NAMES 'utf8'");
	//設定連線過程傳輸編碼使用 utf8
	return $dbConn;
}

?>