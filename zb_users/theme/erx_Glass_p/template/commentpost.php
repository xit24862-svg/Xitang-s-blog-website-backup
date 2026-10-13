<?php die();//主题定制需求联系原作者[www.yiwuku.com qq:77940140]?>{* Template Name:评论提交模块 *}
<div id="divCommentPost" class="erx-m-bg erx-comm-post">
	<a rel="nofollow" id="cancel-reply" href="#divCommentPost" style="display:none;" title="取消回复">&#10005</a>
	<form id="frmSumbit" target="_self" method="post" action="{$article.CommentPostUrl}" >
		<input type="hidden" name="inpId" id="inpId" value="{$article.ID}">
		<input type="hidden" name="inpRevID" id="inpRevID" value="0">
		<p><textarea name="txaArticle" id="txaArticle" class="erx-m-bot erx-m-bg text" cols="50" rows="4" tabindex="5" ></textarea></p>
{if $user.ID}
		<input type="hidden" name="inpName" id="inpName" value="{$user.Name}">
		<input type="hidden" name="inpEmail" id="inpEmail" value="{$user.Email}">
		<input type="hidden" name="inpHomePage" id="inpHomePage" value="{$user.HomePage}">
{else}
		<div class="erx-flex post-item">
			<p class="erx-m-bot item"><input type="text" name="inpName" id="inpName" class="erx-m-bg text" value="{$user.Name}" size="28" tabindex="1"> <label for="inpName">名称(*)</label></p>
			<p class="erx-m-bot item emial"><input type="text" name="inpEmail" id="inpEmail" class="erx-m-bg text" value="{$user.Email}" size="28" tabindex="2"> <label for="inpEmail">邮箱</label></p>
			{if $zbp->Config('erx_Glass_p')->commenturl}<p class="erx-m-bot item"><input type="text" name="inpHomePage" id="inpHomePage" class="erx-m-bg text" value="{$user.HomePage}" size="28" tabindex="3"> <label for="inpHomePage">网址</label></p>{/if}
{if $option['ZC_COMMENT_VERIFY_ENABLE']}
			<p class="erx-m-bot item vcode"><input type="text" name="inpVerify" id="inpVerify" class="erx-m-bg text" value="" size="28" tabindex="4"> <label for="inpVerify">验证码(*)</label>
				<img src="{$article.ValidCodeUrl}" alt="" title="" onclick="javascript:this.src='{$article.ValidCodeUrl}&amp;tm='+Math.random();">
			</p>
{/if}
		</div>
{/if}
		<div class="erx-flex post-bot"><span class="ti">{if $user.ID>0}<b>{$user.StaticName}</b>，已登录<a href="{BuildSafeCmdURL('act=logout')}" class="red logout">[退出]</a>{else}<b>游客</b> 回复需填写必要信息{/if}</span><input name="sumbit" type="submit" tabindex="6" value="提交" onclick="return zbp.comment.post()" class="erx-m-btn button"></div>
	</form>
</div>