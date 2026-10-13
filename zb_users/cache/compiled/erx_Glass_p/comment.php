<?php  /* Template Name:评论列表模块 */  ?>
<div class="msg erx-m-bg reply-items" id="cmt<?php  echo $comment->ID;  ?>">
	<div class="con">
		<div class="reply-avatar"><img class="avatar" src="<?php  echo $comment->Author->Avatar;  ?>" alt="<?php  echo $comment->Author->StaticName;  ?>"></div>
		<div class="msgarticle"><?php  echo $comment->Content;  ?></div>
		<div class="reply-info"><span class="commentname"><?php if ($zbp->Config('erx_Writing')->commenturl) { ?><a href="<?php  echo $comment->Author->HomePage;  ?>" rel="nofollow" target="_blank"><?php  echo $comment->Author->StaticName;  ?></a><?php }else{  ?><?php  echo $comment->Author->StaticName;  ?><?php } ?></span><span class="time"><?php  echo $comment->Time();  ?></span><span class="revertcomment"><a href="#comment" onclick="zbp.comment.reply('<?php  echo $comment->ID;  ?>')" class="re-comm">回复</a></span></div>
	</div>
<?php  foreach ( $comment->Comments as $comment) { ?>
<?php  include $this->GetTemplate('comment');  ?>
<?php }   ?>
</div>