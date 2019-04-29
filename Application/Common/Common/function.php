<?php

//发送email
function sendMail($to, $title, $content)
{
	require_once('./PHPMailer_v5.1/class.phpmailer.php');
    $mail = new PHPMailer();
    // 设置为要发邮件
    $mail->IsSMTP();
    // 是否允许发送HTML代码做为邮件的内容
    $mail->IsHTML(TRUE);
    // 是否需要身份验证
    $mail->SMTPAuth=TRUE;
    $mail->CharSet='UTF-8';
    /*  邮件服务器上的账号是什么 */
    $mail->From=C('MAIL_ADDRESS');
    $mail->FromName=C('MAIL_FROM');
    $mail->Host=C('MAIL_SMTP');
    $mail->Username=C('MAIL_LOGINNAME');
    $mail->Password=C('MAIL_PASSWORD');
    // 发邮件端口号默认25
    $mail->Port = 25;
    // 收件人
    $mail->AddAddress($to);
    // 邮件标题
    $mail->Subject=$title;
    // 邮件内容
    $mail->Body=$content;
    return($mail->Send());
}

//XSS过滤
function removeXSS($val)
{
	// 实现了一个单例模式，这个函数调用多次时只有第一次调用时生成了一个对象之后再调用使用的是第一次生成的对象（只生成了一个对象），使性能更好
	static $obj = null;
	if($obj === null)
	{
		require('./HTMLPurifier/HTMLPurifier.includes.php');
		$config = HTMLPurifier_Config::createDefault();
		// 保留a标签上的target属性
		$config->set('HTML.TargetBlank', TRUE);
		$obj = new HTMLPurifier($config);  
	}
	return $obj->purify($val);  
}

/*
上传图片处理函数
*/
function uploadOne($imgName,$dirname,$thumb=array()){

		$upload = new \Think\Upload();// 实例化上传类
	    $upload->maxSize   =    (int)C('IMG_maxSize') * 1024 * 1024;// 设置附件上传大小
	    $upload->exts      =     C('IMG_exts');// 设置附件上传类型
	    $upload->rootPath  =     C('IMG_rootPath'); // 设置附件上传根目录
	    $upload->savePath  =     $dirname . '/'; // 设置附件上传（子）目录
	    // 上传文件 
	    $info   =   $upload->upload(array($imgName=>$_FILES[$imgName]));
		
	    if(!$info) {// 上传错误提示错误信息
	    	return array(
	    		'ok'=>0,
	    		'error'=>$upload->getError(),
	    	);
	
	    }else{

	    	$ret['ok']=1;
	    	$ret['images'][0] = $logoName = $info[$imgName]['savepath'].$info[$imgName]['savename'];;

	    	//判断是否生成缩略图
	    	if($thumb){

	    		$image = new \Think\Image(); 

	    		foreach ($thumb as $k=>$v) {

	    			$ret['images'][$k+1]=$info[$imgName]['savepath'].'thumb_'.$k.'_'.$info[$imgName]['savename'];
	    			// 打开要处理的图片
	    			$image->open(C('IMG_rootPath').$logoName);
	        		$image->thumb($v[0], $v[1])->save(C('IMG_rootPath').$ret['images'][$k+1]);
	    		}
	    	}
	    	return $ret;
	    } 
}

//显示图片函数class="tb_pic"
function showImage($url,$width='',$height='',$class=''){
	$url=C('IMG_URL').$url; //图片所在目录地址
	if($width){
		$width="width='$width'";
	}
	if($height){
		$height="height='$height'";
	}
	if($class){
		$class="class='$class'";
	}
	echo "<img _src='$url' src='$url' $width $height $class/>";
}

//判断批量上传图片有没有上传至少一张图片
function hasImage($imgName){
	foreach ($_FILES[$imgName]['error'] as $k => $v) {
		if($v==0){
			return TRUE;
		}
	}
	return false;
}

//删除图片 可以传入一组数组删除多张图片
function deleteImage($images){
	
	//从配置文件中取出图片所在目录
    $rp=C('IMG_rootPath');

	foreach($images as $v){

		//@错误抵制符：忽略错误一般再删除文件时候都填添加这个
		@unlink($rp.$v);
	}
}

//排序二维数组
function attr_id_sort($a, $b)
{
	if ($a['attr_id'] == $b['attr_id'])
		return 0;
	return ($a['attr_id'] < $b['attr_id']) ? -1 : 1;
}

//递归删除目录
function delete_dir($dir_name){
      // 打开目录
      // $handle = opendir($dir_name);
      if(!$handle=@opendir($dir_name)){     //检测要打开目录是否存在
           return false;
      }
      //滤掉 "." 和 ".."目录
      readdir($handle);
      readdir($handle);
      //遍历目录文件
      while (($file=readdir($handle))!==FALSE){
        // 子目录
        $file = $dir_name.DIRECTORY_SEPARATOR.$file;

        //判断是否为目录   
        if(is_dir($file)){
          //递归调用
          delete_dir($file);
        }else {
          //删除文件
        	unlink($file);
          // if(unlink($file)){
          //   echo "file $file del success! <br>";
          // }else{
          //   echo "file $file del failed!! <br>";
          // }
        }
      }
      //关闭
      closedir($handle);

      //删除目录
      rmdir($dir_name);
      // if(rmdir($dir_name)){
      //   echo "目录 $dir_name del success!! <br>";
      // }else {
      //   echo "目录 $dir_name del failed!! <br>";  
      // }
}