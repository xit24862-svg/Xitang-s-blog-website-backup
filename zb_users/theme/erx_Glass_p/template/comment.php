<?php die();//主题定制需求联系原作者[www.yiwuku.com qq:77940140]?>{* Template Name:评论列表模块 *}
<div class="msg erx-m-bg reply-items" id="cmt{$comment.ID}">
	<div class="con">
		<div class="reply-avatar"><img class="avatar" src="{$comment.Author.Avatar}" alt="{$comment.Author.StaticName}"></div>
		<div class="msgarticle">{$comment.Content}</div>
		<div class="reply-info"><span class="commentname">{if $zbp->Config('erx_Writing')->commenturl}<a href="{$comment.Author.HomePage}" rel="nofollow" target="_blank">{$comment.Author.StaticName}</a>{else}{$comment.Author.StaticName}{/if}</span><span class="time">{$comment.Time()}</span><span class="revertcomment"><a href="#comment" onclick="zbp.comment.reply('{$comment.ID}')" class="re-comm">回复</a></span></div>
	</div>
{foreach $comment.Comments as $comment}
{template:comment}
{/foreach}
</div>