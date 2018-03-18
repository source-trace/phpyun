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
class index_controller extends common{
	function index_action(){
		include PLUS_PATH."/tplmoblie.cache.php";
		if($tplmoblie['wapdiy']==1){
			$this->get_moblie();
			$navigation=$this->obj->DB_select_all("navigation","`nid`='20'");
			$nav = $this->obj->DB_select_all("tplmobliepic","`type`='nav'");
			foreach($nav as $k=>$v){
				if($v['pic']&&file_exists(str_replace('./',APP_PATH, $v['pic']))){
					$nav[$k]['pic']=str_replace('./', $this->config['sy_weburl'].'/', $v['pic']);
				}else{
					$nav[$k]['pic']='';
				}
				foreach ($navigation as $vv){
					if($v['url']==$vv['id']){
						$nav[$k]['navurl']=Url('wap',array('c'=>$vv['url']));
					}
				}
			}
			$this->yunset(array('nav'=>$nav));
			$hd = $this->obj->DB_select_all("tplmobliepic","`type`='hd'");
			foreach($hd as $k=>$v){
				if($v['pic']&&file_exists(str_replace('./',APP_PATH, $v['pic']))){
					$hd[$k]['pic']=str_replace('./', $this->config['sy_weburl'].'/', $v['pic']);
				}else{
					$hd[$k]['pic']='';
				}
			}
			$this->yunset("hd",$hd);
			$indexnav = $this->obj->DB_select_all("tplmobliepic","`type`='indexnav' order by `id` asc");
			
			foreach($indexnav as $k=>$v){
				if($v['pic']&&file_exists(str_replace('./',APP_PATH, $v['pic']))){
					$indexnav[$k]['pic']=str_replace('./', $this->config['sy_weburl'].'/', $v['pic']);
				}else{
					$indexnav[$k]['pic']='';
				}
				
				foreach ($navigation as $vv){
					if($v['url']==$vv['id']){
						$indexnav[$k]['indexnavurl']=Url('wap',array('c'=>$vv['url']));
					}
				}
			}
			foreach($indexnav as $k=>$v){
				if($k==0){
					$indexnav1=$v;
				}
				if($k==1){
					$indexnav2=$v;
				}
				if($k==2){
					$indexnav3=$v;
				}
			}
			
			$this->yunset("indexnav1",$indexnav1);
			$this->yunset("indexnav2",$indexnav2);
			$this->yunset("indexnav3",$indexnav3);
			$adlist = $this->obj->DB_select_all("tplmobliepic","`type`='ad'");
			foreach($adlist as $k=>$v){
				if($v['pic']&&file_exists(str_replace('./',APP_PATH, $v['pic']))){
					$adlist[$k]['pic']=str_replace('./', $this->config['sy_weburl'].'/', $v['pic']);
				}else{
					$adlist[$k]['pic']='';
				}
			}
			$this->yunset("adlist",$adlist);
			
			if($tplmoblie['rewardjobnum']<1){
				$tplmoblie['rewardjobnum']=5;
			}
			if($tplmoblie['hotjobnum']<1){
				$tplmoblie['hotjobnum']=8;
			}
			if($tplmoblie['newjobnum']<1){
				$tplmoblie['newjobnum']=5;
			}
			if($tplmoblie['hotcomnum']<1){
				$tplmoblie['hotcomnum']=5;
			}
			if($tplmoblie['articlenum']<1){
				$tplmoblie['articlenum']=5;
			}
			if($tplmoblie['resumenum']<1){
				$tplmoblie['resumenum']=5;
			}
			if($tplmoblie['urgentjobnum']<1){
				$tplmoblie['urgentjobnum']=5;
			}
			if($tplmoblie['recjobnum']<1){
				$tplmoblie['recjobnum']=5;
			}
			if($tplmoblie['zphnum']<1){
				$tplmoblie['zphnum']=5;
			}
			$this->yunset('tplmoblie',$tplmoblie);
			
			if( $tplmoblie['sort']){
				$sort=explode(',', $tplmoblie['sort']);
			}else{
				$sort="hearder,hd,search,nav,indexnav,notice,reglogin,ad,rewardjob,hotjob,newjob,hotcom,recjob,urgentjob,resume,article,zph,jobclass";
				$sort=explode(',', $sort);
			}
			$this->yunset('sort',$sort);
			
			$searchurl=array(
					array('id'=>1,'c'=>'job','name'=>'找工作'),
					array('id'=>2,'c'=>'resume','name'=>'找人才'),
					array('id'=>3,'c'=>'company','name'=>'找企业'),
					array('id'=>4,'c'=>'part','name'=>'找兼职'),
					array('id'=>5,'c'=>'tiny','name'=>'普工专区'),
					array('id'=>6,'c'=>'once','name'=>'店铺招聘'),
					array('id'=>12,'c'=>'ask','a'=>'list','name'=>'互动问答')
			);
			$this->yunset('searchurl',$searchurl);
			$this->yunset($this->MODEL('cache')->GetCache(array('job')));
			$this->seo("index");
			$this->yuntpl(array('wap/wap_diy'));
		}else{
			$this->get_moblie();
			$this->seo("index");
			$this->yuntpl(array('wap/index'));
		}
		
	}
	function pubqrcode_action(){
		$wapUrl = Url('wap',array('type'=>1));
		include_once LIB_PATH."yunqrcode.class.php";
		YunQrcode::generatePng2($wapUrl,4);
	}
	function loginout_action(){
		$this->cookie->unset_cookie();
		$this->wapheader('index.php');
	}
}
?>