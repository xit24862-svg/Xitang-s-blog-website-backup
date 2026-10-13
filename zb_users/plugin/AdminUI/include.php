<?php
RegisterPlugin("AdminUI","ActivePlugin_AdminUI");

function ActivePlugin_AdminUI() {	 	 
	Add_Filter_Plugin('Filter_Plugin_Admin_Header','AdminUI_override');   
}
// 定义当前插件版本，生产环境记得调用加 true 参数
function AdminUI_version($isProduction = false) {
  if ($isProduction) {
    return '2.1';
  }
  return time();
}
//override美化
function AdminUI_override() {    	 			   		     			 	  
	global $zbp;  	     	 	
	$version = $zbp->themeapp->version;	 
    echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">' . "\r\n";
    echo '<link rel="stylesheet" href="'. $zbp->host .'zb_users/plugin/AdminUI/assets/css/custom.css?v='.AdminUI_version(true).'"/>' . "\r\n"; 
    //去掉下面固定header的样式，移动端还是不浮动了（浮动也可以，需要修改默认编辑器js，ueditor.all.min.js【搜索topOffset:注意冒号别丢，修改0的值为64）
    // echo '<link rel="stylesheet" href="'. $zbp->host .'zb_users/plugin/AdminUI/assets/css/fixed-mobile-header.css?v='.AdminUI_version(true).'"/>' . "\r\n"; 
    echo '<script src="'. $zbp->host .'zb_users/plugin/AdminUI/assets/js/custom.js?v='.AdminUI_version(true).'"></script>' . "\r\n";     
    echo '<script src="'. $zbp->host .'zb_users/plugin/AdminUI/assets/js/nav.js?v='.AdminUI_version(true).'"></script>' . "\r\n";
} 
function InstallPlugin_AdminUI() {

}

function UninstallPlugin_AdminUI() {

}