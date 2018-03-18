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


class upload_model extends model{	
 	
    function Upload_pic($dir="",$water="",$size="",$destination_folder=""){
		
		include(PLUS_PATH."/config.php");
		include_once(LIB_PATH."upload.class.php");
   		
		$paras["upfiledir"]=$dir;
		
		if($size && $size!=''){
			$paras["maxsize"]=$size;
		}
		if($destination_folder && $destination_folder!=''){
		    $paras["destination_folder"]=$destination_folder;
		}
		$paras["addpreview"]=false;
		
		$upload=new Upload($paras);
		
		return $upload;
	}

 	function picmsg($pic,$url='',$type=""){

		$error = array("1"=>"文件太大","2"=>"文件类型不符","3"=>"同名文件已经存在","4"=>"移动文件出错,请检查upload目录权限");

		if($error[$pic]!=""){

			if($type=="ajax"){

				echo "{";
				echo				"url: '".$pic."',\n";
				echo				"s_thumb: '".$error[$pic]."'\n";
				echo "}";
				
				die;

			}else{
				
				$data['status']=$pic;
				$data['msg']=$error[$pic];
				return $data;

			}

		}else{

			return true;

		}
	}
	function layUpload($path, $maxsize){
	    if($_FILES['file']['tmp_name']){
	        if ($path=='logo'){
	            $upload=$this->Upload_pic("./data/logo/");
	        }else{
	            $upload=$this->Upload_pic("./data/upload/".$path."/",false,$maxsize);
	        }
	        $pictures=$upload->picture($_FILES['file']);
	        $picmsg=$this->picmsg($pictures);
	        if($picmsg['status'] == $pictures){
	            $return = array(
	                'code' => 1,
	                'msg' => '上传失败'.$picmsg['msg'],
	                'data' => array()
	            );
	        }else{
	            $url = str_replace("./",$this->config['sy_weburl']."/",$pictures);
	            if ($path=='logo'){
	                $pictures = str_replace('./data', 'data', $pictures);
	                $url = $this->config['sy_weburl']."/".$pictures;
	            }
	            if ($path == 'news'){
	                $return = array(
	                    'code' => 0,
	                    'msg' => '',
	                    'data' => array('src'=>$pictures,'url'=>$url,'s_thumb'=>$upload->news_makeThumb($pictures,200,133,'_S_'))
	                );
	            }else{
	                $return = array(
	                    'code' => 0,
	                    'msg' => '',
	                    'data' => array('src'=>$pictures,'url'=>$url)
	                );
	            }
	        }
	    }else{
	        $return = array(
	            'code' => 2,
	            'msg' => '没有找到要上传的图片',
	            'data' => array()
	        );
	    }
	    return $return;
	} 
}
?>