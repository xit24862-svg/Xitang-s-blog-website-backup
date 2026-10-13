<?php  /* Template Name:评论提交模块 */  ?>
<div id="divCommentPost" class="erx-m-bg erx-comm-post">
	<a rel="nofollow" id="cancel-reply" href="#divCommentPost" style="display:none;" title="取消回复">&#10005</a>
	<form id="frmSumbit" target="_self" method="post" action="<?php  echo $article->CommentPostUrl;  ?>" >
		<input type="hidden" name="inpId" id="inpId" value="<?php  echo $article->ID;  ?>">
		<input type="hidden" name="inpRevID" id="inpRevID" value="0">
		<p><textarea name="txaArticle" id="txaArticle" class="erx-m-bot erx-m-bg text" cols="50" rows="4" tabindex="5" ></textarea></p>
<?php if ($user->ID) { ?>
		<input type="hidden" name="inpName" id="inpName" value="<?php  echo $user->Name;  ?>">
		<input type="hidden" name="inpEmail" id="inpEmail" value="<?php  echo $user->Email;  ?>">
		<input type="hidden" name="inpHomePage" id="inpHomePage" value="<?php  echo $user->HomePage;  ?>">
<?php }else{  ?>
		<div class="erx-flex post-item">
			<p class="erx-m-bot item"><input type="text" name="inpName" id="inpName" class="erx-m-bg text" value="<?php  echo $user->Name;  ?>" size="28" tabindex="1"> <label for="inpName">名称(*)</label></p>
			<p class="erx-m-bot item emial"><input type="text" name="inpEmail" id="inpEmail" class="erx-m-bg text" value="<?php  echo $user->Email;  ?>" size="28" tabindex="2"> <label for="inpEmail">邮箱</label></p>
			<?php if ($zbp->Config('erx_Glass_p')->commenturl) { ?><p class="erx-m-bot item"><input type="text" name="inpHomePage" id="inpHomePage" class="erx-m-bg text" value="<?php  echo $user->HomePage;  ?>" size="28" tabindex="3"> <label for="inpHomePage">网址</label></p><?php } ?>
<?php if ($option['ZC_COMMENT_VERIFY_ENABLE']) { ?>
			<p class="erx-m-bot item vcode"><input type="text" name="inpVerify" id="inpVerify" class="erx-m-bg text" value="" size="28" tabindex="4"> <label for="inpVerify">验证码(*)</label>
				<img src="<?php  echo $article->ValidCodeUrl;  ?>" alt="" title="" onclick="javascript:this.src='<?php  echo $article->ValidCodeUrl;  ?>&amp;tm='+Math.random();">
			</p>
<?php } ?>
		</div>
<?php } ?>
		<div class="erx-flex post-bot"><span class="ti"><?php if ($user->ID>0) { ?><b><?php  echo $user->StaticName;  ?></b>，已登录<a href="<?php  echo BuildSafeCmdURL('act=logout');  ?>" class="red logout">[退出]</a><?php }else{  ?><b>游客</b> 回复需填写必要信息<?php } ?></span><input name="sumbit" type="submit" tabindex="6" value="提交" onclick="return zbp.comment.post()" class="erx-m-btn button"></div>
	</form>
</div>