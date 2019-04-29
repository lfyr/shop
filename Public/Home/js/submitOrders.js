function submitOrder(){
	var receiver=$("#receiver").val();
	if(isBlank(receiver)){
		floatNotify.simple('请选择收货地址');
		return;
	}

    $(".delivery").each(function(){
    	  var deliv=$(this).find("option:selected").val();
          if(Number(deliv)-0 <= 0){
            	floatNotify.simple("请选择您的配送方式");
            	config=false;
            	return false;//实现break功能
          }else{
        	  var shopId=Number($(this).attr("shopid"));
        	  var transtype=$(this).find("option:selected").attr("transtype");
        	  delivery+=shopId+":"+transtype+";";
          }
     });
     if(!config){
    	return;
     }
     
	if(delivery!=""){
		delivery=delivery.substring(0, delivery.length-1);
	}
}

/**判断是否为空**/
function isBlank(_value){
	if(_value==null || _value=="" || _value==undefined){
		return true;
	}
	return false;
}
