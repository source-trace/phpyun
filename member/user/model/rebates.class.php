<?php
/* *
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2018 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
*/
class rebates_controller extends user{
	function index_action(){
		$this->public_action();
		$urlarr=array("c"=>"rebates","page"=>"{{page}}");
		$pageurl=Url('member',$urlarr);
		$rows=$this->get_page("rebates","`uid`='".$this->uid."' order by id desc",$pageurl,"10");
		if(is_array($rows)){
			foreach($rows as $k=>$v){
				$uids[]=$v['job_id'];
			}
			$job=$this->obj->DB_select_all("lt_job","`id` in(".pylode(',',$uids).")","`id`,`job_name`,`com_name`,`rebates`,`usertype`"); 
			foreach($rows as $k=>$v){
				foreach($job as $val){
					if($v['job_id']==$val['id']){
						$rows[$k]['job_name']=$val['job_name'];
						$rows[$k]['com_name']=$val['com_name'];
						$rows[$k]['rebates']=$val['rebates'];
						if($val['usertype']==2){
							$rows[$k]['type']=2;
						}else{
							$rows[$k]['type']=3;
						}									
					}
				}		
			}							
		}
		$this->yunset("rows",$rows); 
		$this->user_tpl('rebates');
	}
	function del_action(){
		if($_GET['id']){
			$del=(int)$_GET['id'];
			$this->obj->DB_delete_all("temporary_resume","`rid`='".$del."'","");
			$nid=$this->obj->DB_delete_all("rebates","`id`='".$del."' and `uid`='".$this->uid."'","");
			$this->obj->member_log("删除我推荐的人才");
			$nid?$this->layer_msg('删除成功！',9,0,"index.php?c=rebates"):$this->layer_msg('删除失败！',8,0,"index.php?c=rebates");
		}
	}
}
?>