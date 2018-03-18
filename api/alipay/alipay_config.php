<?php
/*
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2018 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */



include_once (dirname(dirname(dirname(__FILE__)))."/data/api/alipay/alipay_data.php");




$partner         = $alipaydata[sy_alipayid];		
$security_code   = $alipaydata[sy_alipaycode];	
$seller_email    = $alipaydata[sy_alipayemail];				

$_input_charset  = "utf-8";						       
$transport       = "http";						       

$notify_url      = $alipaydata[sy_weburl]."/api/alipay/notify_url.php";    
$return_url      = $alipaydata[sy_weburl]."/api/alipay/return_url.php";    
$show_url        = $alipaydata[sy_weburl];			   

$sign_type       = "MD5";						       
$antiphishing    = "0";                                

$mainname		= $alipaydata[sy_alipayname];						

?>