<?php

error_reporting(0);
require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");
require_once(dirname(dirname(dirname(__FILE__)))."/global.php");

$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();

if($verify_result) {
	$doc = new DOMDocument();
	if ($alipay_config['sign_type'] == 'MD5') {
		$doc->loadXML($_POST['notify_data']);
	}

	if ($alipay_config['sign_type'] == '0001') {
		$doc->loadXML($alipayNotify->decrypt($_POST['notify_data']));
	}

	if( ! empty($doc->getElementsByTagName( "notify" )->item(0)->nodeValue) ) {
		$out_trade_no = $doc->getElementsByTagName( "out_trade_no" )->item(0)->nodeValue;
		$trade_no = $doc->getElementsByTagName( "trade_no" )->item(0)->nodeValue;
		$trade_status = $doc->getElementsByTagName( "trade_status" )->item(0)->nodeValue;
		$total_fee = $doc->getElementsByTagName( "total_fee" )->item(0)->nodeValue;

		if(!preg_match('/^[0-9]+$/', $out_trade_no)){
			die;
		}
		if(($trade_status == 'TRADE_FINISHED') ||($trade_status == 'TRADE_SUCCESS') || ($result == 'success') ) {    

			require_once(APP_PATH.'app/public/common.php');
			require_once(LIB_PATH.'ApiPay.class.php');

			$apiPay = new apipay($phpyun,$db,$db_config['def'],'index');
			
			$apiPay->payAll($out_trade_no,$total_fee,'wapalipay');

		}else{
			echo "success";		
		}
	}


}
else {
    echo "fail";
}
?>