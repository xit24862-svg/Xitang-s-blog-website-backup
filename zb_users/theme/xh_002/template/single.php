{* @formatter:off *}{* Template Name:内容页模板 *}
{template:zb_commen_header}{* 头部设置 *}
<body>
{template:zb_commen_top}{* 网站顶部导航 *}
{* 『内容页面』开始 *}
{if $article.Type==ZC_POST_TYPE_ARTICLE}
    {template:zb_post_article}
{else}
    {template:zb_post_page}
{/if}
{* 『内容页面』结束 *}
{template:zb_commen_footer}{* 网站底部导航 *}
</body>
</html>