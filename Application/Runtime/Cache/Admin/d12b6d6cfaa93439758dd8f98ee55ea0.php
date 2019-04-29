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
    <div class="panel-head"><strong class="icon-reorder"> 属性列表</strong> <a href="" style="float:right; display:none;">添加字段</a></div>
   <form method="GET" name="search_form">
    <div class="padding border-bottom">
      <ul class="search" style="padding-left:10px;">
        <li> <a class="button border-main icon-plus-square-o" href="<?php echo U('add?id='.$v['id'].'&p='.I('get.p').'&type_id='.$type_id)?>"> 添加属性</a> </li>
        <li>按商品类型显示：</li>
        <li>
        	<select name="type_id" class="input" onchange="location.href='/index.php/Admin/Attribute/lst/type_id/'+this.value;">
              <option value="0">选择类型</option>
              <?php foreach($typeData as $v): if($v['id']==$type_id){ $select='selected="selected"'; }else{ $select=''; } ?>
              <option <?php echo ($select); ?> value="<?php echo ($v["id"]); ?>"><?php echo ($v["type_name"]); ?></option>
              <?php endforeach;?>
            </select>
        </li>
      </ul>
    </div>
    </form>

    <table class="table table-hover text-center">
      <tr>
        <th width="100" style="text-align:left; padding-left:20px;">ID</th>
        <th >属性</th>
        <th >属性的类型0:唯一 1:可选</th>
        <th >属性的可选值</th>
        <th >所在的类型的id</th>
        <th width="310">操作</th>
      </tr>
      <?php foreach($data as $v):?>
        <tr>
          <td style="text-align:left; padding-left:20px;"><input type="checkbox" name="id[]" value="<?php echo ($v["id"]); ?>" />
           <?php echo ($v["id"]); ?></td>
          <td><?php echo ($v["attr_name"]); ?></td>
          <td ><?php echo ($v['attr_type']==0) ? '唯一' : '可选';?></td>
          <td ><?php echo ($v["attr_option_values"]); ?></td>
          <td ><?php echo ($v["type_id"]); ?></td>
          <td><div class="button-group"> <a class="button border-main" href="<?php echo U('edit?id='.$v['id'].'&p='.I('get.p').'&type_id='.$type_id)?>"><span class="icon-edit"></span> 修改</a> <a class="button border-red" href="<?php echo U('del?id='.$v['id'].'&p='.I('get.p').'&type_id='.$type_id)?>" onclick="return del(1,1,1)"><span class="icon-trash-o"></span> 删除</a> </div></td>
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