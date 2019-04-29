$(function() {
	totl();
	adddel()
	//勾选
	$(".checkLabel").click(function(){

		var flag = $(this).prev().is(':checked');
		if(flag){
	        $(this).prev().attr("checked",false);
	        
	        $("#buy-sele-all").attr("checked", false); //将全选勾除
	        $("#buy-sele-all").val(0);
	        
	    }else{
	    	
	        $(this).prev().attr("checked",true);
	        
	        //如果全部都选中了，将全选勾选
	        var groupUL = $(".container").find("ul[class='list-group']").get();
	        var checkUL = $(".container").find("div[class='icheck pull-left mr5'] :checkbox:checked").get();
	        if(groupUL.length == checkUL.length){
	        	$("#buy-sele-all").attr("checked", true);
	        	$("#buy-sele-all").val(1);
	        }
	    }
		
	  //计算总价
	  calculateTotal();
	});

	// 全选，全不选
	$("#buy-sele-all").click(function() {

	    var flag = $(this).val();

	    if(flag ==1){
	        $(this).val(0);
	         $(".ids").attr("checked", false);
	    }else{
	        $(this).val(1);
	        $(".ids").attr("checked", true);
	    }
	    
	  //计算总价
		  calculateTotal();
	});

	//计算总价
	function calculateTotal(){

		var allCash = 0;

		var list = $(".container").find("ul[class='list-group']").get();

		for(var i=0;i<list.length;i++){

			var selected = $(list[i]).find("div[class='icheck pull-left mr5']>:checkbox").is(":checked");

			if(selected){

				var cash = $(list[i]).find("em[class='totle red']").html();//取小计

				allCash+= Number(cash);

			}
		}
		$("#susum").html(allCash.toFixed(2));
	}
})

//合计
function totl() {

	var sum = 0;
	var list = $(".container").find("ul[class='list-group']").get();

	for(var i=0;i<list.length;i++){
		var selected = $(list[i]).find("div[class='icheck pull-left mr5']>:checkbox").is(":checked");
		if(selected){
			var a=$(list[i]).find("em[class='totle red']");
			var xj=a.html();
			sum+=Number(xj);
		}
	}

	$("#susum").text(sum);
}

function adddel(){
	//小计和加减
		//加

		$(".add").each(function() {
				$(this).click(function() {

					var $multi = 0;
					var vall = $(this).prev().val();
					vall++;
					//ajax修改数量
					var li=$(this).parent().parent().parent();
					var gid=li.attr('goods_id');
					var gaid=li.attr('goods_attr_id');
			
					//调用ajax
					ajaxUpdateCartData(gid,gaid,vall);

					$(this).prev().val(vall);
					$multi = parseFloat(vall) * parseFloat($(this).parent().prev().text());
					$(this).parent().parent().next().next().text(Math.round($multi));
					totl();
				})

			})
			//减
		$(".reduc").each(function() {
				$(this).click(function() {
					var $multi1 = 0;
					var vall1 = $(this).next().val();
					vall1--;
					if(vall1 <= 0) {
						vall1 = 1;
					}
					//ajax修改数量
					var li=$(this).parent().parent().parent();
					var gid=li.attr('goods_id');
					var gaid=li.attr('goods_attr_id');
					//调用ajax
					ajaxUpdateCartData(gid,gaid,vall1);
					$(this).next().val(vall1);
					$multi1 = parseFloat(vall1) * parseFloat($(this).parent().prev().text());
					$(this).parent().parent().next().next().text(Math.round($multi1));
					totl();
				})

			})
}


	// $("#order").submit();







	
