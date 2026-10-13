<?php  /* Template Name:评论模块 */  ?>
<?php if ($socialcomment) { ?>
<?php  echo $socialcomment;  ?>
<?php }else{  ?>
<!--评论框-->
<?php  include $this->GetTemplate('commentpost');  ?>
<?php if ($article->CommNums>0) { ?>
<?php } ?>
<label id="AjaxCommentBegin"></label>
<!--评论输出-->
<?php  foreach ( $comments as $key => $comment) { ?>
<?php  include $this->GetTemplate('comment');  ?>
<?php }   ?>
<?php if ($pagebar) { ?>
<!--评论翻页条输出-->
<div class="erx-pagebar commentpagebar">
<?php  include $this->GetTemplate('pagebar');  ?>
</div>
<?php } ?>
<label id="AjaxCommentEnd"></label>
<?php } ?>