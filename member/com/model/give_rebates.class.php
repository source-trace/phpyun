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
class give_rebates_controller extends company
{
	function index_action()	{
		$this->public_action();
		$this->company_satic();
		$this->yunset("js_def",5);
		$urlarr=array("c"=>$_GET['c'],"page"=>"{{page}}");
		$pageurl=Url('member',$urlarr);
		$rows=$this->get_page("rebates","`job_uid`='".$this->uid."' order by id desc",$pageurl,"10");
		if(is_array($rows)){
			foreach($rows as $k=>$v){
				$uid[]=$v['uid'];
				$id[]=$v['id'];
			}
			$uid=pylode(",",$uid);
			$temporary=$this->obj->DB_select_all("temporary_resume","`rid` in (".pylode(",",$id).")","`rid`,`email`");
			$user=$this->obj->DB_select_all("member","`uid` in (".$uid.")","`uid`,`username`");
			foreach($rows as $k=>$v){
				foreach($user as $val){
					if($v['uid']==$val['uid']){
						$rows[$k]['username']=$val['username'];
					}
				}
				foreach($temporary as $val){
					if($v['id']==$val['rid']){
						$rows[$k]['email']=$val['email'];
					}
				}
			}
		}
		$this->yunset("rows",$rows);
		$this->com_tpl('give_rebates');
	}
	function save_action(){
		if($_POST['submit']){
			$data['reply']=$_POST['reply'];
			$data['reply_time']=time();
			$data['status']="1";
			$where['id']=(int)$_POST['id'];
			$where['job_uid']=$this->uid;
			$this->obj->update_once("rebates",$data,$where);
			$this->obj->member_log("回复推荐给我的返利");
 			$this->ACT_layer_msg("回复成功！",9,"index.php?c=give_rebates");
		}
	}
	function set_action(){
		if($_POST['status']){
			$where['id']=(int)$_POST['id'];
			$where['job_uid']=$this->uid;
			$nid=$this->obj->update_once("rebates",array("status"=>intval($_POST['status'])),$where);
			$nid?$this->layer_msg('设置成功！',9,0,"index.php?c=give_rebates"):$this->layer_msg('设置失败！',8,0,"index.php?c=give_rebates");
		}
	}
	function del_action(){
		if($_GET['id']){
			$del=(int)$_GET['id'];
			$this->obj->DB_delete_all("temporary_resume","`rid`='".$del."'","");
			$nid=$this->obj->DB_delete_all("rebates","`id`='".$del."' and `job_uid`='".$this->uid."'","");
			$this->obj->member_log("删除推荐给我的人才");
			$nid?$this->layer_msg('删除成功！',9,0,"index.php?c=give_rebates"):$this->layer_msg('删除失败！',8,0,"index.php?c=give_rebates");
		}
	}
}
?>