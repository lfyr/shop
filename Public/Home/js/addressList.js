/** 编辑收货地址 **/
function addressEdit(addrId){
	var shopCartStr = $("#shopCartItems").val();
	var type = $("#type").val();
	if(isBlank(type)){
		abstractForm(contextPath +'/p/addressEdit/'+addrId, shopCartStr,"");
	}else{
		abstractForm(contextPath +'/p/addressEdit/'+addrId, shopCartStr,type);
	}
	
	
}

/** 新建收货地址  **/
function createAddress(){
	var shopCartStr = $("#shopCartItems").val();
	var type = $("#type").val();
	if(isBlank(type)){
		//调用方法  
		abstractForm(contextPath+'/p/createAddress', shopCartStr,"");
	}else{
		//调用方法  
		abstractForm(contextPath+'/p/createAddress', shopCartStr,type);
	}
}


/** 回退 **/
function backspace(){
	var shopCartStr = $("#shopCartItems").val();
	var type = $("#type").val();
	if(isBlank(type)){
		//调用方法  
		abstractForm(contextPath+'/p/orderDetails', shopCartStr,"");
	}else if(type=="integral"){
		window.location.href=contextPath+'/p/wap/integral/buy/'+shopCartStr
	}else if(type=="group"){
		window.location.href=contextPath+'/p/mobileGroup/orderDetails/'+shopCartStr;
	}
}


/**判断是否为空**/
function isBlank(_value){
	if(_value==null || _value=="" || _value==undefined){
		return true;
	}
	return false;
}

function abstractForm(URL, shopCartIds,type){
	   var temp = document.createElement("form");        
	   temp.action = URL;        
	   temp.method = "post";        
	   temp.style.display = "none";        
	   var opt1 = document.createElement("textarea");        
	   opt1.name = 'shopCartItems';        
	   opt1.value = shopCartIds; 
	   temp.appendChild(opt1);
	   var opt = document.createElement("textarea");        
	   opt.name = 'type';        
	   opt.value = type;   
	   temp.appendChild(opt);      
	   temp.appendChild(appendCsrfInput());
	   document.body.appendChild(temp);        
	   temp.submit();        
	   return temp;  
}