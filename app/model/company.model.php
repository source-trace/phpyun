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
class company_model extends model{
	
  function GetMsgNum($Where=array()){
      $WhereStr=$this->FormatWhere($Where);
      return $this->DB_select_num('company_msg',$WhereStr);
  }
  
	function GetCompanyInfo($Where=array(),$Options=array('field'=>null,'orderby'=>null,'groupby'=>null,'limit'=>null)){
        $WhereStr=$this->FormatWhere($Where);
		$FormatOptions=$this->FormatOptions($Options);
		return $this->DB_select_once('company',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
  }
  
	function UpdateCompany($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
		$ValuesStr=$this->FormatValues($Values);
		return $this->DB_update_all("company",$ValuesStr,$WhereStr);
  }
	function GetMsgListAvg($uid){
		$avg = $this->DB_select_once('company_msg',"`cuid`='".(int)$uid."' AND `status`='1'","count(*) as num,AVG(score) as score,AVG(desscore) as desscore,AVG(comscore) as comscore,AVG(hrscore) as hrscore");
		return array('num'=>$avg['num'],'score'=>round($avg['score'],1),'desscore'=>round($avg['desscore'],1),'hrscore'=>round($avg['hrscore'],1),'comscore'=>round($avg['comscore'],1));
  }
  function GetMsgList($Where=array(),$Options=array('field'=>null,'orderby'=>null,'groupby'=>null,'limit'=>null)){
      $WhereStr=$this->FormatWhere($Where);
      $FormatOptions=$this->FormatOptions($Options);
      return $this->DB_select_all('company_msg',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
  }
  function GetBannerOnes($Where=array(),$Options=array('field'=>null)){
      $WhereStr=$this->FormatWhere($Where);
      $FormatOptions=$this->FormatOptions($Options);
      return $this->DB_select_once('banner',$WhereStr,$FormatOptions['field']);
  }
  function GetBannerOne($Where=array(),$Options=array('field'=>null)){
      $WhereStr=$this->FormatWhere($Where);
      $FormatOptions=$this->FormatOptions($Options);
      return $this->DB_select_once('blacklist',$WhereStr,$FormatOptions['field']);
  }
	function GetProductAll($Where=array(),$Options=array('field'=>null)){
      $WhereStr=$this->FormatWhere($Where);
      $FormatOptions=$this->FormatOptions($Options);
      return $this->DB_select_all('company_product',$WhereStr,$FormatOptions['field']);
  }
  function GetComStatisAll($Where=array(),$Options=array('field'=>null)){
      $WhereStr=$this->FormatWhere($Where);
      $FormatOptions=$this->FormatOptions($Options);
      return $this->DB_select_all('company_statis',$WhereStr,$FormatOptions['field']);
  }
  function GetProductNum($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_select_num('company_product',$WhereStr);
	}
	function UpdateProduct($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
		$ValuesStr=$this->FormatValues($Values);
		return $this->DB_update_all("company_product",$ValuesStr,$WhereStr);
  }
	function UpdateComNews($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
		$ValuesStr=$this->FormatValues($Values);
		return $this->DB_update_all("company_news",$ValuesStr,$WhereStr);
  }
	function UpdateOnceJob($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
		$ValuesStr=$this->FormatValues($Values);
		return $this->DB_update_all("once_job",$ValuesStr,$WhereStr);
  }
	function GetOnceJob($Where=array(),$Options=array('field'=>null)){
      $WhereStr=$this->FormatWhere($Where);
      $FormatOptions=$this->FormatOptions($Options);
      return $this->DB_select_once('once_job',$WhereStr,$FormatOptions['field']);
  }
  function GetProductOne($Where=array(),$Options=array('field'=>null)){
      $WhereStr=$this->FormatWhere($Where);
      $FormatOptions=$this->FormatOptions($Options);
      return $this->DB_select_once('company_product',$WhereStr,$FormatOptions['field']);
  }
	function DeleteProduct($Where=array()){
		$WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('company_product',$WhereStr,"");
    }
	function DeleteComNews($Where=array()){
		$WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('company_news',$WhereStr,"");
    }
	function DeleteMsg($Where=array()){
		$WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('msg',$WhereStr,"");
	}
	function DeleteOnceJob($Where=array()){
		$WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('once_job',$WhereStr,"");
    }
	function DeleteUserMsg($Where=array()){
		$WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('userid_msg',$WhereStr,"");
    }
	function DeleteComMsg($Where=array()){
		$WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('company_msg',$WhereStr,"");
    }
	function DeleteUserJob($Where=array()){
		$WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('userid_job',$WhereStr,"");
    }
  function GetNewsOne($Where=array(),$Options=array('field'=>null)){
      $WhereStr=$this->FormatWhere($Where);
      $FormatOptions=$this->FormatOptions($Options);
      return $this->DB_select_once('company_news',$WhereStr,$FormatOptions['field']);
  }
	function GetCompanyOrder($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('company_order',$WhereStr,$FormatOptions['field']);
    }
	function UpdateCompanyOrder($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
		$ValuesStr=$this->FormatValues($Values);
		return $this->DB_update_all("company_order",$ValuesStr,$WhereStr);
    }
	function GetCompanyOrderAll($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('company_order',$WhereStr,$FormatOptions['field']);
    }
	function DeleteRecord($Where=array()){
		$WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('invoice_record',$WhereStr,"");
    }
	function DeleteCompanyOrder($Where=array()){
		$WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('company_order',$WhereStr,"");
    }
	
	function UpdateInvoiceRecord($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
		$ValuesStr=$this->FormatValues($Values);
		return $this->DB_update_all("invoice_record",$ValuesStr,$WhereStr);
    }
	function UpdateNames($Values=array(),$Where=array()){
		$this->update_once("partjob",array("com_name"=>$Values['name']),array("uid"=>$Where['uid']));
		$this->update_once("userid_job",array("com_name"=>$Values['name']),array("com_id"=>$Where['uid']));
		$this->update_once("fav_job",array("com_name"=>$Values['name']),array("com_id"=>$Where['uid']));
		$this->update_once("report",array("r_name"=>$Values['name']),array("c_uid"=>$Where['uid']));
		$this->update_once("blacklist",array("com_name"=>$Values['name']),array("c_uid"=>$Where['uid']));
		$this->update_once("msg",array("com_name"=>$Values['name']),array("job_uid"=>$Where['uid']));  
    }
	function GetInvoiceRecord($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('invoice_record',$WhereStr,$FormatOptions['field']);
    }
  function GetComList($Where=array(),$Options=array()){
		$WhereStr=$this->FormatWhere($Where);
    $FormatOptions=$this->FormatOptions($Options);
    return $this->DB_select_all('company',$WhereStr.$FormatOptions['order'],$FormatOptions['field'],$FormatOptions['special']);
	}
  function GetComNum($Where=array(),$Options=array()){
		$WhereStr=$this->FormatWhere($Where);
    return $this->DB_select_num('company',$WhereStr);
	}
	function GetNewsAll($Where=array(),$Options=array('field'=>null)){
      $WhereStr=$this->FormatWhere($Where);
      $FormatOptions=$this->FormatOptions($Options);
      return $this->DB_select_all('company_news',$WhereStr,$FormatOptions['field']);
  }
	function DeleteComCert($Where=array()){
		$WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('company_cert',$WhereStr,"");
    }
	function GetCertAll($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('company_cert',$WhereStr,$FormatOptions['field']);
    }
	function GetCertOne($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('company_cert',$WhereStr,$FormatOptions['field']);
    }
    function AddCompanyShow($Values=array()){
        return $this->insert_into('company_show',$Values);
    }
	function GetShowAll($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('company_show',$WhereStr,$FormatOptions['field']);
    }
	function GetShowOne($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('company_show',$WhereStr,$FormatOptions['field']);
    }
    function UpdateShow($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all("company_show",$ValuesStr,$WhereStr);
    }
	function GetHotJobAll($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('hotjob',$WhereStr,$FormatOptions['field']);
    }
	function GetHotJobOne($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('hotjob',$WhereStr,$FormatOptions['field']);
    }
	function GetBannerAll($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('banner',$WhereStr,$FormatOptions['field']);
    }
  function AddMsg($Values=array()){
      return $this->insert_into('msg',$Values);
  }
	function AddTion($Values=array()){
      return $this->insert_into('advice_question',$Values);
  }
	
  private function _isComVipDayActionNeedCheck()
  {    
    $row = $this->DB_select_once('company_statis', 'rating_type = 2 and uid = ' . $this->uid, 'uid, `rating`');
    if(isset($row['uid']) && $row['uid'] > 0){
      return $row['rating'];
    }

    return false;
  }

  public function comVipDayActionCheck($type)
  {
    $ratingId = $this->_isComVipDayActionNeedCheck();

    if(!$ratingId){
     return true;
    }

    $typeMapping = array(
     'addjob' => 'job_num',
     'resume' => 'resume',
     'interview' => 'interview',
     'refreshjob' => 'breakjob_num',
     'addpart' => 'part_num',
     'refreshpart' => 'breakpart_num',
     'addltjob' => 'lt_job_num',
     'ltresume' => 'lt_resume',
     'refreshltjob' => 'lt_breakjob_num',
     'zph' => 'zph_num'
    );

    if(!isset($typeMapping[$type])){
     return array('status' => -1, 'msg' => '函数参数错误');
    }

    $field = $typeMapping[$type];

    $row = $this->DB_select_once('company_rating', '`id` = ' . $ratingId, "`{$field}`,`name`");
    if(!isset($row[$field]) || $row[$field] == 0){
      return true;
    }

    $dayMaxNum = $row[$field];
    $currentNum = 0;
    $today = strtotime(date('Y-m-d'));
    switch($type){
      case 'addjob':
       $currentNum = $this->DB_select_num('company_job', 
         'uid = ' . $this->uid . ' and sdate >=' . $today);
       break;
      case 'resume':
        $currentNum = $this->DB_select_num('down_resume', 
         'comid = ' . $this->uid . ' and downtime >=' . $today);
        break;
      case 'interview':
        $currentNum = $this->DB_select_num('userid_msg', 
         'fid = ' . $this->uid . ' and `datetime` >=' . $today);
        break;
      case 'refreshjob':
        $currentNum = $this->DB_select_num('member_log', 
         'uid = ' . $this->uid . ' and `ctime` >=' . $today
         . ' and `opera` = 1 and `type` = 4'
        );
        break;
      case 'addpart':
        $currentNum = $this->DB_select_num('partjob', 
         'uid = ' . $this->uid . ' and `addtime` >=' . $today);
        break;
      case 'refreshpart':
        $currentNum = $this->DB_select_num('member_log', 
         'uid = ' . $this->uid . ' and `ctime` >=' . $today
         . ' and `opera` = 9 and `type` = 4'
        );
        break;
      case 'addltjob':
        $currentNum = $this->DB_select_num('lt_job', 
         'uid = ' . $this->uid . ' and `lastupdate` >=' . $today);
        break;
      case 'ltresume':
        break;
      case 'refreshltjob':
		$currentNum = $this->DB_select_num('member_log', 
         'uid = ' . $this->uid . ' and `ctime` >=' . $today
         . ' and `opera` = 10 and `type` = 4'
        );
         break;
      case 'zph':
        break;
    }

    $typeMsgMapping = array(
     'addjob' => '发布职位',
     'resume' => '下载简历（查看联系方式）',
     'interview' => '邀请面试',
     'refreshjob' => '刷新职位',
     'addpart' => '发布兼职',
     'refreshpart' => '刷新兼职',
	'refreshltjob' => '刷新高级职位',
     'zph' => '报名招聘会'
    );
    $msg = "{$row['name']}每天最多{$typeMsgMapping[$type]} {$dayMaxNum} 次";

    return $currentNum < $dayMaxNum ? true : array('status' => -1, 'msg' => $msg);
  }
}
?>