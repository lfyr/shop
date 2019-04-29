<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title>后台管理中心</title>  
    <link rel="stylesheet" href="/Public/Admin/css/pintuer.css">
    <link rel="stylesheet" href="/Public/Admin/css/admin.css">
    <script src="/Public/Admin/js/jquery.js"></script>   
</head>
<body style="background-color:#f2f9fd;">
<div class="header bg-main">
  <div class="logo margin-big-left fadein-top"> 
    <h1><img src="<?php echo ($ConfigData["logo"]); ?>" class="radius-circle rotate-hover" height="50" alt="" />后台管理中心</h1>
  </div>
  <div class="head-l"><a class="button button-little bg-green" href="/" target="_blank"><span class="icon-home"></span> 前台首页</a> &nbsp;&nbsp;<a href="<?php echo U('delete_dir');?>" class="button button-little bg-blue"><span class="icon-wrench"></span> 清除缓存</a> &nbsp;&nbsp;<a class="button button-little bg-red" href="<?php echo U('Login/logout')?>"><span class="icon-power-off"></span> 退出登录</a> </div>
</div>
<div class="leftnav">
  <div class="leftnav-title"><strong><span class="icon-list"></span>菜单列表</strong></div>
  <?php foreach($btn as $v):?>   
  <h2 class='on'><span class="<?php if($v['pri_name']=='系统权限管理'){ echo 'icon-gear';}elseif($v['pri_name']=='微信管理'){echo 'icon-weixin';}elseif($v['pri_name']=='商品管理'){echo 'icon-shopping-cart';}else{echo 'icon-pencil-square-o';}?>"></span><?php echo ($v["pri_name"]); ?></h2>
  <ul style="display:none">
  <?php foreach($v['children'] as $v1):?>
    <li><a href="<?php echo U($v1['module_name'].'/'.$v1['controller_name'].'/'.$v1['action_name']);?>" target="right"><span class="icon-caret-right"></span><?php echo ($v1["pri_name"]); ?></a></li>
  <?php endforeach;?>
  </ul> 
<?php endforeach;?>
</div>
<script type="text/javascript">
$(function(){
  $(".leftnav h2").click(function(){
	  $(this).next().slideToggle(200);	
	  $(this).toggleClass("on"); 
  })
  $(".leftnav ul li a").click(function(){
	    $("#a_leader_txt").text($(this).text());
  		$(".leftnav ul li a").removeClass("on");
		$(this).addClass("on");
  })
});
</script>
<ul class="bread">
  <li><a href="<?php echo U('Index/info');?>" target="right" class="icon-home"> 首页</a></li>
  <li><a href="##" id="a_leader_txt">网站信息</a></li>
</ul>
<div class="admin">
  <iframe scrolling="auto" rameborder="0" src="<?php echo U('Index/info');?>" name="right" width="100%" height="100%"></iframe>
</div>
<div style="text-align:center;">

</div>
</body>
</html>