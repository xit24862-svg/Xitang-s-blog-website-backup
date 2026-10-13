<?php  /* @formatter:off */  ?><?php  /* 所有评论模板 */  ?>
<?php if ($socialcomment) { ?>
<?php  echo $socialcomment;  ?>
<?php }else{  ?>

<?php if ($article->CommNums>0) { ?>
<ul class="msg msghead">
    <li class="tbname">评论列表</li>
</ul>
<?php } ?>

<label id="AjaxCommentBegin"></label>
<?php  foreach ( $comments as $key => $comment) { ?>
<?php  include $this->GetTemplate('comment');  ?>
<?php }   ?>

<div class="pagebar commentpagebar">
<?php  include $this->GetTemplate('pagebar');  ?>
</div>
<label id="AjaxCommentEnd"></label>

<?php  include $this->GetTemplate('commentpost');  ?>

<?php } ?>
