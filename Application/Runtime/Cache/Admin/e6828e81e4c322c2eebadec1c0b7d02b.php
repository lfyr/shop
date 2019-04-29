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
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>添加类型</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" action="<?php echo U('edit');?>">  
    <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
      <div class="form-group">
        <div class="label">
          <label>类型名称：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" value="<?php echo ($data["type_name"]); ?>" name="type_name" data-validate="required:请输类型名称" />
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
$("#start_time").datepicker({ dateFormat: "yy-mm-dd" });
</script>