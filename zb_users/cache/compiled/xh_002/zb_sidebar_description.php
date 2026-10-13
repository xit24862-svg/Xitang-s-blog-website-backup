<?php  /* @formatter:off */  ?><?php  /* 站点描述（自己实现） */  ?>
<?php  // 原生php
global $zbp;
$jieshao_img = $zbp->Config('xh_002')->jieshao_img ? $zbp->Config('xh_002')->jieshao_img: $zbp->host . 'zb_users/theme/xh_002/style/logo_baidu.png';
$jieshao_msg = $zbp->Config('xh_002')->jieshao_msg ?$zbp->Config('xh_002')->jieshao_msg: '';
 ?>
<div class="widget">
    <h3><?php  echo xh_002_msg('tm_jieshao');  ?></h3>
    <img src="<?php  echo $jieshao_img;  ?>" style="width: 100%;padding: 0 0%;" title="<?php  echo $name;  ?>"/>
    <p style="word-break:normal"><?php  echo $jieshao_msg;  ?></p>
</div>