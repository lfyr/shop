<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
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
</script><meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="yes" name="apple-touch-fullscreen">
<meta content="telephone=no" name="format-detection">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1;user-scalable=no;">
<title>提交订单</title>

<script charset="utf-8" src="/Public/Home/js/submitOrders.js"></script>
<script charset="utf-8" src="/Public/Home/js/weixinSubmitOrders.js"></script>
<script type='text/javascript' src="/Public/Home/js/jquery.form.js"></script>
<style type="text/css">
.mark{
height: 3.2rem;line-height: 3.2rem;border: 0;padding-left: .5rem;width: 100%;overflow: hidden;
}
.shop_coupon{
height: 2.2rem;margin-right: 0.1rem;-webkit-appearance: none;border: 0;text-align: center;font-size: 14px;padding: 0 1rem 0 .5rem;color:#428bca;
}

.delivery{
height: 2.2rem;margin-right: 0.1rem;-webkit-appearance: none;border: 0;text-align: center;font-size: 14px;padding: 0 1rem 0 .5rem;color:#428bca;
}
</style>
</head>

<body>

<header class="header">
    <div class="fix_nav">
		<div class="nav_inner">
			<a class="nav-left back-icon" href="/shopcart">返回</a>
			<div class="tit">填写订单</div>
		</div>
    </div>
</header>
<form action="/index.php/Home/Cart/order" method="post"  name="order_form">
<div class="container mb50">
    <div class="row">
    	<input type="hidden" id="shr_address" name="shr_address" value=""/>
    	<input type="hidden" id="shr_name" name="shr_name" value=""/>
    	<input type="hidden" id="shr_tel" name="shr_tel" value=""/>
    	<input type="hidden" id="shr_province" name="shr_province" value=""/>
    	<input type="hidden" id="shr_city" name="shr_city" value=""/>
    	<input type="hidden" id="shr_area" name="shr_area" value=""/>
    	
        <a href="<?php echo U('Address/lst');?>" class="address clearfix">
        	<div id='addre'>
            </div>
        </a>
        
        
        
       <ul class="list-group">
       			<?php  $tp=0; foreach($data as $k=>$v):?>
	             <div class="list-group_12" style="margin-bottom: 4px;">
	                                         <!-- 商品 -->
				            <li class="list-group-item hproduct clearfix ">
				                <div class="p-pic">
				                	<a href="<?php echo U('Index/goods?id='.$v['goods_id']);?>">
				                		<?php echo showImage($v['sm_logo'],100,100);?>
				                	</a>
				                </div>
				                <div class="p-info">
				                    <a href="<?php echo U('Index/goods?id='.$v['goods_id']);?>">
				                    	<p class="p-title"><?php echo ($v["goods_name"]); ?> </p>
				                    </a>
				                    <p class="p-attr">
				                    		<span><?php echo ($v["goods_attr_str"]); ?></span></p>
					                <p class="p-origin">
				                    	<em class="price">¥<?php echo ($v["shop_price"]); ?></em>
				                         </p>
				                </div>
				            </li>
				            <li class="list-group-item clearfix">
				                <div class="pull-left mt5">
				                	<span class="gary">小计：</span>
									<em class="red productTotalPrice">￥<?php $xj=$v['goods_number']*$v['shop_price']; $tp+=$xj; echo $xj;?></em>
								</div>
								<div class="pull-right mt5">
				                	<span class="gary">商品数量：</span>
									<em><?php echo ($v["goods_number"]); ?></em>
								</div>
							</li> 
	                 </div>
	            <?php endforeach;?>
	            <li class="list-group-item" style="padding: 2px 1px;margin-bottom:-12px;">
				       <p><input type="text" class="mark" shopId="53" name="remark" id="remark" maxlength="200" placeholder="店铺订单留言"></p>
				   </li> 
	            
	            
	            <!-- 店铺优惠券 -->
			    <!-- 配送方式 -->
	            <li class="list-group-item clearfix">
				                <div class="pull-left mt5">
				                	<span class="gary">物流配送：</span>
								</div>
								<div class="pull-right mt5">
									 <span class="gary pull-right">
					                	<select shopId="53" totalcash="7210.0" class="delivery" name="pay_method" style="width:125px;" >
										       <option value="">请选择配送方式</option>
										       <option value="顺丰">顺丰</option>
										       <option value="圆通">圆通</option>
										       <option value="申通">申通</option>
										        </select>
									       </span>
								</div>
				</li> 
	            
	         </ul>
	         
	   <div class="list-group">
      		<a href="javascript:toInvoice();"><p class="list-group-item text-primary" style="border-bottom-width: 0px;font-size:14px;">暂无发票</p></a>
      		</div>

<div class="list-group">
            <label class="list-group-item pay_radio" style="height: 50px;line-height: 26px;">
		      			商品总额：<span class="black" id="allActualCash" style="color:#900!important;">
		      			¥ <?php echo ($tp); ?></span>
		    </label>
		    <!--  <label class="list-group-item pay_radio" style="height: 50px;line-height: 26px;">
		      			促销优惠：<span class="black" id="allDiscount" style="color:#900!important;">
		      			 -¥ 0.00</span>
		    </label>
		     <label class="list-group-item pay_radio" style="height: 50px;line-height: 26px;">
		                &nbsp;&nbsp;&nbsp;&nbsp;总运费：
		      			<span class="black" id="grossFreight" style="color:#900!important;">
		      			  ¥ 0.00</span>
		    </label> -->
        </div>
    </div>
</div>
<div class="fixed-foot">
	<div class="fixed_inner">
		<div class="pay-point black">
		
			实付款：<em class="red f22">￥<span id="totalPrice"><?php echo ($tp); ?></span></em>
		</div>
		<div class="buy-btn-fix">
			<a href="javascript:void(0);" onclick="$('form[name=order_form]').submit();" class="J_payBtn btn btn-danger btn-buy">提交订单</a>
		</div>
	</div>
</div>
</form>
<script type="text/javascript">
var contextPath = '';

$.ajax({
	url: "<?php echo U('Cart/getDefault')?>", 
    type:'get', 
    dataType:'json',
    success:function(data){
    	
    	if(data==null){
    		$('#addre').html('<p><span class=\'black mr5\'>暂无默认收获地址，请点击添加……</span></p>');
    		exit();
    	}

       var html="";
       $(data).each(function(k,v){
       		shr_name=v.shr_name;
       		shr_tel=v.shr_tel;
       		shr_province=v.shr_province;
       		shr_city=v.shr_city;
       		shr_area=v.shr_area;
       		shr_address=v.shr_address;
       		html+="<p><span class='black mr5'>收件人："+v.shr_name+"</span><span>电话："+v.shr_tel+"</span></p><p class='mb0'>"+v.shr_address+"</p>"
       });
       $('#addre').html(html);
       $('#shr_name').val(shr_name);
       $('#shr_tel').val(shr_tel);
       $('#shr_province').val(shr_province);
       $('#shr_city').val(shr_city);
       $('#shr_area').val(shr_area);
       $('#shr_address').val(shr_address);
    }
});
</script>
</body>
</html>