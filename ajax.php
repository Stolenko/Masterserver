<?php

include 'master/config.php';
include 'master/functions.php';

$MasterServer = new MasterServer;
	
if(isset($_POST['host']) and isset($_POST['port']))
	echo $MasterServer->Settings();

if(isset($_POST['master']))
	if($_POST['master'] == 1)
		echo $MasterServer->Start();
	else if($_POST['master'] == 2)
		echo $MasterServer->Stop();
	else if($_POST['master'] == 3)
		echo $MasterServer->Restart();



?>