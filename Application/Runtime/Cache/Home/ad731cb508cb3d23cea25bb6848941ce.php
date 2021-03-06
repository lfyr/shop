<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
<head>
<script charset="utf-8" src="/Public/Home/js/jquery.min.js"></script>
<script charset="utf-8" src="/Public/Home/js/global.js"></script>
<script charset="utf-8" src="/Public/Home/js/bootstrap.min.js"></script>
<script charset="utf-8" src="/Public/Home/js/template.js"></script>
<script charset="utf-8" src="/Public/Home/js/js.js"></script>
<link rel="stylesheet" href="/Public/Home/css/bootstrap.css">
<link rel="stylesheet" href="/Public/Home/css/style.css?v=1">
<link rel="stylesheet" href="/Public/Home/css/member.css">
<link rel="stylesheet" href="/Public/Home/css/order3.css"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="yes" name="apple-touch-fullscreen">
<meta content="telephone=no" name="format-detection">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1;user-scalable=no;">

<title>购物车</title>
</head>
<body>
<div class="fanhui_cou">
	<div class="fanhui_1"></div>
	<div class="fanhui_ding">顶部</div>
</div> <header class="header header_1">
    <div class="fix_nav">
        <div class="nav_inner">
            <a class="nav-left back-icon" href="javascript:history.back();">返回</a>
            <div class="tit">购物车</div>
        </div>
    </div>
</header>
<form method="post" action="<?php echo U('Cart/order');?>">
<div class="container ">
    <div class="row rowcar">
    <?php  $tp=0; foreach($data as $k=>$v):?>
    <ul class="list-group">
			<li class="list-group-item text-primary">
	            <div class="icheck pull-left mr5">
	                <input type="checkbox" checked="checked" value="<?php echo ($v["goods_id"]); ?>-<?php echo ($v["goods_attr_id"]); ?>" name="buythis[]" class="ids" prodStatus="1"  itemkey=""/>
                        <label class="checkLabel">
                       		<span></span>
                        </label>
	            </div>
            	Go Shop</li>
            <li class="list-group-item hproduct clearfix"  goods_id=<?php echo ($v["goods_id"]); ?> goods_attr_id=<?php echo ($v["goods_attr_id"]); ?>>
	                <div class="p-pic"><a href="<?php echo U('Index/goods?id='.$v['goods_id']);?>"><?php echo showImage($v['sm_logo'],100,100);?></a></div>
	                <div class="p-info">
	                    <a href="<?php echo U('Index/goods?id='.$v['goods_id']);?>"><p class="p-title"><?php echo ($v["goods_name"]); ?></p></a>
                    	<p class="p-attr">
	                    		<span><?php echo ($v["goods_attr_str"]); ?></span></p>
                    	<p class="p-origin">
	                    	<a class="close p-close delete delimage">×</a>
	                        <em class='price'>¥<?php echo ($v["shop_price"]); ?></em>
	                    </p>
	                </div>
            </li>
			<li class="list-group-item clearfix"  goods_id=<?php echo ($v["goods_id"]); ?> goods_attr_id=<?php echo ($v["goods_attr_id"]); ?>>
				<div class="btn-group btn-group-sm control-num">

	               <div class="pices" style="display:none;"><?php echo ($v["shop_price"]); ?></div>
                   <div style="width: 130px;"> <span class="reduc glyphicon-minus gary btn btn-default"></span>
                   	<input type="text" class="btn gary2" readonly="readonly" value="<?php echo ($v["goods_number"]); ?>" />
                   <span class="add glyphicon-plus gary btn btn-default"></span></div>
                </div>
                <span class="gary">小计：</span>
				¥<em class="totle red"><?php $xj=$v['goods_number']*$v['shop_price']; $tp+=$xj; echo $xj;?></em>
			</li>
		</ul>
	<?php endforeach;?>
	</div>
</div>
</form>
<div class="fixed-foot">
<div class="fixed_inner">
    <div class="pay-point">
        <div class="icheck pull-left mr10">
            <input type="checkbox" checked="checked" id="buy-sele-all" value="1">
            <label for="buy-sele-all">
                <span class="mt10"></span>全选
            </label>
        </div>
         <p>合计：<em class="red f22">¥<span id="susum" ><?php echo ($tp); ?></span></em></p>
    </div>
    <div class="buy-btn-fix">
        <a href="javascript:void(0);" onclick="$('form').submit();" class="btn btn-danger btn-buy">去结算</a>
    </div>
</div>
</div>
<div class="clear"></div>

<footer class="footer">
  <div class="foot-con">
	<div class="foot-con_2">
		<a href="index.html">
			<i class="navIcon home"></i>
			<span class="text">首页</span>
		</a>
		<a href="category.html">
			<i class="navIcon sort"></i>
			<span class="text">分类</span>
		</a>
		<a href="shopcart.html">
			<i class="navIcon shop"></i>
			<span class="text">购物车</span>		
		</a>
		<a href="userhome.html">
			<i class="navIcon member"></i>
			<span class="text">我的</span>
		</a>
	</div>
  </div>
</footer>
<script type="text/javascript">

$('.delimage').click(function(){
  if(confirm("确定要删除吗？")){
 
    //获取图片所在的li
    var li=$(this).parent().parent().parent().parent();
    var id=$(this).parent().parent().parent();
    var gid=id.attr('goods_id');
    var gaid=id.attr('goods_attr_id');
    var xj=li.find('.totle').html();
    var zj=$("#susum").html();

    //发送ajax到服务器删除
   	ajaxUpdateCartData(gid,gaid,0);
   	li.remove();

   	var newTp=parseFloat(zj)-parseFloat(xj);
 	$("#susum").html(newTp.toFixed(2));
  }
  return false;
});

//ajax 修改库存
//以get 方式请求
function ajaxUpdateCartData(goodsId,goodsAttrId,goodsNumber){

	var _gaid="";
	if(goodsAttrId != ""){
		_gaid="/gaid/"+goodsAttrId;
	}
	$.get("<?php echo U('Home/Cart/ajaxUpdateData','',FALSE);?>/gid/"+goodsId+"/gn/"+goodsNumber+_gaid);
	//$.get("<?php echo U('Home/Cart/ajaxUpdateData','',FALSE);?>/gid/"+goodsId+"/gaid/"+goodsAttrId+"/gn/"+goodsNumber);
}
</script>
</body></html>