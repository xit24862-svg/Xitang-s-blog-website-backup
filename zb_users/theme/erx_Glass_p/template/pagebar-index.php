{if $pagebar}
{foreach $pagebar.buttons as $k=>$v}
  {if $pagebar.PageNow+1==$k}
    <a href="{$v}" class="erx-m-bg more">下一页</a>
  {/if}
{/foreach}
{/if}