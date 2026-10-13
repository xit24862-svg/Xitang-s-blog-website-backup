<?php die();//主题定制需求联系作者[www.yiwuku.com qq:77940140]?>{* Template Name:主题自主SEO方案标题模块 * Template Type: none *}
{if $type=='index'}
<title>{if $zbp->Config('erx_Glass_p')->titleset}{$zbp->Config('erx_Glass_p')->title}{if $page>'1'}{erx_Glass_p_seotcer()}第{$page}页{/if}{else}{$name}{if $page>'1'}{erx_Glass_p_seotcer()}第{$page}页{/if}{erx_Glass_p_seotcer()}{$subname}{/if}</title>
<meta name="keywords" content="{$zbp->Config('erx_Glass_p')->keywords}">
<meta name="description" content="{$zbp->Config('erx_Glass_p')->description}">
{elseif $type=='article'}
<title>{if $article.Metas.seotitle}{$article.Metas.seotitle}{else}{$title}{if !$zbp->Config('erx_Glass_p')->nocate}{erx_Glass_p_seotcer()}{$article.Category.Name}{/if}{erx_Glass_p_seotcer()}{$name}{/if}</title>
<meta name="keywords" content="{if $article.Metas.keywords}{$article.Metas.keywords}{else}{foreach $article.Tags as $tag}{$tag.Name},{/foreach}{$article.Category.Name}{/if}">
{php}$description = preg_replace('/[\r\n\s)]|(\s|\&nbsp\;|　|\xc2\xa0)+/', ' ', trim(SubStrUTF8(FormatString($article->Intro,'[nohtml]'),100)).'...');if($description=='...'){$description = preg_replace('/[\r\n\s)]|(\s|\&nbsp\;|　|\xc2\xa0)+/', ' ', trim(SubStrUTF8(FormatString($article->Content,'[nohtml]'),100)).'...');}{/php}
<meta name="description" content="{if $article.Metas.description}{$article.Metas.description}{else}{$description}{/if}">
{elseif $type=='page'}
<title>{if $article.Metas.seotitle}{$article.Metas.seotitle}{else}{$title}{erx_Glass_p_seotcer()}{$name}{/if}</title>
<meta name="keywords" content="{if $article.Metas.keywords}{$article.Metas.keywords}{else}{$title},{$name}{/if}">
{php}$description = preg_replace('/[\r\n\s)]|(\s|\&nbsp\;|　|\xc2\xa0)+/', ' ', trim(SubStrUTF8(FormatString($article->Content,'[nohtml]'),100)).'...');{/php}
<meta name="description" content="{if $article.Metas.description}{$article.Metas.description}{else}{$description}{/if}">
{elseif $type=='category'}
<title>{if $category.Metas.seotitle}{$category.Metas.seotitle}{else}{$title}{erx_Glass_p_seotcer()}{$name}{/if}</title>
<meta name="keywords" content="{if $category.Metas.keywords}{$category.Metas.keywords}{else}{$title},{$name}{/if}">
<meta name="description" content="{$category.Intro}">
{elseif $type=='tag'}
<title>{$title}{erx_Glass_p_seotcer()}{$name}</title>
<meta name="keywords" content="{$tag.Name}{if $tag.Alias},{$tag.Alias}{/if}">
<meta name="description" content="{$tag.Intro}">
{elseif $type=='author'}
<title>{$title}{erx_Glass_p_seotcer()}{$name}</title>
<meta name="keywords" content="{$author.Name}{if $author.Alias},{$author.Alias}{/if}">
<meta name="description" content="{preg_replace('/[\r\n\s]+/', ' ', trim(FormatString($author.Intro,'[nohtml]')))}">
{else}
<title>{$title}{erx_Glass_p_seotcer()}{$name}</title>
<meta name="keywords" content="{$title}">
<meta name="description" content="{$title}">
{/if}
{if $zbp->Config('erx_Glass_p')->metaog}
<meta property="og:type" content="{$type}">
<meta property="og:url" content="{$zbp->fullcurrenturl}">
<meta property="og:image" content="{$host}zb_users/theme/{$theme}/images/{erx_Glass_p_exImg('logo.png', 'erxlogo.png')}">
<meta property="og:title" content="{if $type=='index'}{$name}{else}{$title}{/if}">
<meta property="og:description" content="{if $type=='article' || $type=='page'}{if $article.Metas.description}{$article.Metas.description}{else}{$description}{/if}{elseif $type=='category'}{$category.Intro}{elseif $type=='tag'}{$tag.Intro}{elseif $type=='author'}{preg_replace('/[\r\n\s]+/', ' ', trim(FormatString($author.Intro,'[nohtml]')))}{else}{$zbp->Config('erx_Glass_p')->description}{/if}">
{/if}
{if $zbp->Config('erx_Glass_p')->canonical}
<link rel="canonical" href="{$zbp->fullcurrenturl}">
{/if}