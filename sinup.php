<?php
	
require_once "../../config.php";
require_once "functions.php";


//ユーザ名の重複をチェックする
function checkExistingName($name)
{
	$q = sprintf("select * from users where name = '%s' limit 1" , r($name));
	$rs = mysql_query($q);
	return (mysql_rows($rs) ? true : false);
}

//パスワードを暗号化する
function getSha1Password($s)
{
	return (sha1(PASSWORD_KEY.$s));
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$name = $_POST['name'];
	$password  = $_POST['password'];
	$password2 = $_POST['password2'];

	//エラーチェック
	$err = array();

	if(empty($name))		$err['name']		 =	'ユーザ名を入力してください';
	if(checkExistingName($name))	$err['name'] 		 =	'このユーザ名はすでに使われています';
	if(empty($password))		$err['password'] 	 =	'パスワードを入力してください';
	if(empty($password2))		$err['password2']	 =	'パスワード（確認用）を入力してください';

	if(empty($err))
	{
		//DB接続
		$sha1password = getSha1Password($password);
		echo $sha1password;
		exit;

		//DBにデータを入れる
		$q = sprintf("insert into users (name , password , created_at , updated_at) values ( '%s' , '%s' , now() , now())" , r($name) ,$sha1password);

		$rs = mysql_query($q);
		//login.phpへ飛ばす
	}
}

else
{
	echo $_SERVER['REQUEST_METHODS'];
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>新規ユーザ登録</title>
	
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.css" />
</head>
<body>
	

<div class="container">

	
	<h1>新規ユーザ登録</h1>



	<form action="" class="form-horizontal" method = "post">
		<div class="control-group">
			<label for="name" class="control-label">ユーザID:</label>
            		<div class="controls">
				<input id="name" name="name" type="text"  placeholder = "ユーザ名を入力してください" />
				<span class="helo-inline"><?php echo $err['name']; ?></span>
			</div>
		</div>

		<div class="control-group">
			<label for="password" class="control-label">パスワード:</label>
            		<div class="controls">
				<input id="password" name="password" type="password" placeholder = "パスワードを入力してください" />
				<span class="helo-inline"><?php echo $err['password']; ?></span>
			</div>
		</div>
		
		<div class="control-group">
			<label for="password2" class="control-label">パスワード(確認用):</label>
            		<div class="controls">
				<input id="password2" name="password2" type="password" placeholder = "確認用パスワードを入力してください" />
				<span class="helo-inline"><?php echo $err['password2']; ?></span>
			</div>


		</div>
	
		<div class="control-group">
            		<div class="controls">
            			<input type="submit" value="送信" class="btn">
            		</div>
            </div>
	</form>
</div>

</body>
</html>
