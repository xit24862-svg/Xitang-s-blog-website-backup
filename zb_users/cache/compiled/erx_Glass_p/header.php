<?php  /* Template Name:公用头部模块 */  ?>
<!DOCTYPE html>
<html lang="<?php  echo $language;  ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<?php if ($zbp->Config('erx_Glass_p')->seotool) { ?>
<title><?php  echo $title;  ?>_<?php  echo $name;  ?></title>
<?php }else{  ?>
<?php  include $this->GetTemplate('title');  ?>
<?php } ?>
<link rel="stylesheet" href="<?php  echo $host;  ?>zb_system/image/icon/icon.css">
<link rel="stylesheet" href="<?php  echo $host;  ?>zb_users/theme/<?php  echo $theme;  ?>/style/<?php  echo $style;  ?>.css?v=<?php  echo $themeinfo['version'];  ?>">
<script src="<?php  echo $host;  ?>zb_system/script/jquery-latest.min.js"></script>
<script src="<?php  echo $host;  ?>zb_system/script/zblogphp.js"></script>
<script src="<?php  echo $host;  ?>zb_system/script/c_html_js_add.php"></script>
<script src="<?php  echo $host;  ?>zb_users/theme/<?php  echo $theme;  ?>/script/theia-sticky-sidebar.min.js"></script>
<script src="<?php  echo $host;  ?>zb_users/theme/<?php  echo $theme;  ?>/script/custom.js?v=<?php  echo $themeinfo['version'];  ?>"></script>
<?php if ($type=='index'&&$page=='1') { ?>
<link rel="alternate" type="application/rss+xml" href="<?php  echo $feedurl;  ?>" title="<?php  echo $name;  ?>">
<?php } ?>
<?php  echo $header;  ?>
</head>
<body class="<?php  echo $type;  ?>" style="background-image:url(<?php  echo $host;  ?>zb_users/theme/<?php  echo $theme;  ?>/images/<?php  echo erx_Glass_p_exImg('bg.jpg', 'erxbg.jpg');  ?>);">
	<div class="erx-wrap">
		<header class="header">
			<div class="erx-flex erx-head-wrap">
				<div class="erx-logo"><a href="<?php  echo $host;  ?>"><?php if ($zbp->Config('erx_Glass_p')->logotype=="2") { ?><img src="<?php  echo $host;  ?>zb_users/theme/<?php  echo $theme;  ?>/images/<?php  echo erx_Glass_p_exImg('logo.png', 'erxlogo.png');  ?>" alt="<?php  echo $name;  ?>"><?php }else{  ?><?php  echo $name;  ?><?php } ?></a></div>
				<div class="erx-flex erx-head-rt">
					<div class="erx-menu">
						<ul class="erx-m-bg erx-flex">
<?php  if(isset($modules['navbar'])){echo $modules['navbar']->Content;}  ?>
						</ul>
					</div>
					<div class="erx-flex erx-top-search">
						<div class="erx-flex erx-top-nav"><?php if ($user->ID || !$user->ID && $zbp->Config('erx_Glass_p')->login_url) { ?><a href="<?php if ($user->ID) { ?><?php  echo $host;  ?>zb_system/admin/index.php?act=admin" target="_blank<?php }else{  ?><?php  echo $zbp->Config('erx_Glass_p')->login_url;  ?><?php } ?>" class="login<?php if ($user->ID) { ?> erxact<?php } ?>" title="<?php if ($user->ID) { ?><?php  echo $user->StaticName;  ?>，已<?php } ?>登录"></a><?php } ?><a href="javascript:;" class="navi" title="导航菜单"></a></div>
						<form action="<?php  echo $host;  ?>zb_system/cmd.php?act=search" method="post" class="erx-search-form">
							<input name="q" type="text" autocomplete="off" class="erx-m-bg sint" placeholder="搜索..."><button class="sbtn"><i></i></button>
						</form>
					</div>
				</div>
			</div>
		</header>
