<?php die();//主题定制需求联系原作者[www.yiwuku.com qq:77940140]?>{* Template Name:评论模块 *}
{if $socialcomment}
{$socialcomment}
{else}
<!--评论框-->
{template:commentpost}
{if $article.CommNums>0}
{/if}
<label id="AjaxCommentBegin"></label>
<!--评论输出-->
{foreach $comments as $key => $comment}
{template:comment}
{/foreach}
{if $pagebar}
<!--评论翻页条输出-->
<div class="erx-pagebar commentpagebar">
{template:pagebar}
</div>
{/if}
<label id="AjaxCommentEnd"></label>
{/if}