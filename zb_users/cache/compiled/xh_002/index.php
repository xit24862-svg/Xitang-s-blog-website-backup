<?php  /* @formatter:off */  ?><?php  /* 列表页面 */  ?>
<?php  /* 『列表页面』入口 */  ?>
<?php  include $this->GetTemplate('zb_commen_header');  ?><?php  /* 头部设置 */  ?>

<body>

<?php  include $this->GetTemplate('zb_commen_top');  ?><?php  /* 网站顶部导航 */  ?>

<?php  /* 『列表页面』开始 */  ?>

<?php if ($type=='index'&&$page=='1') { ?>
    <?php  include $this->GetTemplate('zb_list_index');  ?><?php  /* 网站首页 */  ?>
<?php }elseif($type=='category') {  ?>
    <?php  include $this->GetTemplate('zb_list_category');  ?><?php  /* 网站分页页面 */  ?>
<?php }elseif($type=='tag') {  ?>
    <?php  include $this->GetTemplate('zb_list_tag');  ?><?php  /* 网站标签页面 */  ?>
<?php  /* elseif $type=='author' */  ?>
    <?php  /* template:zb_list_author */  ?><?php  /* 网站作者页面 */  ?>
{* else* }
<?php  /* template:zb_list_list */  ?><?php  /* 网站其他列表页面 */  ?>
<?php } ?>

<?php  /* 『列表页面』结束 */  ?>

<?php  include $this->GetTemplate('zb_commen_footer');  ?><?php  /* 网站底部导航 */  ?>

</body>
</html>