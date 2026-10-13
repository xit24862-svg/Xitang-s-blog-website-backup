{* @formatter:off *}{* 侧栏tags（自己实现） *}
<div class="widget">
    <h3>{xh_002_msg('tm_tags')}</h3>
    <ul class="tag-cloud">
        {php}<?php // 原生php
        echo xh_002_get_tags();
        ?>{/php}
    </ul>
</div>