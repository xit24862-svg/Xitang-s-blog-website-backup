<?php die();//主题定制需求联系作者[www.yiwuku.com qq:77940140]?>{* Template Name:文章单页判断模块 *}
{template:header}
{if $article.Type==ZC_POST_TYPE_ARTICLE}
{template:post-single}
{else}
{template:post-page}
{/if}
{template:footer}