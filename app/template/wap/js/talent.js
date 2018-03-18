function ckresume(type){
	var val=$("#"+type).find("option:selected").text(); 
	$('.'+type).html(val); 
}
function checkcity(id,type){
	if(id>0){
		$.post(wapurl+"/index.php?c=ajax&a=wap_city",{id:id,type:type},function(data){ 
			if(type==1){
				$("#cityid").html(data);
				$("#cityshowth").hide();
			}else{
				if(data){
					$("#cityshowth").attr('style','width:31%;');
					$("#three_cityid").html(data);
				}
			}
		})
	}else{
		if(type==1){
			$("#cityshowth").hide();
			$("#cityid").html('<option value="">请选择</option>');
		}
	}
	$("#three_cityid").html('<option value="">请选择</option>');
}

function tresume(){	
	var id = $.trim($("input[name='id']").val());
    var name=$.trim($("input[name='name']").val());
    var hy=$.trim($("#hy").val());
	var provinceid=$.trim($("#provinceid").val());
	var cityid=$.trim($("#cityid").val());
	var three_cityid=$.trim($("#three_cityid").val());
	var minsalary=$.trim($("#minsalary").val());
	var maxsalary=$.trim($("#maxsalary").val());
	var jobstatus=$.trim($("#jobstatus").val());
	var jobname=$.trim($("input[name='jobname']").val());
	var sex=$.trim($("#sex").val());
	var age=$.trim($("#age").val());
	var edu=$.trim($("#edu").val());
	var exp=$.trim($("#exp").val());
	var telphone=$.trim($("#telphone").val());
	var living=$.trim($("#living").val());
	var expinfo=exptext.getContent();
	var eduinfo=edutext.getContent();
	var skillinfo=skilltext.getContent();
	var projectinfo=protext.getContent();
	if(name==""){
		layermsg('请填写姓名！');return false;
	}
	if(sex==''){
		layermsg("请选择性别！",2,8);return false;
	}
	if(age==''){
		layermsg("请填写年龄！",2,8);return false;
	}
	
	if(edu==''){
		layermsg("请选择最高学历！",2,8);return false;
	}
	if(exp==''){
		layermsg("请选择工作经验！",2,8);return false;
	}
	if(telphone==''){
		layermsg("请填写手机号码！",2,8);return false;
	}else{
	  var reg= /^[1][3456789]\d{9}$/; //验证手机号码  
		 if(!reg.test($('#telphone').val())){
			layermsg("手机号码格式错误！",2,8);return false;
		 }
	}
	
	if(living==''){
		layermsg("请填写现居住地！",2,8);return false;
	}
	
	if(jobname==""){
		layermsg('请填写意向岗位！');return false;
	}
	if(hy==""){
		layermsg('请选择从事行业！');return false;
	}
	if(minsalary==""){
		layermsg('请填写期望薪资！');return false;
	}
	if(maxsalary){
		if(parseInt(maxsalary)<=parseInt(minsalary)){
			layermsg('最高薪资必须大于最低薪资！');return false;
		}
	}
	if(cityid==""){
		layermsg('请选择期望城市！');return false;
	}
	
	if(jobstatus==""){
		layermsg('请选择求职状态！');return false;
	}		

	if(expinfo==""){
		layermsg('请填写工作经历！');return false;
	}
	if(eduinfo==""){
		layermsg('请填写教育经历！');return false;
	}

	
	var layerIndex=layer.open({
		type: 2,
		content: '努力保存中'
	});
	$.post(wapurl + "/member/index.php?c=savetalentexpect", {id:id,name:name,hy:hy,jobname:jobname,provinceid:provinceid,cityid:cityid,three_cityid:three_cityid,minsalary:minsalary,maxsalary:maxsalary,jobstatus:jobstatus,sex:sex,age:age,edu:edu,exp:exp,telphone:telphone,living:living,eduinfo:eduinfo,expinfo:expinfo,skillinfo:skillinfo,projectinfo:projectinfo}, function (data) {
		layer.close(layerIndex);
		var date = eval('('+data+')');
		if(date.error=='1'){
			layermsg('操作成功！',2,function(){window.location.href='index.php?c=talent';}); 
		}else{
			layermsg(date.msg);
		}
	})
}
$(document).ready(function(){	
	//职位详情页 申请职位
	$(".lt_reward_sq").click(function(){
		
		var jobid=$(this).attr('data-jobid');
		var eid=$(this).attr('data-eid');
		
		
		layer_load('执行中，请稍候...');
		$.post(wapurl+"/member/index.php?c=talentsqjob",{jobid:jobid,eid:eid},function(data){
			layer.closeAll();
			var data=eval('('+data+')');
			if(data.error==1){          
				layermsg('推荐成功',2,function(){location.reload();});
				
			}else{
				layermsg(data.msg, 2,8);return false;
			}
		});
	})
	
})

function tsendmoblie(){
	if($("#send").val()=="1"){
		return false;
	}
	var moblie=$("input[name=linktel]").val();
	var authcode=$("input[name=authcode]").val();
	var reg= /^[1][3456789]\d{9}$/; //验证手机号码
	if(moblie==''){
		layermsg('手机号不能为空！',2);return false;
	}else if(!reg.test(moblie)){
		layermsg('手机号码格式错误！',2);return false;
	}
	if(!authcode){
		layermsg('请输入验证码！',2);return false;
	}
	layer_load('执行中，请稍候...',0);
	$.post(wapurl+"/index.php?c=ajax&a=mobliecert", {str:moblie,code:authcode},function(data) {
		layer.closeAll();
		if(data=="发送成功!"){ 
			layermsg('发送成功！',2,function(){tsend(121);}); 
		}else if(data==1){
			layermsg('同一手机号一天发送次数已超！', 2);
		}else if(data==2){
			layermsg('同一IP一天发送次数已超！', 2);
		}else if(data==3){
			layermsg('短信通知已关闭，请联系管理员！',2);
		}else if(data==4){
			layermsg('还没有配置短信，请联系管理员！',2);
		}else if(data==5){
			layermsg('请不要重复发送！',2);
		}else if(data==6){
			layermsg('验证码错误！',2);
		}else{
			layermsg(data,2);
		}
		checkCode('vcode_img');
	})
}
function tsend(i){
	i--;
	if(i==-1){
		$("#time").html("重新获取");
		$("#send").val(0);
	}else{
		$("#send").val(1);
		$("#time").html(i+"秒");
		setTimeout("tsend("+i+");",1000);
	}
}
function telstatus(){
	var id = $('#telid').val();
	var linktel = $('#linktel').val();
	
	if(linktel==""){ 
		layer.msg('请输入手机号码！',2);return false;
	}
	var code=$("#moblie_code").val();
	if(code==""){ 
		layermsg('请输入短信验证码！',2);return false;
	}
	
	var i=layer_load('执行中，请稍候...',0);
	$.ajaxSetup({cache:false});
	$.post("index.php?c=telstatus",{id:id,linktel:linktel,code:code},function(data){
		layer.closeAll();
		data = eval('('+data+')');
		if(data.error=='1'){
			
			layermsg('授权认证成功！',2,function(){window.location.href='index.php?c=talent';}); 
			
		}else{
			layermsg(data.msg,2); 
		}
	})
}