<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
<head>
<script src="/Public/Home/js/jquery.js" type="text/javascript"></script>
<script charset="utf-8" src="/Public/Home/js/global.js"></script>
<script charset="utf-8" src="/Public/Home/js/bootstrap.min.js"></script>
<script charset="utf-8" src="/Public/Home/js/template.js"></script>

<link rel="stylesheet" href="/Public/Home/css/bootstrap.css">
<link rel="stylesheet" href="/Public/Home/css/style.css">
<link rel="stylesheet" href="/Public/Home/css/member.css">
<link rel="stylesheet" href="/Public/Home/css/order3.css">
<link rel="stylesheet" href="/Public/Home/css/app.css">

<!-- fixes the bug Bootstrap 3 Modals and the iOS Virtual Keyboard -->
<script charset="utf-8">
$(document).ready(function(){
//iOS check...ugly but necessary
if( navigator.userAgent.match(/iPhone|iPad|iPod/i) ) {

    $('.modal').on('show.bs.modal', function() {

        // Position modal absolute and bump it down to the scrollPosition
        $(this)
            .css({
                position: 'absolute',
                marginTop: $(window).scrollTop() + 'px',
                bottom: 'auto'
            });

        // Position backdrop absolute and make it span the entire page
        //
        // Also dirty, but we need to tap into the backdrop after Boostrap 
        // positions it but before transitions finish.
        //
        setTimeout( function() {
            $('.modal-backdrop').css({
                position: 'absolute', 
                top: 0, 
                left: 0,
                width: '100%',
                height: Math.max(
                    document.body.scrollHeight, document.documentElement.scrollHeight,
                    document.body.offsetHeight, document.documentElement.offsetHeight,
                    document.body.clientHeight, document.documentElement.clientHeight
                ) + 'px'
            });
        }, 0);

    });

}
});
</script><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="yes" name="apple-touch-fullscreen">
<meta content="telephone=no" name="format-detection">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1;user-scalable=no;">
<title>收货人与地址</title>
<script charset="utf-8" src="/Public/Home/js/addressList.js"></script>
</head>
<body style="background-color:#fff">
<div class="maincontainer">
<div class="container wx_wrap mini-innner">
    <div class="row">
        <header class="header" style="height:44px;">
            <div class="fix_nav">
                <div style="max-width:768px;margin:0 auto;background:#000000;position: relative;">
                    <a class="nav-left back-icon" href="javascript:backspace();">返回</a>
                    <div class="tit">收货人与地址</div>
                </div>
            </div>
        </header>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input id="shopCartItems" value="1923,1919,1920" type="hidden"/>
            <input id="type" value="" type="hidden"/>
            <div class="address_list" id="addressList" style="-webkit-transform-origin: 0px 0px; opacity: 1; -webkit-transform: scale(1, 1);">
                <div class="userAddress" address_id="477" style="color: #000000">
                        <ul class="selected">
                            <li onclick="setDefault(this);"><strong>上官</strong> 18510338936</li>
                            <li class="temp_click" onclick="setDefault(this);">
                                    ﻿云南丽江市玉龙纳西族自治县朝阳区东直门外大街12号</li>
                            <li class="edit" onclick="addressEdit('477');"><a href="javascript:void(0);">编辑</a></li>
                        </ul>
                    </div>
                <div class="wap_page" style="text-align:center;"></div>
                <div class="address_list_link">
                    <a href="javascript:void(0);" onclick="createAddress();" class="item item_new" id="new" style="color: #000000">新增收货人与地址</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>

<footer class="footer">
  <div class="foot-con">
    <div class="foot-con_2">
        <a href="/index">
            <i class="navIcon home"></i>
            <span class="text">首页</span>
        </a>
        <a href="/category">
            <i class="navIcon sort"></i>
            <span class="text">分类</span>
        </a>
        <a href="/shopcart">
            <i class="navIcon shop"></i>
            <span class="text">购物车</span>       
        </a>
        <a href="/userhome">
            <i class="navIcon member"></i>
            <span class="text">我的</span>
        </a>
    </div>
  </div>
</footer></div>
<script type="text/javascript">
var contextPath = '';
</script>
</body>
</html>