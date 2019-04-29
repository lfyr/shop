<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
<head>
<script charset="utf-8" src="/Public/Home/js/jquery.min.js"></script>
<script charset="utf-8" src="/Public/Home/js/global.js"></script>
<script charset="utf-8" src="/Public/Home/js/bootstrap.min.js"></script>
<script charset="utf-8" src="/Public/Home/js/template.js"></script>

<link rel="stylesheet" href="/Public/Home/css/bootstrap.css">
<link rel="stylesheet" href="/Public/Home/css/style.css">
<link rel="stylesheet" href="/Public/Home/css/member.css">
<link rel="stylesheet" href="/Public/Home/css/order3.css"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="yes" name="apple-touch-fullscreen">
<meta content="telephone=no" name="format-detection">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1;user-scalable=no;">
<title>支付页面</title>
<script charset="utf-8" src="/Public/Home/js/randomimage.js"></script>
<script charset="utf-8" src="/Public/Home/js/login.js"></script>
<script type="text/javascript">
    var error = '';
</script>
</head>
<body class="" style="background-color:#fff">
<header class="header">
    <div class="fix_nav">
        <div style="max-width:768px;margin:0 auto;background:#000000;position: relative;">
            <a class="nav-left back-icon" href="javascript:history.back();">返回</a>
            <div class="tit" style="font-size:18px;">支付页面</div>
        </div>
    </div>
</header>
<div class="maincontainer">
   <div class="container itemdetail mini-innner">
    <div class="row">
        <div class="col-md-12 tal mt20">
             
            <div class="col-xs-5 p0" style="width:100%;"><button type="button" style="background:#62b900;border-color: #62b900;"  class="btn btn-info btn-block" onclick="userLogin();"  tabindex="6" >微信支付</button></div>
            
            <div class="col-xs-5 p0" style="width:100%;padding-top:20px;"><button type="button"  class="btn btn-info btn-block" onclick="userLogin();"  tabindex="6" >支付宝支付</button></div>
         </div>
     </div>
  </div>
</div>
<script type="text/javascript">
var contextPath = '';
</script>
</body>
</html>