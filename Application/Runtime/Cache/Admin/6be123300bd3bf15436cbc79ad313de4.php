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
<script src="/Public/Admin/js/ajaxfileupload.js"></script>
<script src="/Public/Admin/js/pintuer.js"></script>  
</head>
<body>  

  <div class="panel admin-panel">
    <div class="panel-head"><strong class="icon-reorder"> 品牌列表</strong> <a href="" style="float:right; display:none;">添加字段</a></div>
   <form method="GET" name="search_form">
    <div class="padding border-bottom">
      <ul class="search" style="padding-left:10px;">
        <li> <a class="button border-main icon-plus-square-o" href="<?php echo U('add')?>"> 添加品牌</a> </li>
        <li>搜索：</li>
        <li>
          <input type="text" placeholder="请输入搜索关键字" name="keyword" class="input" style="width:250px; line-height:17px;display:inline-block" value="<?php echo I('get.keyword'); ?>" />
          <input type="submit" value=" 搜索 " class="button" /></li>	
      </ul>
    </div>
    </form>
    <table class="table table-hover text-center">
      <tr>
        <th width="100" style="text-align:left; padding-left:20px;">ID</th>
        <th>品牌名称</th>
        <th>品牌logo</th>
        <th width="310">操作</th>
      </tr> 
      <?php foreach($data as $v):?>
        <tr>
          <td style="text-align:left; padding-left:20px;"><input type="checkbox" name="id[]" value="<?php echo ($v["id"]); ?>" />
           <?php echo ($v["id"]); ?></td>
          
          <td><?php echo ($v["brand_name"]); ?></td>
          <td><?php echo showImage($v['logo'],50,50);?></td>
          <td><div class="button-group"><a class="button border-main" href="<?php echo U('edit?id='.$v['id'].'&p='.I('get.p'))?>"><span class="icon-edit"></span> 修改</a> <a class="button border-red" href="<?php echo U('del?id='.$v['id'].'&p='.I('get.p'))?>" onclick="return confirm('确定要删除吗？');"><span class="icon-trash-o"></span> 删除</a> </div></td>
        </tr>
      <?php endforeach;?>
      <?php if(preg_match('/\d/', $page)): ?>  
      <tr>
        <td colspan="8"><div class="pagelist"><?php echo $page;?></div></td>
      </tr>
      <?php endif; ?> 
    </table>
  </div>

<script type="text/javascript">

//为启用的td添加一个事件
$('.is_use').click(function(){

	//先获取点击的记录id
	var id=$(this).attr("admin_id");

	if(id==1){
		alert('超级管理员不能禁用！');
		return false;
	}

	var _this=$(this);
	$.ajax({
		type:"GET",
		url:"<?php echo U('ajaxUpdateIsuse','',FALSE);?>/id/"+id,
		success:function(data){
			if(data==0)
				_this.html('禁用');
			else
				_this.html('启用');
		}
	});
});
//搜索
function changesearch(){	
		
}

//单个删除
function del(id,mid,iscid){
	if(confirm("您确定要删除吗?")){
		
	}
}

//全选
$("#checkall").click(function(){ 
  $("input[name='id[]']").each(function(){
	  if (this.checked) {
		  this.checked = false;
	  }
	  else {
		  this.checked = true;
	  }
  });
})

//批量删除
function DelSelect(){
	var Checkbox=false;
	 $("input[name='id[]']").each(function(){
	  if (this.checked==true) {		
		Checkbox=true;	
	  }
	});
	if (Checkbox){
		var t=confirm("您确认要删除选中的内容吗？");
		if (t==false) return false;		
		$("#listform").submit();		
	}
	else{
		alert("请选择您要删除的内容!");
		return false;
	}
}

//批量排序
function sorts(){
	var Checkbox=false;
	 $("input[name='id[]']").each(function(){
	  if (this.checked==true) {		
		Checkbox=true;	
	  }
	});
	if (Checkbox){	
		
		$("#listform").submit();		
	}
	else{
		alert("请选择要操作的内容!");
		return false;
	}
}


//批量首页显示
function changeishome(o){
	var Checkbox=false;
	 $("input[name='id[]']").each(function(){
	  if (this.checked==true) {		
		Checkbox=true;	
	  }
	});
	if (Checkbox){
		
		$("#listform").submit();	
	}
	else{
		alert("请选择要操作的内容!");		
	
		return false;
	}
}

//批量推荐
function changeisvouch(o){
	var Checkbox=false;
	 $("input[name='id[]']").each(function(){
	  if (this.checked==true) {		
		Checkbox=true;	
	  }
	});
	if (Checkbox){
		
		
		$("#listform").submit();	
	}
	else{
		alert("请选择要操作的内容!");	
		
		return false;
	}
}

//批量置顶
function changeistop(o){
	var Checkbox=false;
	 $("input[name='id[]']").each(function(){
	  if (this.checked==true) {		
		Checkbox=true;	
	  }
	});
	if (Checkbox){		
		
		$("#listform").submit();	
	}
	else{
		alert("请选择要操作的内容!");		
	
		return false;
	}
}


//批量移动
function changecate(o){
	var Checkbox=false;
	 $("input[name='id[]']").each(function(){
	  if (this.checked==true) {		
		Checkbox=true;	
	  }
	});
	if (Checkbox){		
		
		$("#listform").submit();		
	}
	else{
		alert("请选择要操作的内容!");
		
		return false;
	}
}

//批量复制
function changecopy(o){
	var Checkbox=false;
	 $("input[name='id[]']").each(function(){
	  if (this.checked==true) {		
		Checkbox=true;	
	  }
	});
	if (Checkbox){	
		var i = 0;
	    $("input[name='id[]']").each(function(){
	  		if (this.checked==true) {
				i++;
			}		
	    });
		if(i>1){ 
	    	alert("只能选择一条信息!");
			$(o).find("option:first").prop("selected","selected");
		}else{
		
			$("#listform").submit();		
		}	
	}
	else{
		alert("请选择要复制的内容!");
		$(o).find("option:first").prop("selected","selected");
		return false;
	}
}

</script>
</body>
</html>