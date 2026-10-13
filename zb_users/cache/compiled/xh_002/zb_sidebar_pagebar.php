<?php  /* @formatter:off */  ?><?php  /* Template Name:分页（自己实现）*/  ?>
<?php  /* &nbsp;<b>1</b>&nbsp;<a href="/method/index_2.html">2</a>&nbsp;<a href="/method/index_3.html">3</a>&nbsp;<a href="/method/index_4.html">4</a>&nbsp;<a href="/method/index_5.html">5</a>&nbsp;<a href="/method/index_6.html">6</a>&nbsp;<a href="/method/index_7.html">7</a>&nbsp;<a href="/method/index_8.html">8</a>&nbsp;<a href="/method/index_9.html">9</a>&nbsp;<a href="/method/index_10.html">10</a>&nbsp;<a href="/method/index_2.html">下一页</a>&nbsp;<a href="/method/index_29.html">尾页</a>*/  ?>
<?php if ($pagebar) { ?>
    <?php  foreach ( $pagebar->buttons as $k=>$v) { ?>
        <?php if ($pagebar->isFullLink==false && $pagebar->PageNow==$k) { ?>
             <b><?php  echo $k;  ?></b>&nbsp;
        <?php }else{  ?>
            <a title="<?php  echo $k;  ?>" href="<?php  echo $v;  ?>"><?php  echo $k;  ?></a>&nbsp;
        <?php } ?>
    <?php }   ?>
<?php } ?>