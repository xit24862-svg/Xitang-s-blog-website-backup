{* @formatter:off *}{* 站点描述（自己实现） *}
{php}<?php // 原生php
global $zbp;
$jieshao_img = $zbp->Config('xh_002')->jieshao_img ? $zbp->Config('xh_002')->jieshao_img: $zbp->host . 'zb_users/theme/xh_002/style/logo_baidu.png';
$jieshao_msg = $zbp->Config('xh_002')->jieshao_msg ?$zbp->Config('xh_002')->jieshao_msg: '';
?>{/php}
<div class="widget">
    <h3>{xh_002_msg('tm_jieshao')}</h3>
    <img src="{$jieshao_img}" style="width: 100%;padding: 0 0%;" title="{$name}"/>
    <p style="word-break:normal">{$jieshao_msg}</p>
</div>