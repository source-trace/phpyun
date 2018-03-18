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

global $db_config,$db;

$query = $db->query("SELECT uid FROM $db_config[def]company_statis  WHERE `rating`<>3 AND `rating`<>0");
if($query!=""){
	while($rs = $db->fetch_array($query))
	{	
		$data['day']=date("d",$rs['vip_etime']-time());
		$data['date']=date("d",$rs['vip_etime']);
		$data['ratingname']=$rs['rating_name'];
		$ereg=$db->query("SELECT * FROM $db_config[def]member WHERE `uid`='".$rs['uid']."' AND `usertype`=2 AND `status`=1 ");
		while($er = $db->fetch_array($ereg)){
			$data['email']=$er['email'];	
			$data['moblie']=$er['moblie'];
			$data['username']=$er['username'];
			$data['uid']=$er['uid'];
			$noticeM = $this->MODEL('notice');
			
			if($rs['vip_etime']>time()){
				if($data['day']<=7){
					if($this->config['sy_email_viped']=='1'){
						$notice->sendEmailType(array("email"=>$data['email'],"uid"=>$data['uid'],"name"=>$data['username'],"retingname"=>$data['ratingname'],'date'=>$data['date'],'day'=>$data['day'],"type"=>"vipmr"));
					}
					if($this->config['sy_msg_viped']=='1'){
						$notice->sendSMSType(array("moblie"=>$data['moblie'],"uid"=>$data['uid'],"name"=>$data['username'],"retingname"=>$data['ratingname'],'date'=>$data['date'],"type"=>"vipmr"));
					}
				}
			}
		}	
	}
}else{
	$this->ACT_layer_msg( "暂时没有会员到期信息！",8,$_SERVER['HTTP_REFERER']);
}	

	
?>