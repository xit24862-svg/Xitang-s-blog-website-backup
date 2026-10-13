<?php  /* @formatter:off */  ?><?php  /* Template Name:网站公共头部 */  ?>
<!DOCTYPE html>
<html lang="<?php  echo xh_002_language();  ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php if ($type=='index'&&$page=='1') { ?>
<?php  echo xh_002_index_seo($name, $title);  ?>
<?php }elseif($type=='category') {  ?>
<title><?php  echo $title;  ?>-<?php  echo $name;  ?></title>
<meta name="description" content="<?php  echo $category->Intro;  ?>"/>
<?php }elseif($type=='tag') {  ?>
<title><?php  echo $title;  ?>-<?php  echo $name;  ?></title>
<?php }else{  ?>
<title><?php  echo $title;  ?>-<?php  echo $name;  ?></title>
<?php } ?>
<link rel="stylesheet" href="<?php  echo $host;  ?>zb_users/theme/<?php  echo $theme;  ?>/style/<?php  echo $style;  ?>.css" type="text/css" media="all">
<script src="<?php  echo $host;  ?>zb_system/script/jquery-latest.min.js"></script>
<script src="<?php  echo $host;  ?>zb_system/script/zblogphp.js"></script>
<script src="<?php  echo $host;  ?>zb_system/script/c_html_js_add.php"></script>
<script src="<?php  echo $host;  ?>zb_users/theme/<?php  echo $theme;  ?>/style/main.js"></script>
<?php  echo $header;  ?>
<?php if ($type=='index'&&$page=='1'&&$option['ZC_XMLRPC_ENABLE']) { ?>
<link rel="alternate" type="application/rss+xml" href="<?php  echo $feedurl;  ?>" title="<?php  echo $name;  ?>"/>
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php  echo $host;  ?>zb_system/xml-rpc/?rsd"/>
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="<?php  echo $host;  ?>zb_system/xml-rpc/wlwmanifest.xml"/>
<?php } ?>
<?php  echo xh_002_ico_html();  ?>
</head>