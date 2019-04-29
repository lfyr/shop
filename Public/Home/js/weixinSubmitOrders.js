function dopay() {
	    showPageLoadingMsg('提交订单...');
		var tradingNumbers=$("#tradingNumbers").val();
		var totalPrice=$("#totalAmount").val();
		var productName=$("#subject").val();
		post(pageContext+"/p/weixinPay/gopay",tradingNumbers,totalPrice,productName);
}

function post(URL, tradingNumbers,totalPrice,productName) {
	   var temp = document.createElement("form");        
	   temp.action = URL;        
	   temp.method = "post";        
	   temp.style.display = "none";        
	   var opt1 = document.createElement("input");        
	   opt1.name = 'tradingNumbers';        
	   opt1.value = tradingNumbers;
	   
	   var opt2 = document.createElement("input");
	   opt2.name = 'totalPrice';        
	   opt2.value = totalPrice;
	   
	   var opt3 = document.createElement("input");
	   opt3.name = 'productName';
	   opt3.value = productName;
	   
	   temp.appendChild(opt1);        
	   temp.appendChild(opt2);
	   temp.appendChild(opt3);
	   temp.appendChild(appendCsrfInput());
	   document.body.appendChild(temp);        
	   temp.submit();        
	   return temp;        
	}  

function isWeiXin(){
    var ua = window.navigator.userAgent.toLowerCase();
    var agent=ua.match(/MicroMessenger/i);
    if(agent=="null" || agent==null || agent==""){
    	return false;
    }
    if(ua.match(/MicroMessenger/i) == 'micromessenger'){
        return true;
    }else{
        return false;
    }
}
