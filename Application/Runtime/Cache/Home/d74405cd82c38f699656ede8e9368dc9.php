<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<script charset="utf-8" src="/Public/Home/js/jquery.min.js"></script>
<script charset="utf-8" src="/Public/Home/js/global.js"></script>
<script charset="utf-8" src="/Public/Home/js/bootstrap.min.js"></script>
<script charset="utf-8" src="/Public/Home/js/template.js"></script>

<link rel="stylesheet" href="/Public/Home/css/bootstrap.css">
<link rel="stylesheet" href="/Public/Home/css/style.css">
<link rel="stylesheet" href="/Public/Home/css/member.css">
<link rel="stylesheet" href="/Public/Home/css/order3.css"><meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="yes" name="apple-touch-fullscreen">
<meta content="telephone=no" name="format-detection">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1;user-scalable=no;">
<script charset="utf-8" src="/Public/Home/js/jquery.form.js"></script>
<script charset="utf-8" src="/Public/Home/js/prodSort.js"></script>
<title>商品列表</title>
</head>
<body>
<div class="fanhui_cou">
	<div class="fanhui_1"></div>
	<div class="fanhui_ding">顶部</div>
</div>
<header class="header">
	<div class="fix_nav">
		<div class="nav_inner">
			<a class="nav-left back-icon" href="/Public/Home/javascript:history.back();">返回</a>
			<div class="tit">产品列表</div>
		</div>
	</div>
</header>

<div class="container" id="container2">
	<div class="row">
		<ul class="mod-filter clearfix">
			<div class="white-bg_2 bb1">
			
			<li id="default" class="active"><a
				title="默认排序"  href="/Public/Home/javascript:void(0);">默认</a></li>
			<li id="buys"  ><a title="点击按销量从高到低排序"
				href="/Public/Home/javascript:void(0);" >销量
				<i class='icon_sort'></i>
			</a></li>
			<li id="comments"  ><a title="点击按评论数从高到低排序"
				href="/Public/Home/javascript:void(0);" >评论数
				<i class='icon_sort'></i>
			</a></li>
			<li id="cash"  ><a title="点击按价格从高到低排序"
				href="/Public/Home/javascript:void(0);" >价格
				<i class='icon_sort'></i>
			</a></li>
			</div>
		</ul>
		
		<div class="item-list" id="container" rel="2" status="0"><input type="hidden" id="ListTotal" value="1">
			<?php foreach($data as $k=>$v):?>
				<a href="<?php echo U('Index/Goods?id='.$v['id']);?>">
					<div class="hproduct clearfix" style="background:#fff;border-top:0px;">
						<div class="p-pic"><?php echo showImage($v['sm_logo'],100)?></div>
						<div class="p-info">
							<p class="p-title"><?php echo ($v["goods_name"]); ?></p>
							<p class="p-origin"><em class="price">¥<?php echo ($v["shop_price"]); ?></em></p>
							<!-- <p class="mb0"><del class="old-price">¥12.00</del></p> -->
							</div>
					</div>
				</a>
			<?php endforeach;?>
		
		</div>
		
		<div id="ajax_loading" style="display:none;width:300px;margin: 10px  auto 15px;text-align:center;">
			 <img src="/Public/Home/images/loading.gif">
		</div>
		 <form  action='/m_search/prodlist' method="post" id="list_form">
				<input type="hidden" id="curPageNO" name="curPageNO"  value=""/>
			    <input type="hidden"  id="categoryId" name="categoryId" value="36" />
			    <input type="hidden" id="orders" name="orders"  value=""/>
			    <input type="hidden" id="hasProd" name="hasProd"  value="" />
			    <input type="hidden" id="keyword" name="keyword"  value="" />
			    <input type="hidden" id="prop" name="prop"  value="" />
		</form>
	</div>
</div>

</script>
<div class="clear"></div>

<footer class="footer">
  <div class="foot-con">
	<div class="foot-con_2">
		<a href="/">
			<i class="navIcon home"></i>
			<span class="text">首页</span>
		</a>
		<a class="active" href="<?php echo U('Category/lst');?>">
			<i class="navIcon sort"></i>
			<span class="text">分类</span>
		</a>
		<a href="<?php echo U('Cart/lst');?>">
			<i class="navIcon shop"></i>
			<span class="text">购物车</span>		
		</a>
		<a href="<?php echo U('Member/login');?>">
			<i class="navIcon member"></i>
			<span class="text">我的</span>
		</a>
	</div>
  </div>
</footer>
</body>
</html>