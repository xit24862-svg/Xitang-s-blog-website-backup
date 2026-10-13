{* @formatter:off *}{* Template Name:分页（自己实现）*}
{* &nbsp;<b>1</b>&nbsp;<a href="/method/index_2.html">2</a>&nbsp;<a href="/method/index_3.html">3</a>&nbsp;<a href="/method/index_4.html">4</a>&nbsp;<a href="/method/index_5.html">5</a>&nbsp;<a href="/method/index_6.html">6</a>&nbsp;<a href="/method/index_7.html">7</a>&nbsp;<a href="/method/index_8.html">8</a>&nbsp;<a href="/method/index_9.html">9</a>&nbsp;<a href="/method/index_10.html">10</a>&nbsp;<a href="/method/index_2.html">下一页</a>&nbsp;<a href="/method/index_29.html">尾页</a>*}
{if $pagebar}
    {foreach $pagebar.buttons as $k=>$v}
        {if $pagebar.isFullLink==false && $pagebar.PageNow==$k}
             <b>{$k}</b>&nbsp;
        {else}
            <a title="{$k}" href="{$v}">{$k}</a>&nbsp;
        {/if}
    {/foreach}
{/if}