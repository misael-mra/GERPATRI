<?php
require_once('includes/load.php');

if(!$session->logout()) {
	$session->msg('i','Logout com sucesso!');
	redirect("index.php");
}

