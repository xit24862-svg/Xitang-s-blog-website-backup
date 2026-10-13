<?php  /* @formatter:off */  ?><?php  /* 文章内容 */  ?>
<main class="main">
    <div class="container">
        <div class="breadcrumb">
            <a href="<?php  echo $host;  ?>"><?php  echo xh_002_msg('tm_home');  ?></a>&nbsp;&gt;&nbsp;<a href="<?php  echo $article->Category->Url;  ?>"><?php  echo $article->Category->Name;  ?></a> &gt;
            <span><?php  echo $article->Title;  ?></span>
        </div>
        <div class="content-wrapper">
            <article class="main-content article-content">
                <div class="article-header">
                    <h1><?php  echo $article->Title;  ?></h1>

                    <div class="article-meta">
                        <div class="meta-info">
                            <span class="author"><i class="iconfont icon-fenlei"></i><?php  echo $article->Author->StaticName;  ?></span>
                            <span class="category"><i class="iconfont icon-fenlei"></i><a href="<?php  echo $article->Category->Url;  ?>"><?php  echo $article->Category->Name;  ?></a></span>
                            <span class="date"><i class="iconfont icon-shijian"></i><?php  echo $article->Time("PostTime","Y-m-d H:i:s");  ?></span>
                            <span class="read-time"><i class="iconfont icon-chakan"></i><?php  echo $article->ViewNums;  ?></span>
                            <span class="comment"><i class="iconfont icon-chakan"></i><?php  echo $article->CommNums;  ?></span>
                        </div>
                    </div>
                </div>


                <div class="article-body">
                    <?php  echo $article->Content;  ?>
                </div>

                <div class="article-footer">
                    <div class="tags">
                        <span class="tag-label"><?php  echo xh_002_msg('tm_taglist');  ?>:</span>
                        <?php  foreach ( $article->Tags as $tag) { ?>
                            <a href="<?php  echo $tag->Url;  ?>"><?php  echo $tag->Name;  ?></a>
                        <?php }   ?>
                    </div>

                    <div class="article-navigation">
                        <div class="nav-previous">
                            <span class="nav-label"><?php  echo xh_002_msg('tm_shang');  ?>:</span>
                            <?php if ($article->Prev) { ?>
                                <a href="<?php  echo $article->Prev->Url;  ?>" target="_blank"><?php  echo $article->Prev->Title;  ?></a>
                            <?php }else{  ?>
                                <?php  echo xh_002_msg('tm_nomore');  ?>
                            <?php } ?>
                        </div>
                        <div class="nav-next">
                            <span class="nav-label"><?php  echo xh_002_msg('tm_xia');  ?>:</span>
                            <?php if ($article->Next) { ?>
                                <a href="<?php  echo $article->Next->Url;  ?>" target="_blank"><?php  echo $article->Next->Title;  ?></a>
                            <?php }else{  ?>
                                <?php  echo xh_002_msg('tm_nomore');  ?>
                            <?php } ?>
                        </div>
                    </div>
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
