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
<script type="text/javascript" charset="utf-8" src="/Public/datepicker/jquery-1.7.2.min.js"></script>
</head>
<body>
<div class="panel admin-panel">
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>增加关键字</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" action="<?php echo U('edit');?>">  
      <div class="form-group">
        <div class="label">
          <label>角色名称：</label>
        </div>
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <div class="field">
          <input type="text" class="input w50" value="<?php echo ($data["role_name"]); ?>" name="role_name" data-validate="required:请输角色名称" />
          <div class="tips"></div>
        </div>

      </div>
      <div class="form-group">
        <div class="label">
          <label>权限列表：</label>
        </div>
        <div class="field">
          <?php foreach($priData as $k=>$v): if(strpos(','.$rpData.',',','.$v['id'].',') !==FALSE){ $check='checked="checked"'; }else{ $check=''; } ?>
          <?php echo str_repeat('-',$v['level']*8);?>
          <input <?php echo ($check); ?> type="checkbox" level="<?php echo ($v["level"]); ?>"  name="pri_id[]" value="<?php echo ($v["id"]); ?>"  /><?php echo ($v["pri_name"]); ?><br/><br/>
          <?php endforeach;?>
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label></label>
        </div>
        <div class="field">
          <button class="button bg-main icon-check-square-o" type="submit"> 提交</button>
        </div>
      </div>
    </form>
  </div>
</div>

</body></html>
<script type="text/javascript">
// 为所有的选择框绑定点击事件
$(":checkbox").click(function(){
  // 先取出当前权限的level值是多少
  var cur_level = $(this).attr("level");
  // 判断是选中还是取消
  if($(this).attr("checked"))
  {
    var tmplevel = cur_level; // 给一个临时的变量后面要进行减操作
    // 先取出这个复选框所有前面的复选框
    var allprev = $(this).prevAll(":checkbox");
    // 循环每一个前面的复选框判断是不是上级的
    $(allprev).each(function(k,v){
      // 判断是不是上级的权限
      if($(v).attr("level") < tmplevel)
      {
        tmplevel--; // 再向上提一级
        $(v).attr("checked", "checked");
      }
    });
    // 所有子权限也选中
    // 先取出这个复选框所有前面的复选框
    var allprev = $(this).nextAll(":checkbox");
    // 循环每一个前面的复选框判断是不是上级的
    $(allprev).each(function(k,v){
      // 判断是不是上级的权限
      if($(v).attr("level") > cur_level)
        $(v).attr("checked", "checked");
      else
        return false;   // 遇到一个平级的权限就停止循环后面的不用再判断了
    });
  }
  else
  {
    // 先取出这个复选框所有前面的复选框
    var allprev = $(this).nextAll(":checkbox");
    // 循环每一个前面的复选框判断是不是上级的
    $(allprev).each(function(k,v){
      // 判断是不是上级的权限
      if($(v).attr("level") > cur_level)
        $(v).removeAttr("checked");
      else
        return false;   // 遇到一个平级的权限就停止循环后面的不用再判断了
    });
  }
});
</script>