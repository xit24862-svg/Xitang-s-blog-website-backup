{* @formatter:off *}{* Template Name:网站公共头部 *}
<!DOCTYPE html>
<html lang="{xh_002_language()}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
{if $type=='index'&&$page=='1'}
{xh_002_index_seo($name, $title)}
{elseif $type=='category'}
<title>{$title}-{$name}</title>
<meta name="description" content="{$category.Intro}"/>
{elseif $type=='tag'}
<title>{$title}-{$name}</title>
{else}
<title>{$title}-{$name}</title>
{/if}
<link rel="stylesheet" href="{$host}zb_users/theme/{$theme}/style/{$style}.css" type="text/css" media="all">
<script src="{$host}zb_system/script/jquery-latest.min.js"></script>
<script src="{$host}zb_system/script/zblogphp.js"></script>
<script src="{$host}zb_system/script/c_html_js_add.php"></script>
<script src="{$host}zb_users/theme/{$theme}/style/main.js"></script>
{$header}
{if $type=='index'&&$page=='1'&&$option['ZC_XMLRPC_ENABLE']}
<link rel="alternate" type="application/rss+xml" href="{$feedurl}" title="{$name}"/>
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="{$host}zb_system/xml-rpc/?rsd"/>
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="{$host}zb_system/xml-rpc/wlwmanifest.xml"/>
{/if}
{xh_002_ico_html()}
</head>