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
<!--时间-->
<link rel="stylesheet" type="text/css" href="/Public/datepicker/jquery-ui-1.9.2.custom.min.css">
<script type="text/javascript" charset="utf-8" src="/Public/datepicker/jquery-1.7.2.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/datepicker/jquery-ui-1.9.2.custom.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/Public/datepicker/datepicker_zh-cn.js"></script>
<!--时间end-->

</head>
<body>
<div class="panel admin-panel">
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>添加管理员</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" action="<?php echo U('add');?>">  
      <div class="form-group">
          <div class="label">
            <label>所在角色：</label>
          </div>
          <div class="field" style="padding-top:8px;"> 
          <?php foreach($roleData as $k=>$v):?>
            <input type="checkbox" id="ishome"  name="role_id[]" value="<?php echo ($v["id"]); ?>"/><?php echo ($v["role_name"]); ?>
          <?php endforeach;?>
          </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>管理员名称：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" value="" name="username" data-validate="required:请输用户名" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>密码：</label>
        </div>
        <div class="field">
          <input type="password" class="input w50" value="" name="password" data-validate="required:请输密码" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>请重复输入密码：</label>
        </div>
        <div class="field">
          <input type="password" class="input w50" value="" name="cpassword" data-validate="required:请输密码" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
          <div class="label">
            <label>是否启用：</label>
          </div>
          <div class="field" style="padding-top:8px;"> 
            启用 <input id="ishome"  name="is_use" value="1" type="radio" />
            禁用 <input id="isvouch" name="is_use" value="0" type="radio" />
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
$("#start_time").datepicker({ dateFormat: "yy-mm-dd" });
</script>