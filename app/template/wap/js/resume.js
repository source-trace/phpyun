function show_div(id){
	$("#"+id).show();
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
function checkinfo() {
	var name=$.trim($("input[name='name']").val());
	var sex=$.trim($("#sex").val());
	var birthday=$.trim($("input[name='birthday']").val());
	var edu=$.trim($("#edu").val());
	var exp=$.trim($("#exp").val());	
	var email=$.trim($("#email").val());
	var telphone=$.trim($("#telphone").val());
	var living=$.trim($("input[name='living']").val());
	var description=$.trim($("#description").val());
	if(email==""){
		ifemail = true;
	}else{
		ifemail = check_email(email);
	}
	iftelphone = isjsMobile(telphone);
	if(name==""){layermsg('请填写姓名！');return false;}
	if(sex==""){layermsg('请选择性别！');return false;}
	if(birthday==""){layermsg('请填写出生年月！');return false;}		
	if(edu==""){layermsg('请选择最高学历！');return false;}
	if(exp==""){layermsg('请选择工作经验！');return false;}
	if($("#user_idcard").val()==1){
		 ifidcard = isIdCardNo(idcard);
		 if(ifidcard==false){layermsg('请正确填写身份证号码！');return false;}
	}	
	if(iftelphone==false){layermsg('请正确填写手机号码！');return false;}
	if(living==""){layermsg('请填写现居住地！');return false;}
	if(ifemail==false){layermsg('请填写正确格式电子邮件！');return false;}
	var returntype=false;
	$.ajax({
		async: false, 
		type : "POST", 
		url : "index.php?c=get_email_moblie", 
		dataType : 'json', 
		data:{'moblie':telphone,'email':email},
		success : function(data) {
			if(data.msg==1){
				returntype=true;
			}else{
				layermsg(data.msg);return false;
			}
		} 
	});
	return returntype;
/*	var returntype=false;
	$.post("index.php?c=get_email_moblie",{moblie:telphone,email:email},function(data){alert(data);
		if(data==1){
			return true;
		}else{
			layermsg(data);
		}
	})
	return false;*/
}
function kresume(){	
    var name=$.trim($("input[name='name']").val());
    var hy=$.trim($("#hy").val());
	var job_classid=$.trim($("#job_classid").val());
	var provinceid=$.trim($("#provinceid").val());
	var cityid=$.trim($("#cityid").val());
	var three_cityid=$.trim($("#three_cityid").val());
	var minsalary=$.trim($("#minsalary").val());
	var maxsalary=$.trim($("#maxsalary").val());
	var report=$.trim($("#report").val());
	var type=$.trim($("#type").val());
	var jobstatus=$.trim($("#jobstatus").val());
	var uname=$.trim($("input[name='uname']").val());
	var sex=$.trim($("#sex").val());
	var birthday=$.trim($("#birthday").val());
	var edu=$.trim($("#edu").val());
	var exp=$.trim($("#exp").val());
	var telphone=$.trim($("#telphone").val());
	var email=$.trim($("#email").val());
	var living=$.trim($("#living").val());
	var workname,worksdate,workedate,worktitle,workcontent,eduname,edusdate,eduedate,education,eduspec,proname,protitle,prosdate,proedate,procontent;
	if(name==""){
		layermsg('请填写期望岗位！');return false;
	}
	if(hy==""){
		layermsg('请选择从事行业！');return false;
	}
	if(job_classid==""){
		layermsg('请选择期望职位！');return false;
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
	if(type==""){
		layermsg('请选择工作性质！');return false;
	}
	if(report==""){
		layermsg('请选择到岗时间！');return false;
	}
	if(jobstatus==""){
		layermsg('请选择求职状态！');return false;
	}		
	if(uname==""){
		layermsg("请填写真实姓名！",2,8);return false;
	}
	if(sex==''){
		layermsg("请选择性别！",2,8);return false;
	}
	if(birthday==''){
		layermsg("请选择出生年月！",2,8);return false;
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
	var myreg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	if(email!="" && !myreg.test($('#email').val())){
		layermsg("邮箱格式错误！",2,8);return false;
		return false;
	}
	if(living==''){
		layermsg("请选择现居住地！",2,8);return false;
	}
	if($('#resume_exp').val()=='1'){
		workname = $('#workname').val();
		worksdate = $('#worksdate').val();
		workedate = $('#workedate').val();
		worktitle = $('#worktitle').val();
		workcontent = $('#workcontent').val();
		if(workname==''){
			layermsg("请填写单位名称！",2,8);return false;
		}
		if(worksdate==''){
			layermsg("请填写入职时间！",2,8);return false;

		}else if(workedate){

			var wst=toDate(worksdate);
			var wed=toDate(workedate);
			if(wst>wed){ 	
				layermsg('离职时间不合理！');return false;
			}
		}
		if(worktitle==''){
			layermsg("请填写担任职务！",2,8);return false;
		}

		
	}

	if($('#resume_edu').val()=='1'){
		eduname = $('#eduname').val();
		edusdate = $('#edusdate').val();
		eduedate = $('#eduedate').val();
		education = $('#education').val();
		eduspec = $('#eduspec').val();
		if(eduname==''){
			layermsg("请填写学校名称！",2,8);return false;
		}
		if(edusdate==''){
			layermsg("请填写入学时间！",2,8);return false;
		}
		if(eduedate==''){
			layermsg("请填写离校或预计离校时间！",2,8);return false;
		}else{
			var est=toDate(edusdate);
			var eed=toDate(eduedate);
			if(est>eed){ 	
				layermsg('离校时间不合理！');return false;
			}
		}
		if(eduspec==''){
			layermsg("请填写所学专业！",2,8);return false;
		}
		if(education==''){
			layermsg("请选择对应学历！",2,8);return false;
		}
		

		
	}

	if($('#resume_pro').val()=='1'){
		proname = $('#proname').val();
		prosdate = $('#prosdate').val();
		proedate = $('#proedate').val();
		protitle = $('#protitle').val();
		procontent = $('#procontent').val();
		if(proname==''){
			layermsg("请填写项目名称！",2,8);return false;
		}
		if(prosdate==''){
			layermsg("请填写项目开始时间！",2,8);return false;
		}
		if(proedate==''){
			layermsg("请填写项目结束时间！",2,8);return false;
		}else{
			var pst=toDate(prosdate);
			var ped=toDate(proedate);
			if(pst>ped){ 	
				layermsg('项目结束时间不合理！');return false;
			}
		}
		if(protitle==''){
			layermsg("请填写项目担任职务！",2,8);return false;
		}
	}
	var layerIndex=layer.open({
		type: 2,
		content: '努力保存中'
	});

	$.post(wapurl + "/member/index.php?c=kresume", {name:name,hy:hy,job_classid:job_classid,provinceid:provinceid,cityid:cityid,three_cityid:three_cityid,minsalary:minsalary,maxsalary:maxsalary,report:report,type:type,jobstatus:jobstatus,uname:uname,sex:sex,birthday:birthday,edu:edu,exp:exp,email:email,telphone:telphone,living:living,workname:workname,worksdate:worksdate,workedate:workedate,worktitle:worktitle,workcontent:workcontent,eduname:eduname,edusdate:edusdate,eduedate:eduedate,education:education,eduspec:eduspec,proname:proname,prosdate:prosdate,proedate:proedate,protitle:protitle,procontent:procontent}, function (data) {
		layer.close(layerIndex);
		if(data==1){
			layermsg('保存成功！',2,function(){window.location.href='index.php?c=resume';}); 
		}else if(data==2){
			layermsg('手机已存在！');
		}else if(data==3){
			layermsg('邮箱已存在！');
		}else if(data==4){
			layermsg('你的简历数已经超过系统设置的简历数了！',2,function(){window.location.href='index.php?c=resume';});
		}else if(data==5){
			layermsg('请先完成身份认证！');
		}else if(data==6){
			layermsg('请将信息填写完整！');
		}else if(data==7){
			layermsg('最高薪资必须大于最低薪资！');
		}else{
			layermsg('保存失败！');
		}
	})
}

function convertFormToJson(formid){
	var elements=$("#"+formid).find("*");	
	var str = '';
	for(var i=0;i<elements.length;i++){
		if($(elements).eq(i).attr("name")){ 
			str=str+","+$(elements).eq(i)[0].name+':"'+$(elements).eq(i)[0].value+'"';
		}
	}
	if(str.length>0){
		str=str.substring(1);
	}
	var cToObj=eval("({"+str+"})");
	return cToObj;
}
function check_email(strEmail) {
	 var emailReg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((.[a-zA-Z0-9_-]{2,3}){1,2})$/;
	 if (emailReg.test(strEmail))
	 return true;
	 else
	 return false;
 }
function checkshow(id){
	if(id=="expect"){
		$("#infobutton").show();
		$("#info").hide();
	}else if(id=="info"){
		$("#expectbutton").show();
		$("#expect").hide();
	}
	$("#"+id+"button").hide();
	$("#"+id).show();
} 
function saveexpect(){
	var name=$.trim($("#name").val());
	var hy=$.trim($("#hy").val());
	var job_classid=$.trim($("#job_classid").val());
	var provinceid=$.trim($("#provinceid").val());
	var cityid=$.trim($("#cityid").val());
	var three_cityid=$.trim($("#three_cityid").val());
	var minsalary=$.trim($("#minsalary").val());
	var maxsalary=$.trim($("#maxsalary").val());
	var report=$.trim($("#report").val());
	var type=$.trim($("#type").val());
	var jobstatus=$.trim($("#jobstatus").val());
	var eid=$.trim($("#eid").val());
	if(name==""){
		layermsg('请填写期望岗位！');return false;
	}
	if(job_classid==""){
		layermsg('请选择工作职能！');return false;
	}
	if(provinceid==""){
		layermsg('请选择期望城市！');return false;
	}
	if(minsalary==""||minsalary=="0"){
		layermsg('请填写期望薪资！');return false;
	}
	if(maxsalary&&parseInt(maxsalary)<=parseInt(minsalary)){
		layermsg('最高薪资必须大于最低薪资！');return false;
	}
	var layerIndex=layer.open({
		type: 2,
		content: '努力保存中'
	});
	$.post(wapurl + "/member/index.php?c=expect", {name:name,hy: hy, job_classid: job_classid, provinceid: provinceid, cityid: cityid, three_cityid: three_cityid, minsalary: minsalary, maxsalary: maxsalary, report: report,type:type,jobstatus:jobstatus,eid: eid }, function (data) {
		layer.close(layerIndex);
		if(data>0){
			layermsg('保存成功！',2,function(){window.location.href='index.php?c=modify&eid='+eid;}); 
		}else{
			layermsg('保存失败！');
		}
	})
}

function checkskill(){
	var name=$.trim($("input[name='name']").val());
	var longtime=$.trim($("input[name='longtime']").val());
	if(name==""){
		layermsg('请填写技能名称！');return false;
	}
	if(longtime==""||longtime=="0"){
		layermsg('请填写掌握时间！');return false;
	}
}
function checkdesc(){
	var desc=$.trim($("#description").val());
	if(desc==""){
		layermsg('请填写自我描述！');return false;
	}
	var layerIndex=layer.open({
		type: 2,
		content: '努力保存中'
	});
	$.post(wapurl + '/member/' + $("#descInfo").attr("action"), convertFormToJson("descInfo"), function (data) {
		layer.close(layerIndex);
		var jsonData=eval("("+data+")"); 
		if(jsonData.url){
			layermsg(jsonData.msg,2,function(){window.location.href=jsonData.url;}); 
		}else{
			layermsg(jsonData.msg);
		}
	});
	return false;
}
function toDate(str){
    var sd=str.split("-");
    return new Date(sd[0],sd[1]);
}
function checkwork(){
	var name=$.trim($("input[name='name']").val());
	var sdate=$.trim($("input[name='sdate']").val()); 
	var edate=$.trim($("input[name='edate']").val()); 
	var title=$.trim($("input[name='title']").val());
	var content=$.trim($("textarea[name='content']").val());
	if(name==""){
		layermsg('请填写单位名称！');return false;
	}
	if(sdate==""){
		layermsg('请选择入职时间！');return false;
	}else if(edate){
		var st=toDate(sdate);
		var ed=toDate(edate);
		if(st>ed){ 	
			layermsg('请确认日期先后顺序！');return false;
		}
	}
	if(edate=="" && document.getElementById("ckendday").checked == false){
		layermsg('请选择离职时间！');return false;
	}
	var layerIndex=layer.open({
		type: 2,
		content: '努力保存中'
	});
	$.post(wapurl + '/member/' + $("#workInfo").attr("action"), convertFormToJson("workInfo"), function (data) {
		layer.close(layerIndex);
		var jsonData=eval("("+data+")"); 
		if(jsonData.url){
			layermsg(jsonData.msg,2,function(){window.location.href=jsonData.url;}); 
		}else{
			layermsg(jsonData.msg);
		}
	});
	return false;
}
function checkproject(){
	var name=$.trim($("input[name='name']").val());
	var sdate=$.trim($("input[name='sdate']").val()); 
	var edate=$.trim($("input[name='edate']").val()); 
	var title=$.trim($("input[name='title']").val());
	var content=$.trim($("textarea[name='content']").val());
	if(name==""){
		layermsg('请填写项目名称！');return false;
	}
	if(sdate==""||edate==""){
		layermsg('请正确填写项目时间！');return false;
	}
	if(edate){
		var st=toDate(sdate);
		var ed=toDate(edate);
		if(st>ed){ 	
			layermsg('请确认日期先后顺序！');return false;
		}
	}
	var layerIndex=layer.open({
		type: 2,
		content: '努力保存中'
	});
	$.post(wapurl + '/member/' + $("#projectInfo").attr("action"), convertFormToJson("projectInfo"), function (data) {
		layer.close(layerIndex);
		var jsonData=eval("("+data+")"); 
		if(jsonData.url){
			layermsg(jsonData.msg,2,function(){window.location.href=jsonData.url;}); 
		}else{
			layermsg(jsonData.msg);
		}
	});
	return false;
}
function checkedu(){
	var name=$.trim($("input[name='name']").val());
	var sdate=$.trim($("input[name='sdate']").val()); 
	var edate=$.trim($("input[name='edate']").val()); 
	var education=$.trim($("#education").val());
	var title=$.trim($("input[name='title']").val());
	var specialty=$.trim($("input[name='specialty']").val());
	if(name==""){
		layermsg('请填写学校名称！');return false;
	}
	if(sdate==""||edate==""){
		layermsg('请正确填写在校时间！');return false;
	}
	if(edate){
		var st=toDate(sdate);
		var ed=toDate(edate);
		if(st>ed){ 	
			layermsg('请确认日期先后顺序！');return false;
		}
	}
	var layerIndex=layer.open({
		type: 2,
		content: '努力保存中'
	});
	$.post(wapurl+'/member/'+$("#eduInfo").attr("action"),convertFormToJson("eduInfo"),function(data){
		layer.close(layerIndex);
		var jsonData=eval("("+data+")"); 
		if(jsonData.url){
			layermsg(jsonData.msg,2,function(){window.location.href=jsonData.url;}); 
		}else{
			layermsg(jsonData.msg);
		}
	});
	return false;
}
function checktraining(){
	var name=$.trim($("input[name='name']").val());
	var sdate=$.trim($("input[name='sdate']").val()); 
	var edate=$.trim($("input[name='edate']").val()); 
	var title=$.trim($("input[name='title']").val());
	var content=$.trim($("textarea[name='content']").val());
	if(name==""){
		layermsg('请填写培训中心！');return false;
	}
	if(sdate==""||edate==""){
		layermsg('请正确填写培训时间！');return false;
	}
	if(edate){
		var st=toDate(sdate);
		var ed=toDate(edate);
		if(st>ed){ 	
			layermsg('请确认日期先后顺序！');return false;
		}
	}
	var layerIndex=layer.open({
		type: 2,
		content: '努力保存中'
	});
	$.post(wapurl + '/member/' + $("#trainingInfo").attr("action"), convertFormToJson("trainingInfo"), function (data) {
		layer.close(layerIndex);
		var jsonData=eval("("+data+")"); 
		if(jsonData.url){
			layermsg(jsonData.msg,2,function(){window.location.href=jsonData.url;}); 
		}else{
			layermsg(jsonData.msg);
		}
	});
	return false;
}
function checkcert(){
	var name=$.trim($("input[name='name']").val());
	var sdate=$.trim($("input[name='sdate']").val()); 
	var edate=$.trim($("input[name='edate']").val()); 
	var title=$.trim($("input[name='title']").val());
	var content=$.trim($("textarea[name='content']").val());
	if(name==""){
		layermsg('请填写证书全称！');return false;
	}
	if(sdate==""){
		layermsg('请填写证书颁发时间！');return false;
	}
	if(title==""){
		layermsg('请填写颁发单位！');return false;
	}
	if(content==""){
		layermsg('请填写证书描述！');return false;
	}
	var layerIndex=layer.open({
		type: 2,
		content: '努力保存中'
	});
	$.post(wapurl + '/member/' + $("#certInfo").attr("action"), convertFormToJson("certInfo"), function (data) {
		layer.close(layerIndex);
		var jsonData=eval("("+data+")"); 
		if(jsonData.url){
			layermsg(jsonData.msg,2,function(){window.location.href=jsonData.url;}); 
		}else{
			layermsg(jsonData.msg);
		}
	});
	return false;
}
function checkother(){
	var name=$.trim($("input[name='name']").val());
	var content=$.trim($("textarea[name='content']").val());
	if(name==""){
		layermsg('请填写其他标题！');return false;
	}
	var layerIndex=layer.open({
		type: 2,
		content: '努力保存中'
	});
	$.post(wapurl + '/member/' + $("#otherInfo").attr("action"), convertFormToJson("otherInfo"), function (data) {
		layer.close(layerIndex);
		var jsonData=eval("("+data+")"); 
		if(jsonData.url){
			layermsg(jsonData.msg,2,function(){window.location.href=jsonData.url;}); 
		}else{
			layermsg(jsonData.msg);
		}
	});
	return false;
}
function ckresume(type){
	var val=$("#"+type).find("option:selected").text(); 
	$('.'+type).html(val); 
}
function check_show(id){
	$('#'+id).toggle();
}
function ckenddays(id){ 
	if($("#ckendday").attr("checked")=='checked'){
		$('#'+id).val('');
	}
}
function workckenddays(id){ 
	if($("#workckendday").attr("checked")=='checked'){
		var date=new Date;
		var year=date.getFullYear(); 
		var month=date.getMonth()+1;

		$('#'+id).val(year+'-'+month);
	}else{
		$('#'+id).val('');
	}
}
$(function(){
	$(".changetag").live('click',function(){
		
		var tag=$(this).attr('tag-class');
		if(tag=='1'){
			$(this).addClass('resume_pop_bq_cur');
			$(this).attr('tag-class','2');
		}else{
			$(this).removeClass('resume_pop_bq_cur');
			$(this).attr('tag-class','1');
		}
		var tag_value;
		var tagi = 0;
		$(".resume_pop_bq_cur").each(function(){
			if($(this).attr('tag-class')=='2'){
				var info =$(this).attr("data-tag");
		        tag_value+=","+info;
				tagi++;

			}
		});
		if(tagi>5){
			layermsg('最多只能选择五项！', 2,8);
			if(tag=='1'){
				$(this).removeClass('resume_pop_bq_cur');
			}
			return false;
		}
		if(tag_value){ 
		    tag_value = tag_value.replace("undefined,","");
		    $("#tag").val(tag_value); 
	    }else{
			$("#tag").val(''); 
		}
	});
//添加自定义个人标签
	$('.checkboxAddBton').click(function(){

		var ntag = $('#addfuli').val();
		//判断当前已选标签数量 限定为5个
		var tagid = $('#tag').val();
		if(tagid && tagid.split(',').length>=5){

			layermsg('最多只能选择五项！', 2,8);
		}else{
			var error=0;
			if(ntag.length>=2 && ntag.length<=8){
				//判断信息是否已经存在 
				$('.changetag').each(function(){
					var otag = $(this).attr('data-tag');
					if(ntag == otag){
						layermsg('相同标签已存在，请选择或重新填写！', 2,8);
						error = 1;
					}
				});
				if(error==0){
					$('.resume_pop_bq ul').append('<li class="changetag  resume_pop_bq_cur" data-tag="'+ntag+'" tag-class="2"><em>'+ntag+'</em></li>');
					
					var tag_value;
					$(".resume_pop_bq_cur").each(function(){
						if($(this).attr('tag-class')=='2'){
							var info =$(this).attr("data-tag");
							tag_value+=","+info;
						}
					});
					tag_value = tag_value.replace("undefined,","");
					$("#tag").val(tag_value); 
				}
				$('#addfuli').val('');
				
			}else{
				layermsg('请输入2-8个标签字符！', 2,8);
			}
		}
	});
});

function checkdoc(){
	var doc=UE.getEditor('doc').hasContents();
	if(doc==""||doc==false){
		layermsg('请填写黏贴简历内容！');return false;
	}
	var layerIndex=layer.open({
		type: 2,
		content: '努力保存中'
	});
	$.post(wapurl + '/member/' + $("#docInfo").attr("action"), convertFormToJson("docInfo"), function (data) {
		layer.close(layerIndex);
		var jsonData=eval("("+data+")"); 
		if(jsonData.url){
			layermsg(jsonData.msg,2,function(){window.location.href=jsonData.url;}); 
		}else{
			layermsg(jsonData.msg);
		}
	});
	return false;
}