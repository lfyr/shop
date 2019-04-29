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
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>修改内容</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" action="<?php echo U('edit');?>">  
      <div class="form-group">
        <div class="label">
          <label>关键字：</label>
        </div>
        <div class="field" style="display:none;">
          <input  type="text" class="input" id="id" name="id" value="<?php echo ($data["id"]); ?>" />
          <div class="tips"></div>
        </div>
        <div class="field">
          <input type="text" class="input w50" value="<?php echo ($data["keyword"]); ?>" name="keyword" data-validate="required:请输keyword" />
          <div class="tips"></div>
        </div>
      </div>
      <span style="padding-left:10%;height:30px; line-height:30px;color:red;">*如需换行轻敲回车键</span>
      <div class="form-group">

        <div class="label">
          <label>内容：</label>
        </div>
        <div class="field">
          <textarea name="content" class="input" style="height:450px; border:1px solid #ddd;"><?php echo ($data["content"]); ?></textarea>
          <div class="tips"></div>
        </div>
      </div>
     
      <div class="clear"></div>
     
      <div class="form-group">
        <div class="label">
          <label>排序：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="sort" value="<?php echo ($data["sort"]); ?>"  data-validate="number:排序必须为数字" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>发布时间：</label>
        </div>
        <div class="field"> 
          <script src="js/laydate/laydate.js"></script>
          <input type="text" class="laydate-icon input w50" name="addtime" id="start_time" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="<?php  echo date('Y-m-d', $data['addtime']); ?>"  data-validate="required:日期不能为空" style="padding:10px!important; height:auto!important;border:1px solid #ddd!important;" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>作者：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="author" value="<?php echo ($data["author"]); ?>"  />
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