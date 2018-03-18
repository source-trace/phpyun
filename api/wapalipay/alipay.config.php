<?php

require_once(dirname(dirname(dirname(__FILE__)))."/data/plus/config.php");

if($config['alipaytype']=="1")
{
		$dir = "alipay";
}else{
		$dir = "alipaydual";
}

require_once(dirname(dirname(dirname(__FILE__)))."/data/api/".$dir."/alipay_data.php");

$alipay_config['partner']		= $alipaydata['sy_alipayid'];

$alipay_config['key']			= $alipaydata['sy_alipaycode'];

$alipay_config['private_key_path']	= 'key/rsa_private_key.pem';
unset($alipay_config['private_key_path']);

$alipay_config['ali_public_key_path']= 'key/alipay_public_key.pem';
unset($alipay_config['ali_public_key_path']);



$alipay_config['sign_type']    = 'MD5';

$alipay_config['input_charset']= 'utf-8';

$alipay_config['cacert']    = $config['sy_weburl']."/api/wapalipay/cacert.pem";

$alipay_config['transport']    = 'http';

?>