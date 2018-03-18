<?php

error_reporting(0);

include("data/plus/config.php");
include("app/include/public.function.php");
//判断手机还是PC访问

if(isMobileUser($config)){

	$protocol = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';

	if(!($config['sy_wapdomain'])){

		$config['sy_wapdomain'] = $config['sy_weburl'].'/'.$config['sy_wapdir'];

	}else{
		if(strpos($config['sy_wapdomain'],$this->protocol)===false)
		{
			$config['sy_wapdomain'] = $protocol.$config['sy_wapdomain'];
		}
	}
	header('Location: '.$config['sy_wapdomain'].'/index.php?c=qqconnect&a=qqlogin&code='.$_GET['code']."&state=".$_GET['state']);
}else{
	header('Location: '.$config['sy_weburl'].'/index.php?m=qqconnect&code='.$_GET['code']."&state=".$_GET['state']);
}


?>