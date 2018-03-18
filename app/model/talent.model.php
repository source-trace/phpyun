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
class talent_model extends model{
		
	function getTalent($uid,$id,$infotype='0'){
	
		$Info = $this->DB_select_once("lt_talent","`uid`='".(int)$uid."' AND `id`='".(int)$id."'");
		if(!empty($Info) && $infotype=='1'){

			include PLUS_PATH."/city.cache.php";
			include PLUS_PATH."/job.cache.php";
			include PLUS_PATH."/user.cache.php";
			include PLUS_PATH."/industry.cache.php";

			if($Info['sex']=='1'){
				$Info['sex'] = '男';
			}elseif($Info['sex']=='2'){
				$Info['sex'] = '女';
			}
			$Info['hy'] = $industry_name[$Info['hy']];

			$Info['useredu'] = $userclass_name[$Info['edu']];

			$Info['user_exp'] = $userclass_name[$Info['exp']];

			$Info['city_one'] = $city_name[$Info['provinceid']];

			$Info['city_two'] = $city_name[$Info['cityid']];

			$Info['city_three'] = $city_name[$Info['three_cityid']];

			$Info['report'] = '随时到岗';

			$Info['type'] = '全职';

			$Info['jobstatus'] = $userclass_name[$Info['jobstatus']];
			
		}
		return $Info;
	}
	function telStatus($id,$tel,$code){
		
		if($id && $tel){
			if(!CheckMoblie($tel)){
			
				$error['msg'] = '手机号格式错误';
			}else{
				$telNum = $this->DB_select_num('lt_talent',"`linktel`='".$tel."' AND `telstatus`='1'");
				
				if($telNum>0){
					$error['msg'] = '手机号已被授权！';
				}else{
					
					$row=$this->DB_select_once("company_cert","`uid`='".$this->uid."' and `check`='".$tel."' and `type`='2' ORDER BY id DESC");
					
					if(!empty($row)){
						if($row['check2']!=$code){
							$error['msg'] = '手机验证码不正确';
						}else{
							$this->DB_update_all("lt_talent","`linktel`=''","`linktel`='".$tel."'");
							$this->DB_update_all("lt_talent","`linktel`='".$tel."',`telstatus`='1'","`uid`='".$this->uid."' AND `id`='".(int)$id."'");
							$error['error'] = '1';
							$error['msg'] = '验证成功';
						}
						
					}else{
						$error['msg'] = '验证码错误';
					}
				}
			
			}
			
		}else{
		
			$error['msg'] = '数据错误';
		}
		
		return $error;
		
	}
	function addTalent($data){

		if($data['id']){
			$info = $this->DB_select_once('lt_talent',"`id`='".(int)$data['id']."' AND `uid`='".$this->uid."'");
		}
		
		$error['error'] = '0';

		if($data['id'] && empty($info)){
			$error['msg'] = '参数错误';
		}elseif(empty($data['name'])){
			
			$error['msg'] = '请填写姓名';
		}elseif(empty($data['sex'])){
			
			$error['msg'] = '请选择性别';
		}elseif(empty($data['age'])){
			
			$error['msg'] = '请填写年龄';
		}elseif(empty($data['edu'])){
			
			$error['msg'] = '请选择最高学历';
		}elseif(empty($data['exp'])){
			
			$error['msg'] = '请选择工作经验';
		}elseif(empty($data['minsalary'])){
			
			$error['msg'] = '请填写最低薪资需求';
		}elseif(!empty($data['maxsalary']) && $data['maxsalary']<=$data['minsalary']){
			
			$error['msg'] = '最高薪资必须大于最低薪资';
		}elseif(empty($data['living'])){
			
			$error['msg'] = '请填写现居住地';
		}elseif(empty($data['jobname'])){
			
			$error['msg'] = '请填写意向岗位';
		}elseif(empty($data['hy'])){
			
			$error['msg'] = '请选择所属行业';
		}elseif(empty($data['cityid'])){
			
			$error['msg'] = '请选择期望工作地区';
		}elseif(empty($data['jobstatus'])){
			
			$error['msg'] = '请选择当前求职状态';
		}elseif(empty($data['expinfo'])){
			
			$error['msg'] = '请填写相关工作经历';

		}elseif(empty($data['eduinfo'])){
			
			$error['msg'] = '请填写相关教育经历';
		}elseif(empty($data['jobstatus'])){
			
			$error['msg'] = '请选择当前求职状态';
		}else{
			if($info['telstatus']!='1'){
				if(empty($data['telphone'])){
				
					$error['msg'] = '请输入求职者手机号';
				
				}elseif(!CheckMoblie($data['telphone'])){
					$error['msg'] = '手机号格式错误';
				}else{
					if($data['id']){
						
						$where = " AND `id`<>'".(int)$data['id']."'";
					}
					$num = $this->DB_select_num('lt_talent',"`linktel`='".$data['telphone']."'".$where);
					if($num>0){
						$error['msg'] = '相同简历已存在，手机号已被使用';
					}
				}
			}
		}
		
		if(empty($error['msg'])){
			
				
			$fieldData['name'] = trim($data['name']);
			$fieldData['sex'] = intval($data['sex']);
			$fieldData['age'] = intval($data['age']);
			$fieldData['exp'] = intval($data['exp']);
			$fieldData['edu'] = intval($data['edu']);
			$fieldData['living'] = $data['living'];
			$fieldData['jobname'] = $data['jobname'];
			$fieldData['hy'] = intval($data['hy']);
			$fieldData['minsalary'] = intval($data['minsalary']);
			$fieldData['maxsalary'] = intval($data['maxsalary']);
			$fieldData['provinceid'] = intval($data['provinceid']);
			$fieldData['cityid'] = intval($data['cityid']);
			$fieldData['three_cityid'] = intval($data['three_cityid']);

			$fieldData['jobstatus'] = $data['jobstatus'];
			if($info['telstatus']!='1'){
				$fieldData['linktel'] = $data['telphone'];
			}
			
			$fieldData['expinfo'] = $data['expinfo'];
			$fieldData['eduinfo'] = $data['eduinfo'];
			$fieldData['projectinfo'] = $data['projectinfo'];
			$fieldData['skillinfo'] = $data['skillinfo'];
			
			if($data['id']){
				
				$nid = $this->update_once('lt_talent',$fieldData,"`id`='".(int)$data['id']."' AND `uid`='".$this->uid."'");
				$error['msg'] = $nid?'更新简历成功':'更新简历失败';
			}else{
				$fieldData['uid'] = $this->uid;
				$nid = $this->insert_into('lt_talent',$fieldData);
				$error['msg'] = $nid?'添加简历成功':'添加简历失败';
			}
			if($nid){
				$error['error']='1';
			}
		}

		return $error;
	}
	
	
	

}
?>