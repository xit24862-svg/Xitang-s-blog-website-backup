<?php  /* @formatter:off */  ?><?php  /* 页面内容 */  ?>
<main class="main">
    <div class="container">
        <div class="breadcrumb">
            <a href="<?php  echo $host;  ?>"><?php  echo xh_002_msg('tm_home');  ?></a>&nbsp;&gt;&nbsp;
            <span><?php  echo $article->Title;  ?></span>
        </div>
        <div class="content-wrapper">
            <article class="main-content article-content">
                <div class="article-header">
                    <h1><?php  echo $article->Title;  ?></h1>

                    <div class="article-meta">
                        <div class="meta-info">

                            <span class="date"><i class="iconfont icon-shijian"></i><?php  echo $article->Time("PostTime","Y-m-d H:i:s");  ?></span>
                            <span class="read-time"><i class="iconfont icon-chakan"></i><?php  echo $article->ViewNums;  ?></span>
                        </div>
                    </div>
                </div>


                <div class="article-body">
                    <?php  echo $article->Content;  ?>
                </div>

                <?php if (!$article->IsLock) { ?>
                <div class="article-comments">
                    <?php  include $this->GetTemplate('comments');  ?>
                </div>
                <?php } ?>

            </article>

            <aside class="sidebar">
                <?php  include $this->GetTemplate('zb_sidebar_news');  ?><?php  /* 侧栏最新文章（自己实现） */  ?>
                <?php  include $this->GetTemplate('zb_sidebar_tags');  ?><?php  /* 侧栏热门标签文章（自己实现） */  ?>
                <?php  include $this->GetTemplate('zb_sidebar_fenlei');  ?><?php  /* 侧栏分类（自己实现） */  ?>
            </aside>
        </div>
    </div>
</main>
