<?php

require_once "../../config.php";

//DBへ接続
function connectDB()
{
	$dbh = new PDO("mysql:host=" .DB_HOST . ";dbname=" .DB_NAME., $user, $pass);
	mysql_connect(DB_HOST , DB_USER , DB_PASSWORD) or die("cant connect DB!".mysql_error());	

	mysql_select_db(DB_NAME) or die("cant select db".mysql_error());	
}


//エスケープ関数
function h($s)
{
	return htmlspecialchars($s);
}

//DB用エスケープ
function r($s)
{
	return mysql_real_escape_string($s);
}
