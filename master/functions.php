<?php

class MasterServer{

	static function Settings()
	{
		include 'config.php';
		
		$host = $_POST['host'];
		$post = $_POST['port'];
		$sort = $_POST['sort'];
		
		$q = mysql_query("UPDATE `$settings_table` SET `host`='$host',`port`=$post,`sort`=$sort");
		if($q)
			echo '<div class="alert alert-success"><button id="close" type="button" class="close" OnClick="CloseMessage();">&times;</button><b>Настройки успешно обновлены!</b></div>';
		else
			echo '<div class="alert alert-error"><button id="close" type="button" class="close" OnClick="CloseMessage();">&times;</button><b>Произошла ошибка, обновите страницу и попробуйте снова.</b></div>';
	}
	
	static function RefreshList()
	{
		include 'config.php';
		$packet = "\xFF\xFF\xFF\xFF\x66\x0A";
		
		mysql_query("UPDATE `information` SET `refreshtime`=".time()." WHERE 1");

		$q = "SELECT * FROM `$dbtable`";
		$res = mysql_query($q);
		
		while($row=mysql_fetch_array($res)) {

		$tmp = explode(':', $row['ip']);
		$ip = explode('.', gethostbyname($tmp['0']));
						
			if(count($ip) == 4) {
				$packet .= pack("C*", "$ip[0]");
				$packet .= pack("C*", "$ip[1]");
				$packet .= pack("C*", "$ip[2]");
				$packet .= pack("C*", "$ip[3]");
				$packet .= pack("n*", "$tmp[1]");
			}
		}
		if($settings['sort'])
			$packet .= "\x00\x00\x00\x00\x00\x00";	
		
		return $packet;
	}
	
	static function Start()
	{
		include 'config.php';
		mysql_query("UPDATE `information` SET `starttime`=".time()." WHERE 1");
		$q = mysql_query("UPDATE `$settings_table` SET `status`=1");
		if($q)
		{
			exec("screen -A -m -d -S masterserver php master/ms.php");
			return '<div class="alert alert-success"><button id="close" type="button" class="close" OnClick="CloseMessage();">&times;</button><b>Мастер-сервер запущен.</b></div>';
		}
		else
			return '<div class="alert alert-error"><button id="close" type="button" class="close" OnClick="CloseMessage();">&times;</button><b>Произошла ошибка, обновите страницу и попробуйте снова.</b></div>';	
	}
	
	static function Stop()
	{
		include 'config.php';
		
		$q = mysql_query("UPDATE `$settings_table` SET `status`=0");
		if($q)
		{
			$fsock = fsockopen("udp://".$settings['host'],$settings['port'],$errnum,$errstr,2);
			fwrite($fsock, "\x31\xFF\x30\x2E\x30\x2E\x30\x2E\x30\x3A\x30\x00\x5C\x67\x61\x6D\x65\x64\x69\x72\x5C\x63\x73\x74\x72\x69\x6B\x65\x00");
			return '<div class="alert alert-success"><button id="close" type="button" class="close" OnClick="CloseMessage();">&times;</button><b>Мастер-сервер остановлен.</b></div>';
		}
		else
			return '<div class="alert alert-error"><button id="close" type="button" class="close" OnClick="CloseMessage();">&times;</button><b>Произошла ошибка, обновите страницу и попробуйте снова.</b></div>';
	}
	static function Restart()
	{
		MasterServer::Stop();
		MasterServer::Start();
		return '<div class="alert alert-success"><button id="close" type="button" class="close" OnClick="CloseMessage();">&times;</button><b>Мастер-сервер перезапущен.</b></div>';
	}
}


?>