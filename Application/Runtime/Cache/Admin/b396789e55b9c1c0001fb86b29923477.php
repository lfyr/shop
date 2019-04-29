<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title>公众号信息</title>  
    <link rel="stylesheet" href="/Public/Admin/css/pintuer.css">
    <link rel="stylesheet" href="/Public/Admin/css/admin.css">
    <script src="/Public/Admin/js/jquery.js"></script>
    <script src="/Public/Admin/js/ajaxfileupload.js"></script>
    <script src="/Public/Admin/js/pintuer.js"></script>  

</head>
<body>
<div class="panel admin-panel">
  <div class="panel-head"><strong><span class="icon-pencil-square-o"></span> 公众号配置信息</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" action="<?php echo U('Index/info');?>">
      <div class="form-group">
        <div class="label">
          <label>公众号标题：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="title" value="<?php echo ($Configdata["title"]); ?>" />
          <div class="tips"></div>
        </div>
        <div class="field" style="display:none;">
          <input  type="text" class="input" id="type_id" name="id" value="<?php echo ($Configdata["id"]); ?>" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>公众号LOGO：</label>
        </div>
        <div class="field">
          <input type="text" id="url1" name="logo" class="input tips" style="width:25%; float:left;" value="<?php echo ($Configdata["logo"]); ?>"  data-place="right" data-image="<?php echo ($Configdata["logo"]); ?>"/>
          <div class="button bg-blue margin-left upload xin" >+ 浏览上传<input type="file" class="yc" onchange="uploadFile('image')" id="image" name="image" value="+ 浏览上传"  c></div>
         
        </div>
      </div> 
      <div class="form-group">
        <div class="label">
          <label>APPID：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="appid" value="<?php echo ($Configdata["appid"]); ?>" />
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>APPSECRET：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="appsecret" value="<?php echo ($Configdata["appsecret"]); ?>" />
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>TOKEN：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="token" value="<?php echo ($Configdata["token"]); ?>" />
        </div>
      </div>

      <div class="form-group">
        <div class="label">
          <label>公众号关键字：</label>
        </div>
        <div class="field">
          <textarea class="input" name="keyword" style="height:80px"><?php echo ($Configdata["keyword"]); ?></textarea>
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>公众号描述：</label>
        </div>
        <div class="field">
          <textarea class="input" name="description"><?php echo ($Configdata["description"]); ?></textarea>
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>联系人：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="contacts" value="<?php echo ($Configdata["contacts"]); ?>" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>手机：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="tel" value="<?php echo ($Configdata["tel"]); ?>" />
          <div class="tips"></div>
        </div>
      </div>
   
     
      
      <div class="form-group">
        <div class="label">
          <label>QQ：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="qq" value="<?php echo ($Configdata["qq"]); ?>" />
          <div class="tips"></div>
        </div>
      </div>
      
     
      <div class="form-group">
        <div class="label">
          <label>Email：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="email" value="<?php echo ($Configdata["email"]); ?>" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>地址：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="address" value="<?php echo ($Configdata["address"]); ?>" />
          <div class="tips"></div>
        </div>
      </div>  
              
      <div class="form-group">
        <div class="label">
          <label>底部信息：</label>
        </div>
        <div class="field">
          <textarea name="footerinfo" class="input" style="height:120px;"><?php echo ($Configdata["footerinfo"]); ?></textarea>
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
</body>
</html>

<script type="text/javascript">
    //异步上传  
    function uploadFile(elementId){  
             var id = $("#type_id").val();

             $.ajaxFileUpload(  
                {  
                    url : "<?php echo U('ajaxLogoUpload', '', FALSE); ?>/id/"+id,//用于文件上传的服务器端请求地址
                    secureuri:false,//一般设置为false  
                    fileElementId:elementId,//文件上传空间的id属性  <input type="file" id="file" name="file" />  
                    dataType: "json",//返回值类型 一般设置为json  
                    success: function(data, status){  
                
                     $("#url1").val(data['dz']);
                     $("#url1").attr("data-image",data['dz']);
                     alert(data['msg']);
                    },
                    error: function(data, status, e){ 
                        alert(e);
                    }
                }  
            )  
    }  
</script>