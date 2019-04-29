$(function(){
	// 详情数量减少
	$('.details_con .minus,.cart_count .minus').click(function(){
		var _index=$(this).parent().parent().index()-1;
		var _count=$(this).parent().find('.count');
		var _val=_count.val();
		if(_val>1){
			_count.val(_val-1);
			$('.details_con .selected span').eq(_index).text(_val-1);
			
		}
		if(_val<=2){
			$(this).addClass('disabled');
		}
		
	});

	// 详情数量添加
	$('.details_con .add,.cart_count .add').click(function(){
		var _index=$(this).parent().parent().index()-1;
		var _count=$(this).parent().find('.count');
		var _val=_count.val();
		$(this).parent().find('.minus').removeClass('disabled');
		_count.val(_val-0+1);
		$('.details_con .selected span').eq(_index).text(_val-0+1);
		
	});

	//详情属性选择
	$('.details_con ul li dd').click(function(e) {
		clickChoose(this);
	});
	
	//处理默认选中的
	$('.details_con ul li dd[class="check"]').each(function(){
		clickChoose(this);
	});
});



//选中属性
function clickChoose(object){
	//---------------------------------------------------------------------- 输出语句
	//console.debug("clickChoose 被调用到。");
	if (!$(object).hasClass('attr_sold_out')) {
		$(object).addClass('check').siblings().removeClass('check');
	}

	//选择货品，如颜色、版本等
	$(".product dd").click(function(){
		// $(this).addClass("selected").siblings().removeClass("selected");
		$(this).find("input").attr({checked:"checked"});
	
	});

}


//立即购买
function buyNow() {
	$("#cart").submit();
}

/** 收藏商品 **/
function addInterest(obj,prodId){
	 var _this = $(obj);
	jQuery.ajax({
		url : contextPath + "/addInterest",
		data : {
			"prodId" : prodId
		},
		type : 'post',
		async : false, //默认为true 异步   
		dataType : 'json',
		error : function(data) {
		},
		success : function(retData) {
			floatNotify.simple(retData.message);
			if(retData.status == 1){
				//更换样式
				_this.find("i").addClass("i-fav-active");
			}
		}
	});
}

//获取参数页面
var paramResult;
function queryParameter(element,prodId){
	
	if(paramResult!=undefined){
		element.find('.desc-area').html(paramResult);
	}else{
		$.ajax({
			url: contextPath+"/queryDynamicParameter", 
			data: {"prodId":prodId},
			type:'post', 
			async : true, //默认为true 异步   
			error:function(data){
			},   
			success:function(data){
				paramResult=data;
				element.find('.desc-area').html(paramResult);
			}   
		});         
	}
	
	element.addClass('hadGoodsContent');
 }
 
//获取评论
function queryProdComment(element,prodId){
  var data = {
    "curPageNO": $("#prodCommentCurPageNO").val(),
	"prodId":prodId
  };
  jQuery.ajax({
	url:contextPath+"/comments",
	data: data,
	type:'post', 
	async : true, //默认为true 异步   
	error: function(jqXHR, textStatus, errorThrown) {
 		 //alert(textStatus, errorThrown);
	},
	success:function(result){
		element.html(result);
	}
  });
  element.addClass('hadGoodsContent');
}

//获取下一页评价
function next_comments(curPageNO,obj){
	var th = jQuery("#goodsContent .bd ul").eq(2);
	var page = parseInt(curPageNO)+1;
	var prodId = $("#prodId").val();
	var data = {
		    "curPageNO": page,
			"prodId":prodId
		};
	var _this = $(obj);
	jQuery.ajax({
		url:contextPath+"/comments",
		data: data,
		type:'post', 
		async : true, //默认为true 异步   
		error: function(jqXHR, textStatus, errorThrown) {
	 		 //alert(textStatus, errorThrown);
		},
		success:function(result){
			th.append(result);
			_this.remove();
		}
	  });
}