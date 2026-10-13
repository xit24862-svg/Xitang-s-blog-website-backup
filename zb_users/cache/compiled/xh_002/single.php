<?php  /* @formatter:off */  ?><?php  /* Template Name:内容页模板 */  ?>
<?php  include $this->GetTemplate('zb_commen_header');  ?><?php  /* 头部设置 */  ?>
<body>
<?php  include $this->GetTemplate('zb_commen_top');  ?><?php  /* 网站顶部导航 */  ?>
<?php  /* 『内容页面』开始 */  ?>
<?php if ($article->Type==ZC_POST_TYPE_ARTICLE) { ?>
    <?php  include $this->GetTemplate('zb_post_article');  ?>
<?php }else{  ?>
    <?php  include $this->GetTemplate('zb_post_page');  ?>
<?php } ?>
<?php  /* 『内容页面』结束 */  ?>
<?php  include $this->GetTemplate('zb_commen_footer');  ?><?php  /* 网站底部导航 */  ?>
</body>
</html>