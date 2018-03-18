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
class index_controller extends company{
	function index_action(){
		include(CONFIG_PATH."db.data.php");
		$this->yunset("arr_data",$arr_data);
		$this->public_action();
		$statis=$this->company_satic();
		$time=strtotime(date("Y-m-d 00:00:00"));
		$this->yunset("time",$time);

		$des_resume=$this->obj->DB_select_num("userid_job","`com_id`='".$this->uid."'");
		$this->yunset("des_resume",$des_resume);

		$de_resume=$this->obj->DB_select_num("userid_job","`com_id`='".$this->uid."' and `is_browse`='1'");
        $this->yunset("de_resume",$de_resume);
	
		$down_resume=$this->obj->DB_select_num("down_resume","`comid`='".$this->uid."'");
		$this->yunset("down_resume",$down_resume);
 
		$company=$this->obj->DB_select_once("company","`uid`='".$this->uid."'");
		if($company['logo']){
		    $company['logo']=str_replace("./",$this->config['sy_weburl']."/",$company['logo']);
		}else{
		    $company['logo']=$this->config['sy_weburl'].'/'.$this->config['sy_unit_icon'];
		}
		$this->yunset("company",$company);

		$normal_job_num=$this->obj->DB_select_num("company_job","`uid`='".$this->uid."' and `state`='1' and `edate`>'".time()."'");
		$this->yunset("normal_job_num",$normal_job_num);
			
		$un_refreshjob_num=$this->obj->DB_select_num("company_job","`uid`='".$this->uid."' and `lastupdate` < '".$time."' and `state`='1' and `edate`>'".time()."'");
		$this->yunset("un_refreshjob_num",$un_refreshjob_num);


		$jobs=$this->obj->DB_select_all("company_job","`edate`>'".time()."' and `state`=1 and `r_status`<>2 and `status`<>1 and `uid`='".$this->uid."'");
		
		if($jobs && is_array($jobs)){
			foreach($jobs as $v){
				$ids[]=$v['id'];
				$jobnames[]=$v['name'];
			}
			$jobids ="".@implode(",",$ids)."";
			$jobnames ="".@implode(",",$jobnames)."";
			$this->yunset("jobids",$jobids);
			$this->yunset("jobnames",$jobnames);
		}
		$this->yunset("jobs",$jobs);
 		
		$member=$this->obj->DB_select_once("member","`uid`='".$this->uid."'","`login_date`,`status`");
		$this->yunset("member",$member);

		$jobwhere="`edate`>'".time()."' and `state`=1 and `r_status`<>2 and `status`<>1 and `uid`='".$this->uid."'";
		$joblist=$this->obj->DB_select_all("company_job",$jobwhere,"`job1_son`,`job_post`,`cityid`");
		$blacklist=$this->obj->DB_select_all("blacklist","`p_uid`='".$this->uid."'","`c_uid`");
		if(is_array($joblist) && !empty($joblist)){
			foreach($joblist as $v){
				$where[]="`cityid`='".$v['cityid']."' AND (FIND_IN_SET('".$v['job1_son']."',job_classid) or FIND_IN_SET('".$v['job_post']."',job_classid))";
			}
			$whereSql = " and (".@implode(" or ",$where).")";
		}
		if(is_array($blacklist) && !empty($blacklist)){
			foreach($blacklist as $v){
				$bids[]=$v['c_uid'];
			}
			
			$blistSql = " and `uid` not in(".@implode(",",$bids).") ";
		}
		if(is_array($where)){
			$_GET['userwhere']="`uname`<>'' and status<>'2' and `r_status`='1' and `job_classid`<>'' and `open`='1' and `defaults`=1".$whereSql.$blistSql;
		}else{
			$_GET['userwhere']="`uname`<>'' and status<>'2' and `r_status`='1' and `job_classid`<>'' and `open`='1' and `defaults`=1".$whereSql.$blistSql;
		}
		
		if($statis['rating']>0){
			$company_rating=$this->obj->DB_select_once("company_rating","`id`='".$statis['rating']."'");
			$this->yunset("company_rating",$company_rating);
		}
		
		$statis['kyjf']=number_format($statis['integral']);
		
		$this->yunset("statis",$statis);
		
		$look_resume=$this->obj->DB_select_num("look_resume","`com_id`='".$this->uid."' and `com_status`='0'");
		$this->yunset("look_resume",$look_resume);
		$_GET['cityid']=$company['cityid'];
		$_GET['hy']=$company['hy'];

		$atn=$this->obj->DB_select_all("atn","`sc_uid`='".$this->uid."' and `usertype`='1' order by `id` desc");

		$payed=$this->obj->DB_select_num("company_order","`uid`='".$this->uid."' and `order_state`='2'");
		$this->yunset("payed",$payed);
		
		$paying=$this->obj->DB_select_num("company_order","`uid`='".$this->uid."' and `order_state`='1'");
		$this->yunset("paying",$paying);
		
		$this->cookie->SetCookie("jobrefresh",'1',time() + 86400);
		
		$this->yunset("js_def",1);
		$this->com_tpl('index');
	}
}
?>