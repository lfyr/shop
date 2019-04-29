<?php
return array(
	'HTML_CACHE_ON'     =>    false, // 开启静态缓存
	'HTML_CACHE_TIME'   =>    60,   // 全局静态缓存有效期（秒）
	'HTML_FILE_SUFFIX'  =>    '.shtml', // 设置静态缓存文件后缀
	// 定义静态缓存规则
	'HTML_CACHE_RULES'  =>     array(  
		'Index:index'=>array('index',3600), //为首页生成一个一小时的缓存页面，页面名叫index.shtml
		'Index:goods'=>array('{id|goodsdir}/goods_{id}',3600), //为首页生成一个一小时的缓存页面，页面名叫index.shtml
	)
);
function goodsdir($id){
	return ceil($id/100); //计算所在目录的名称
}
?>