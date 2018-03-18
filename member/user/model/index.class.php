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
class index_controller extends user{
	function index_action(){
		$this->public_action();
		$this->member_satic();
		$this->yunset($this->MODEL('cache')->GetCache(array('user','com')));
		include_once PLUS_PATH."/job.cache.php";
		$yqnum=$this->obj->DB_select_num("userid_msg","`uid`='".$this->uid."'");
		$msgnum=$this->obj->DB_select_num("userid_msg","`uid`='".$this->uid."'  and `is_browse`='1'");
		$msg_count=$this->obj->DB_select_num("message","`fa_uid`='".$this->uid."' and `username`='管理员'");
		$lookNum=$this->obj->DB_select_num("look_resume","`uid`='".$this->uid."' and `status`<>'1'");
		$downNum=$this->obj->DB_select_num("down_resume","`uid`='".$this->uid."'");

		$finder=$this->finder();
		$this->config['user_finder']<count($finder)?$findernum=0:$findernum=$this->config['user_finder']-count($finder);
		$this->yunset("yqnum",$yqnum);
		$this->yunset("finder", $finder);
		$this->yunset("findernum", $findernum); 
		$this->yunset("msgnum", $msgnum);
		$this->yunset("msg_count",$msg_count);
		$this->yunset("lookNum",$lookNum);
		$this->yunset("downNum",$downNum);
		$time=strtotime(date("Y-m-d 00:00:00"));
		$resume = $this->obj->DB_select_once("resume","`uid`='".$this->uid."'","`def_job`,`name`,`status`,`email`,`telphone`,`idcard`,`moblie_status`,`email_status`,`sex`,`idcard_status`,`description`");
		$rlist=$this->obj->DB_select_once("resume_expect","`uid`='".$this->uid."' and `defaults`=1","id,name,job_classid,cityid,hits,jobstatus,integrity,minsalary,maxsalary,doc,tmpid,r_status,topdate,lastupdate,status");
		if(!$rlist){
			
			$rlist=$this->obj->DB_select_once("resume_expect","`uid`='".$this->uid."' order by `id` desc","id,name,job_classid,cityid,hits,jobstatus,integrity,minsalary,maxsalary,doc,tmpid,r_status,topdate,lastupdate,status");
			$_GET['jobwhere']="1=2";

		}else{

 			$jobwhere="(`job_post` in (".$rlist['job_classid'].") or `job1_son` in (".$rlist['job_classid'].")) and `cityid` = ".$rlist['cityid']." ";
			$_GET['jobwhere']=$jobwhere;

		}

		 
		$atnM=$this->MODEL('ask');
		$auids=$atnM->GetAtnList(array('uid'=>$this->uid),array('field'=>'uid,sc_uid'));
		if($auids&is_array($auids)){
		    foreach($auids as $v){
		        $jobs=$this->MODEL('job')->GetComjobOne(array('uid'=>$v['sc_uid'],'state'=>1,'`edate`>\''.time().'\' order by lastupdate desc'),array('field'=>'uid,id,com_name,name'));
		        if($jobs){
		            $ainfo[]=$jobs;
		        }
		    }
		}
		
		if($this->config['resume_sx']==1){
			if($resume['def_job']){
				$this->obj->DB_update_all("resume_expect","`lastupdate`='".time()."'","`uid`='".$this->uid."' and `id`='".$resume['def_job']."'");
				$this->obj->DB_update_all("resume","`lastupdate`='".time()."'","`uid`='".$this->uid."'");							
			}
		}
		
		$this->cookie->SetCookie("jobrefresh",'1',time() + 86400);
		$hours=date('H');
        if($hours<12){
			$wenhou='上午好~';
		}elseif($hours<24){
			$wenhou='下午好~';
		}
		$this->yunset('wenhou',$wenhou);
		$this->yunset('ainfo',$ainfo);
		$this->yunset("rlist",$rlist);
		$this->yunset("resume",$resume);
		$this->yunset("time",$time);
		$this->user_tpl('index');
	}
	function resumeajax_action(){
		if($_GET['rand']){
			if($_GET['id']){
				$data=$this->obj->DB_select_once("resume_expect","`uid`='".$this->uid."' and `id`='".intval($_GET['id'])."'","id,name,job_classid,cityid,hits,jobstatus,integrity,minsalary,maxsalary,doc,tmpid,r_status,topdate,lastupdate,status");
			}else{
				$data=$this->obj->DB_select_once("resume_expect","`uid`='".$this->uid."' and `defaults`=1","id,name,job_classid,cityid,hits,jobstatus,integrity,minsalary,maxsalary,doc,tmpid,r_status,topdate,lastupdate,status");
				if(!$data){
					$data=$this->obj->DB_select_once("resume_expect","`uid`='".$this->uid."' order by `id` desc","id,name,job_classid,cityid,hits,jobstatus,integrity,minsalary,maxsalary,doc,tmpid,r_status,topdate,lastupdate,status");
				}
			}
			$data['name']=mb_substr($data['name'],0,10,'utf8');
			include_once PLUS_PATH."/job.cache.php";
			if($data['job_classid']){
				$jobname = array();
				$jobclassid = explode(',',$data['job_classid']);
				foreach($jobclassid as $val){
					if($job_name[$val]){
						$jobname[]=$job_name[$val];
					}
				}
				$jobname = $jobname[0];
				$data['jobname']=$jobname;
			}
			if($data['minsalary'] && $data['maxsalary']){
				$data['user_salary'] =$data['minsalary']."-".$data['maxsalary'];
			}elseif($data['minsalary']){
				$data['user_salary'] =$data['minsalary']."以上";
			}else{
				$data['user_salary'] ="面议";
			}
			$data['lastupdate']=date("Y-m-d H:i:s",$data['lastupdate']);
			$user_resume=$this->obj->DB_select_once("user_resume","`eid`='".$data['id']."'");
			$data['skill']=$user_resume['skill'];
			$data['work']=$user_resume['work'];
			$data['project']=$user_resume['project'];
			$data['edu']=$user_resume['edu'];
			$data['training']=$user_resume['training'];
			$data['cert']=$user_resume['cert'];
			$data['other']=$user_resume['other'];
			$resume = $this->obj->DB_select_once("resume","`uid`='".$this->uid."'","`description`");
			$data['description']=$resume['description'];
			if($data['topdate']>1){
				$data['topdate']=date("Y-m-d",$data['topdate']);
				$data['topdatetime']=$data['topdate']-time();
			}else{
				$data['topdate']='未设置';
			}
			$data['url']=Url('resume',array('c'=>'show','id'=>$data['id']));
			$rlist=$this->obj->DB_select_all("resume_expect","`uid`='".$this->uid."'  order by `defaults` desc","id,name,job_classid,cityid,hits,jobstatus,integrity,minsalary,maxsalary,doc,tmpid,r_status,topdate,lastupdate");
			$resumelist="";
			foreach($rlist as $v){
				$resumelist.="<li><a href=\"javascript:showresumelist('".$v[id]."');\">".$v['name']."</a></li>";
			}
			$html='<span>'.$data[name].'</span><div class="index_resume_my_n_list" id="resume_expect'.$data[id].'" style="display:none;"><ul>'.$resumelist.'</ul></div>';
			$data['resumelist']=$html;
			$data['num']=count($rlist);
			$data['uid']=$this->uid;
			echo json_encode($data);
		}
		
	}
}
?>