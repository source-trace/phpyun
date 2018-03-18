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
class index_controller extends common{
	function index_action(){
		$this->seo("forgetpw");
		$this->yun_tpl(array('index'));
	}
	function half_replace($str,$encoding='utf-8'){
        
		   $len = strlen($str)/2;
		   return substr_replace($str,str_repeat('*',$len),ceil(($len)/2),$len);
        
	}
	function checkuser_action(){
		$username=$_POST['username'];
		if(CheckRegUser($username)==false && CheckRegEmail($username)==false){
			$res['msg']="用户名包含特殊字符！";
			$res['type']='8';
			echo json_encode($res);die;
		}
		$M=$this->MODEL("userinfo");
		$info=$M->GetMemberOne(array('username'=>$username),array("field"=>"`uid`,`username`,`email`,`moblie`"));
 		if(is_array($info)){
 			if($info['email']=="" && $info['moblie']==""){
				$res['msg']="您的账号没有邮箱和手机，请联系管理员！";
				$res['type']='8';
				echo json_encode($res);die;
 			}else{
				$res['msg']='';
				$res['type']='1';
				$res['uid']=$info['uid'];
				$res['username']=$this->half_replace($info['username']);
				$res['email']=$this->half_replace($info['email']);
				$res['moblie']=$this->half_replace($info['moblie']);
				echo json_encode($res);die;
 			}
		}else{
			$res['type']='2';
			echo json_encode($res);die;
		}
	}
    function send_action(){
		$username= $_POST['username'];
		if(CheckRegUser($username)==false &&CheckRegEmail($username)==false){
			$res['msg']="用户名不符合规范！";
			$res['type']='8';
			echo json_encode($res);die;
		}
		
		$M=$this->MODEL("userinfo");
		$info=$M->GetMemberOne(array('username'=>$username),array("field"=>"`uid`,`username`,`email`,`moblie`,`did`"));
        if($info['uid']){

            if ($_POST['sendtype']=='shensu'){
                $res['type']='1';
            }else{
                $sendcode = rand(100000,999999);
                if($_POST['sendtype']=='email'){
                    if($this->config['sy_email_set']!="1"){
                        $res['msg']="网站邮件服务器暂不可用！";
                        $res['type']='8';
                        echo json_encode($res);die;
                    }elseif($this->config['sy_email_getpass']=="2"){
                        $res['msg']="网站未开启邮件找回密码！";
                        $res['type']='8';
                        echo json_encode($res);die;
                    }
                }elseif ($_POST['sendtype']=='moblie'){
                    if(!$this->config["sy_msguser"] || !$this->config["sy_msgpw"] || !$this->config["sy_msgkey"]||$this->config['sy_msg_isopen']!='1'){
                        $res['msg']="还没有配置短信，请联系管理员！";
                        $res['type']='8';
                        echo json_encode($res);die;
                    }elseif($this->config['sy_msg_getpass']=="2"){
                        $res['msg']="网站未开启短信找回密码！";
                        $res['type']='8';
                        echo json_encode($res);die;
                    }
                }
                $fdata=$this->forsend(array('uid'=>$info['uid'],'usertype'=>$info['usertype']));
                $data['uid']=$info['uid'];
                $data['username']=$info['username'];
                $data['name']=$fdata['name'];
                $data['type']="getpass";
                $data['sendcode']=$sendcode;
                $data['date']=date("Y-m-d");
                
                $notice = $this->MODEL('notice');
                
                if($_POST['sendtype']=='email'){
                    $data['email']=$info['email'];
                    $notice->sendEmailType($data);
                }elseif ($_POST['sendtype']=='moblie'){
                    $data['moblie']=$info['moblie'];
                    $result = $notice->sendSMSType($data);
                }
                if($_POST['sendtype']=='email'){
                    $check=$info['email'];
                }else{
                    $check=$info['moblie'];
                }
                $cert=$M->GetCompanyCert(array("uid"=>$info['uid'],"type"=>"7","check"=>$check),array("field"=>"`uid`,`check2`,`ctime`,`id`"));
                if($cert){
                    $M->UpdateCompanyCert(array("check2"=>$sendcode,"ctime"=>time()),array("id"=>$cert['id']));
                }else{
                    $M->AddCompanyCert(array('type'=>'7','status'=>0,'uid'=>$info['uid'],'check2'=>$sendcode,'check'=>$check,'ctime'=>time(),'did'=>$info['did']));
                }
                if($_POST['sendtype']=='email'){
                    $res['msg']='验证码邮件发送成功！';
                }elseif($_POST['sendtype']=='moblie'){
                    $res['msg']='验证码短信'.$result['msg'];
                    if($result['status'] == -1){
                        $res['type']='9';
                        echo json_encode($res);die;
                    }
                }
                $res['type']='1';
                $res['uid']=$info['uid'];
                $res['username']=$this->half_replace($info['username']);
                $res['email']=$this->half_replace($info['email']);
                $res['moblie']=$this->half_replace($info['moblie']);
            }
			echo json_encode($res);die;
        }else{
            $res['type']='2';
			echo json_encode($res);die;
        }
	}
	function checksendcode_action(){
		$username=$_POST['username'];
		if(CheckRegUser($username)==false && CheckRegEmail($username)==false){
            $res['msg']="用户名包含特殊字符！";
            $res['type']='8';
            echo json_encode($res);die;
		}
		$M=$this->MODEL("userinfo");
		$info = $M->GetMemberOne(array('username'=>$username),array("field"=>"`uid`,`username`,`email`,`moblie`"));
		if($_POST['sendtype']=='email'){
			$check=$info['email'];
		}else{
			$check=$info['moblie'];
		}
		$cert = $M->GetCompanyCert(array("uid"=>$info['uid'],"type"=>"7","check"=>$check),array("field"=>"`uid`,`check2`,`ctime`,`id`"));
        if(($_POST['code']!=$cert['check2'])||(!$cert)){
			$res['msg']="验证码错误";
			$res['type']='8';
			echo json_encode($res);die;
		}
		if(is_array($info)){
			$res['msg']="验证码正确！";
			$res['type']='1';
			$res['uid']=$info['uid'];
			$res['username']=$this->half_replace($info['username']);
			$res['email']=$this->half_replace($info['email']);
			$res['moblie']=$this->half_replace($info['moblie']);
			echo json_encode($res);die;
		}else{
			$res['type']='2';
			echo json_encode($res);die;
		}
	}
	function checklink_action(){
	    $_POST=$this->post_trim($_POST);
	    $username=$_POST['username'];
	    if(CheckRegUser($username)==false && CheckRegEmail($username)==false){
	        $res['msg']="用户名包含特殊字符！";
	        $res['type']='8';
	        echo json_encode($res);die;
	    }
	     
	    $shensu=$_POST['linkman'].'-'.$_POST['linkphone'].'-'.$_POST['linkemail'];
	    $M=$this->MODEL("userinfo");
	    $nid = $M->UpdateMember(array('appeal'=>$shensu,'appealtime'=>time(),'appealstate'=>'1'),array('username'=>$username));
	    if ($nid){
	        $res['type']='1';
	        echo json_encode($res);die;
	    }
	}
	function editpw_action(){
        $username=$_POST['username'];
		if(CheckRegUser($username)==false && CheckRegEmail($username)==false){
            $res['msg']="用户名包含特殊字符！";
            $res['type']='8';
            echo json_encode($res);die;
		}
		$M=$this->MODEL("userinfo");
		$info = $M->GetMemberOne(array('username'=>$username),array("field"=>"`uid`,`username`,`email`,`moblie`"));
		if($_POST['sendtype']=='email'){
			$check=$info['email'];
		}else{
			$check=$info['moblie'];
		}
		$cert = $M->GetCompanyCert(array("uid"=>$info['uid'],"type"=>"7","check"=>$check),array("field"=>"`uid`,`check2`,`ctime`,`id`"));
        if($_POST['code']!=$cert['check2']){
			$res['msg']="验证码错误";
			$res['type']='8';
			echo json_encode($res);die;
		}
        if(!$_POST['password']){
			$res['msg']="请完整填写信息！";
			$res['type']='8';
			echo json_encode($res);die;
		}
        $password = $_POST['password'];
        if(is_array($info)){
            if($this->config[sy_uc_type]=="uc_center" && $info['name_repeat']!="1"){
                $this->uc_open();
                uc_user_edit($info[username], "", $password, $info['email'],"0");
            }
            $salt = substr(uniqid(rand()), -6);
            $pass2 = md5(md5($password).$salt);
            $M->UpdateMember(array("password"=>$pass2,"salt"=>$salt),array("uid"=>$cert['uid']));
            
            $res['msg']='密码修改成功！';
            $res['type']='1';
            $res['uid']=$info['uid'];
            $res['username']=$this->half_replace($info['username']);
            $res['email']=$this->half_replace($info['email']);
            $res['moblie']=$this->half_replace($info['moblie']);
            echo json_encode($res);die;
        }else{
            $res['msg']="对不起！没有该用户！";
            $res['type']='8';
            echo json_encode($res);die;
        }
    }
}