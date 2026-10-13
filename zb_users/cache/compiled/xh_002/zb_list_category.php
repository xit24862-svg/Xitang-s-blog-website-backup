<?php  /* @formatter:off */  ?><?php  /* 分类列表 */  ?>
<main class="main">
    <div class="container">
        <div class="breadcrumb">
            <a href="<?php  echo $host;  ?>"><?php  echo xh_002_msg('tm_home');  ?></a>&nbsp;&gt;&nbsp;<a href="<?php  echo $category->Url;  ?>" target="_blank"><?php  echo $category->Name;  ?></a>
        </div>
        <div class="content-wrapper">

            <section class="main-content">
                <div class="articles-list">
                    <?php  foreach ( $articles as $article) { ?>
                    <article class="post-item">
                        <div class="post-item-image">
                            <img src="<?php  echo xh_002_get_article_img($article);  ?>" alt="<?php  echo $article->Title;  ?>">
                        </div>
                        <div class="post-item-content">
                            <h4><a href="<?php  echo $article->Url;  ?>"><?php  echo $article->Title;  ?></a></h4>
                            <div class="category"><a href="<?php  echo $category->Url;  ?>"><?php  echo $category->Name;  ?></a></div>
                            <p><?php  echo xh_002_get_article_intro($article);  ?></p>
                            <div class="post-meta">
                                <span class="author"><i class="iconfont icon-fenlei"></i><?php  echo $article->Author->StaticName;  ?></span>
                                <span class="date"><i class="iconfont icon-shijian"></i><?php  echo $article->Time("PostTime","Y-m-d H:i:s");  ?></span>
                                <span class="read-time"><i class="iconfont icon-chakan"></i><?php  echo $article->ViewNums;  ?></span>
                            </div>
                        </div>
                    </article>
                    <?php }   ?>
                </div>
                <div class="pagination">
                    <?php  include $this->GetTemplate('zb_sidebar_pagebar');  ?>
                </div>
            </section>
            <aside class="sidebar">
                <?php  include $this->GetTemplate('zb_sidebar_news');  ?><?php  /* 侧栏最新文章（自己实现） */  ?>
                <?php  include $this->GetTemplate('zb_sidebar_tags');  ?><?php  /* 侧栏热门标签文章（自己实现） */  ?>
                <?php  include $this->GetTemplate('zb_sidebar_fenlei');  ?><?php  /* 侧栏分类（自己实现） */  ?>
            </aside>
        </div>
    </div>
</main>
