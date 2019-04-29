/** 编辑保存 地址  **/
function submit(){
	  var data = {
		    	"addrId": $("#addrId").val(),
		    	"receiver": $("#receiver").val(),
	         	"provinceId": $("#provinceId").val(),
	         	"cityId": $("#cityId").val(),
	         	"areaId": $("#areaId").val(),
	         	"subAdds": $("#subAdds").val(),
	         	"mobile": $("#mobile").val()
	         };
	  
	if(validateForm() == 0){
		showPageLoadingMsg('保存地址并更新列表...');
		$("#address").submit();
	}	
}

/**判断是否为空**/
function isBlank(_value){
	if(_value==null || _value=="" || _value==undefined){
		return true;
	}
	return false;
}

function validateForm(){
	     var param = new Object();
	     param.errorCount = 0;
	     param.focus = false;
			validateNullFiled($('#receiver'),param,'请填写收货人');
			validateMobileFiled($('#mobile'), param,'请输入正确手机号码');
			validateNullFiled($('#province'),param,'请选择省份');
			validateNullFiled($('#city'),param,'请选择城市');
			validateNullFiled($('#area'),param,'请选择地区');
			validateNullFiled($('#subAdds'),param,'请输入详细地址');
			return param.errorCount;
}
/** 验证字段是否为空  **/
function validateNullFiled(obj,param,description){
		if(param.errorCount == 0){
			if(isBlank(obj.val()) || obj.val() == 0){
					 param.errorCount =  param.errorCount + 1;
				     floatNotify.simple(description);
			}		
		}
}

/** 验证邮箱  **/
function validateEmailFiled(obj,param,description){
		if(param.errorCount == 0 && obj.val().length > 0){
			 var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
			if(!reg.test(obj.val())){
				param.errorCount =  param.errorCount + 1;
				floatNotify.simple(description);
			 }
		}else{
			param.errorCount =  param.errorCount + 1;
			floatNotify.simple(description);
		}
}
		
/** 验证手机  **/
function validateMobileFiled(obj,param,description){
		if(param.errorCount == 0){
			//验证电话号码手机号码，包含至今所有号段   
			var reg=/^1\d{10}$/;
			if(!reg.test(obj.val())){
				param.errorCount =  param.errorCount + 1;
				floatNotify.simple(description);
			}
		} 
}

/** 回退 **/
function backspace(){
	var shopCartStr = $("#shopCartItems").val();
	var type = $("#type").val();
	//调用方法  
	abstractForm(contextPath+'/p/addressList', shopCartStr,type);
}

function abstractForm(URL, shopCartIds,type){
	   var temp = document.createElement("form");        
	   temp.action = URL;        
	   temp.method = "post";        
	   temp.style.display = "none";        
	   var opt = document.createElement("textarea");        
	   opt.name = 'shopCartItems';        
	   opt.value = shopCartIds;    
	   
	   var opt1 = document.createElement("textarea");        
	   opt1.name = 'type';        
	   opt1.value = type;    
	   
	   temp.appendChild(opt);   
	   temp.appendChild(opt1);   
	   temp.appendChild(appendCsrfInput());
	   document.body.appendChild(temp);        
	   temp.submit();        
	   return temp;  
}