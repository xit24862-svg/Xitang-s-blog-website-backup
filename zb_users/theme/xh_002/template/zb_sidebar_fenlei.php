{* @formatter:off *}{* 侧栏分类（自己实现） *}
<div class="widget">
    <h3>{xh_002_msg('tm_fenlei')}</h3>
    <ul class="category-list">
        {php}<?php // 原生php
        echo xh_002_get_fenlei();
        ?>{/php}
    </ul>
</div>