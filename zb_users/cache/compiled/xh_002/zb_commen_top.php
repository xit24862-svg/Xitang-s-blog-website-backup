<?php  /* @formatter:off */  ?><?php  /* 网站顶部导航 */  ?>
<header class="header">
    <div class="container">
        <div class="header-content">
            <div class="logo">
                <h1><a href="<?php  echo $host;  ?>"><img src="<?php  echo xh_002_logo();  ?>" title="<?php  echo $name;  ?>" alt="<?php  echo $name;  ?>"></a></h1>
            </div>
            <nav class="nav">
                <ul class="nav-list">
                    <?php  echo xh_002_get_navbar();  ?>
                    <li><a href="<?php  echo $host;  ?>zj_pvp/" target="_blank">在线象棋</a></li>
                </ul>
                <div class="header-search">
                    <form class="search-form" name="searchform" method="post" action="<?php  echo $host;  ?>zb_system/cmd.php?act=search" target="_blank">
                        <input type="text" name="q"  size="11" placeholder="<?php  echo xh_002_msg('tm_search');  ?>" class="search-input">
                        <button type="submit" name="submit" class="search-button">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                        </button>
                    </form>
                </div>
                <div class="mobile-menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </nav>
        </div>
    </div>
</header>
