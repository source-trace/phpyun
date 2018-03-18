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
class lietou_model extends model{
    function GetLietoujobNum($Where=array()){
        $WhereStr=$this->FormatWhere($Where); 
        return $this->DB_select_num('lt_job',$WhereStr);
    }
    function GetReceiveResumeNum($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_select_num('userid_job',$WhereStr);
    }
	function GetLtinfo($Where=array(),$Options=array('field'=>null,'orderby'=>null,'groupby'=>null,'limit'=>null)){
        $WhereStr=$this->FormatWhere($Where);
		$FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('lt_info',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
    }
	function GetLtinfoList($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('lt_info',$WhereStr,$FormatOptions['field']);
    }
    function AddLtInfo($Values=array()){
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_insert_once('lt_info',$ValuesStr);
    }
    function UpdateLtInfo($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('lt_info',$ValuesStr,$WhereStr);
    }
    function GetLietoujobOne($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('lt_job',$WhereStr,$FormatOptions['field']);
    }
    function GetLietoujobList($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options); 
        return $this->DB_select_all('lt_job',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
    }
    function UpdateLietoujob($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('lt_job',$ValuesStr,$WhereStr);
    }
	function AddLietoujobHits($id){
		return $this->DB_update_all('lt_job',"`hits`=`hits`+1","`id`='".$id."'");
	}
    function InsertRebates($Values=array()){
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_insert_once('rebates',$ValuesStr);
    }
}
?>