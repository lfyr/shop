<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title></title>
<link rel="stylesheet" href="/Public/Admin/css/pintuer.css">
<link rel="stylesheet" href="/Public/Admin/css/admin.css">
<script src="/Public/Admin/js/jquery.js"></script>   
<script src="/Public/Admin/js/pintuer.js"></script>
</head>
<body>  

  <div class="panel admin-panel">
    <div class="panel-head"><strong class="icon-reorder"> 库存列表</strong> <a href="" style="float:right; display:none;">添加字段</a></div>
    <div class="padding border-bottom">
      <ul class="search" style="padding-left:10px;">
        <li> <a class="button border-main icon-plus-square-o" href="<?php echo U('lst')?>"> 商品列表</a> </li>
        <li style="padding-left: 28%; font-weight:bold;"><?php echo ($goods_name); ?></li>
      </ul>
    </div>
    <form action="/index.php/Admin/Goods/goods_number/id/44/goods_name/%E4%B8%89%E6%98%9F+Galaxy+S7%EF%BC%88G9300%EF%BC%894GB+32G+%E9%93%82%E5%85%89%E9%87%91.html" method="post">
	    <table class="table table-hover text-center">
	     	<tr>
	     		<?php foreach($attrData as $k=>$v):?>
	     			<th><?php echo ($v["0"]["attr_name"]); ?></th>
	     		<?php endforeach;?>
		     		<th>库存</th>
		     		<th>操作</th>
	     	</tr>
	     	<?php if($gnData):?>
		     	<?php foreach($gnData as $k0=>$v0): if($k0==0){ $opt='+'; }else{ $opt='-'; } ?>
		     	<tr>
		     		<?php foreach($attrData as $k=>$v):?>
		     			<td>
		     					<div class="field">
			     				<select class="input w50" name="goods_attr_id[]" style="width:100%;">
			     					<option value="">请选择</option>
			     					<?php foreach($v as $k1=>$v1): if(strpos(','.$v0['goods_attr_id'].',',','.$v1['id'].',') !==FALSE ){ $select='selected="selected"'; }else{ $select=''; } ?>
			     					<option <?php echo ($select); ?> value="<?php echo ($v1["id"]); ?>"><?php echo ($v1["attr_value"]); ?></option>
			     					<?php endforeach;?>
			     				</select>
			     				<div class="tips" title=""></div>
		      					</div>
		     			</td>
		     		<?php endforeach;?>
			     		<td>
			     			<input type="text"  class="input" name="goods_number[]" value="<?php echo ($v0["goods_number"]); ?>" style="width:100%;">
			     		</td>
			     		<td><input type="button" onclick="addnew(this);"  class="button button-little bg-blue" value='<?php echo ($opt); ?>'></td>
		     	</tr>
		     	<?php endforeach;?>
		     <?php else:?>
		     	<tr>
		     		<?php foreach($attrData as $k=>$v):?>
		     			<td>
		     					<div class="field">
			     				<select class="input w50" name="goods_attr_id[]" style="width:100%;">
			     					<option value="">请选择</option>
			     					<?php foreach($v as $k1=>$v1):?>
			     					<option  value="<?php echo ($v1["id"]); ?>"><?php echo ($v1["attr_value"]); ?></option>
			     					<?php endforeach;?>
			     				</select>
			     				<div class="tips" title=""></div>
		      					</div>
		     			</td>
		     		<?php endforeach;?>
			     		<td>
			     			<input type="text"  class="input" name="goods_number[]" value="<?php echo ($v0["goods_number"]); ?>" style="width:100%;">
			     		</td>
			     		<td><input type="button" onclick="addnew(this);"  class="button button-little bg-blue" value='+'></td>
		     	</tr>
		     <?php endif;?>
	    </table>
	    <table class="table table-hover text-center">
	    	<tr>
	     		<td colspan="<?php echo count($attrData)+2;?>">
	     			<div class="form-group">
				        <div class="field">
				          <button class="button bg-main icon-check-square-o" type="submit"> 提交</button>
				        </div>
		      		</div>
	     		</td>
	     	</tr>
	     </table>
     </form>
  </div>
</body>
</html>
<script type="text/javascript">
function addnew(btn){
	//获取所在的tr
	var tr=$(btn).parent().parent();
	if($(btn).val()=="+"){
		//获取所在的table
		var table=tr.parent();
		//克隆tr
		var newtr=tr.clone();
		//找到新克隆的tr里面的button的+ 并改为+
		newtr.find(":button").val("-");
		//将新克隆的tr追加到table里
		table.append(newtr);
	}else{
		tr.remove();
	}
	
}
</script>