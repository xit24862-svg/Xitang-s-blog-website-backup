<?php die();//主题定制需求联系作者[www.yiwuku.com qq:77940140]?>{* Template Name:公用头部模块 *}
<!DOCTYPE html>
<html lang="{$language}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
{if $zbp->Config('erx_Glass_p')->seotool}
<title>{$title}_{$name}</title>
{else}
{template:title}
{/if}
<link rel="stylesheet" href="{$host}zb_system/image/icon/icon.css">
<link rel="stylesheet" href="{$host}zb_users/theme/{$theme}/style/{$style}.css?v={$themeinfo['version']}">
<script src="{$host}zb_system/script/jquery-latest.min.js"></script>
<script src="{$host}zb_system/script/zblogphp.js"></script>
<script src="{$host}zb_system/script/c_html_js_add.php"></script>
<script src="{$host}zb_users/theme/{$theme}/script/theia-sticky-sidebar.min.js"></script>
<script src="{$host}zb_users/theme/{$theme}/script/custom.js?v={$themeinfo['version']}"></script>
{if $type=='index'&&$page=='1'}
<link rel="alternate" type="application/rss+xml" href="{$feedurl}" title="{$name}">
{/if}
{$header}
</head>
<body class="{$type}" style="background-image:url({$host}zb_users/theme/{$theme}/images/{erx_Glass_p_exImg('bg.jpg', 'erxbg.jpg')});">
	<div class="erx-wrap">
		<header class="header">
			<div class="erx-flex erx-head-wrap">
				<div class="erx-logo"><a href="{$host}">{if $zbp->Config('erx_Glass_p')->logotype=="2"}<img src="{$host}zb_users/theme/{$theme}/images/{erx_Glass_p_exImg('logo.png', 'erxlogo.png')}" alt="{$name}">{else}{$name}{/if}</a></div>
				<div class="erx-flex erx-head-rt">
					<div class="erx-menu">
						<ul class="erx-m-bg erx-flex">
{module:navbar}
						</ul>
					</div>
					<div class="erx-flex erx-top-search">
						<div class="erx-flex erx-top-nav">{if $user.ID || !$user.ID && $zbp->Config('erx_Glass_p')->login_url}<a href="{if $user.ID}{$host}zb_system/admin/index.php?act=admin" target="_blank{else}{$zbp->Config('erx_Glass_p')->login_url}{/if}" class="login{if $user.ID} erxact{/if}" title="{if $user.ID}{$user.StaticName}，已{/if}登录"></a>{/if}<a href="javascript:;" class="navi" title="导航菜单"></a></div>
						<form action="{$host}zb_system/cmd.php?act=search" method="post" class="erx-search-form">
							<input name="q" type="text" autocomplete="off" class="erx-m-bg sint" placeholder="搜索..."><button class="sbtn"><i></i></button>
						</form>
					</div>
				</div>
			</div>
		</header>
