{* @formatter:off *}{* 所有评论模板 *}
{if $socialcomment}
{$socialcomment}
{else}

{if $article.CommNums>0}
<ul class="msg msghead">
    <li class="tbname">评论列表</li>
</ul>
{/if}

<label id="AjaxCommentBegin"></label>
{foreach $comments as $key => $comment}
{template:comment}
{/foreach}

<div class="pagebar commentpagebar">
{template:pagebar}
</div>
<label id="AjaxCommentEnd"></label>

{template:commentpost}

{/if}
