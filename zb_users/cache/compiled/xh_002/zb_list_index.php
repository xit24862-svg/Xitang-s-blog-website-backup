<?php  /* @formatter:off */  ?><?php  /* 网站首页 */  ?>
<main class="main">
    <div class="container">
        <div class="content-wrapper">
            <section class="main-content">
                <div class="recent-posts">
                    <div class="post-list">
                        <?php  foreach ( $articles as $article) { ?>
                        <article class="post-item index-item">
                            <div class="post-item-image">
                                <img src="<?php  echo xh_002_get_article_img($article);  ?>" alt="<?php  echo $article->Title;  ?>">
                            </div>
                            <div class="post-item-content">
                                <h4><a href="<?php  echo $article->Url;  ?>"><?php  echo $article->Title;  ?></a></h4>
                                <p><?php  echo xh_002_get_article_intro($article);  ?></p>
                                <div class="post-meta">
                                    <span class="author"><i class="iconfont icon-fenlei"></i><?php  echo $article->Author->StaticName;  ?></span>
                                    <span class="category"><a href="<?php  echo $article->Category->Url;  ?>"><?php  echo $article->Category->Name;  ?></a></span>
                                    <span class="date"><i class="iconfont icon-shijian"></i><?php  echo $article->Time("PostTime","Y-m-d H:i:s");  ?></span>
                                </div>
                            </div>
                        </article>
                        <?php }   ?>
                    </div>
                </div>
            </section>
            <aside class="sidebar">
                <?php  include $this->GetTemplate('zb_sidebar_description');  ?><?php  /* 侧栏站点描述（自己实现） */  ?>
                <?php  include $this->GetTemplate('zb_sidebar_fenlei');  ?><?php  /* 侧栏分类（自己实现） */  ?>
                <?php  include $this->GetTemplate('zb_sidebar_news');  ?><?php  /* 侧栏最新文章（自己实现） */  ?>
                <?php  include $this->GetTemplate('zb_sidebar_tags');  ?><?php  /* 侧栏热门标签文章（自己实现） */  ?>
            </aside>
        </div>
    </div>
</main>
