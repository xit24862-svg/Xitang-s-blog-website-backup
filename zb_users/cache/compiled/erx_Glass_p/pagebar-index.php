<?php if ($pagebar) { ?>
<?php  foreach ( $pagebar->buttons as $k=>$v) { ?>
  <?php if ($pagebar->PageNow+1==$k) { ?>
    <a href="<?php  echo $v;  ?>" class="erx-m-bg more">下一页</a>
  <?php } ?>
<?php }   ?>
<?php } ?>