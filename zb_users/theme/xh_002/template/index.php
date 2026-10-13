{* @formatter:off *}{* 列表页面 *}
{* 『列表页面』入口 *}
{template:zb_commen_header}{* 头部设置 *}

<body>

{template:zb_commen_top}{* 网站顶部导航 *}

{* 『列表页面』开始 *}

{if $type=='index'&&$page=='1'}
    {template:zb_list_index}{* 网站首页 *}
{elseif $type=='category'}
    {template:zb_list_category}{* 网站分页页面 *}
{elseif $type=='tag'}
    {template:zb_list_tag}{* 网站标签页面 *}
{* elseif $type=='author' *}
    {* template:zb_list_author *}{* 网站作者页面 *}
{* else* }
{* template:zb_list_list *}{* 网站其他列表页面 *}
{/if}

{* 『列表页面』结束 *}

{template:zb_commen_footer}{* 网站底部导航 *}

</body>
</html>