<?php
function smarty_function_productpage($paramer,$template){
	global $views,$phpyun,$config;
	$limit=(int)$limit;
	$limit=$limit?$limit:10;
	$order=$order?$order:"id desc";
	$where=$where?$where:1;
	$status=$params['status'];
	if($status!=2){
		$where.=!empty($status)?" and `status`='".$status."'":" and `status`='1'";
	}
	$where.=" and `uid`='".$_GET['id']."'";
	$pageurl=$views->curl(array("url"=>"id:".$_GET['id'].",tp:".$_GET['tp'].",page:{{page}}"));
	$rows = $views->get_page("company_product",$where." order by ".$order,$pageurl,$limit);
    $template->tpl_vars['productpage'] = new Smarty_Variable;
    $template->tpl_vars['productpage']->value=$rows; 
	return;
}
?>