{* @formatter:off *}{* 网站首页 *}
<main class="main">
    <div class="container">
        <div class="content-wrapper">
            <section class="main-content">
                <div class="recent-posts">
                    <div class="post-list">
                        {foreach $articles as $article}
                        <article class="post-item index-item">
                            <div class="post-item-image">
                                <img src="{xh_002_get_article_img($article)}" alt="{$article.Title}">
                            </div>
                            <div class="post-item-content">
                                <h4><a href="{$article.Url}">{$article.Title}</a></h4>
                                <p>{xh_002_get_article_intro($article)}</p>
                                <div class="post-meta">
                                    <span class="author"><i class="iconfont icon-fenlei"></i>{$article.Author.StaticName}</span>
                                    <span class="category"><a href="{$article.Category.Url}">{$article.Category.Name}</a></span>
                                    <span class="date"><i class="iconfont icon-shijian"></i>{$article.Time("PostTime","Y-m-d H:i:s")}</span>
                                </div>
                            </div>
                        </article>
                        {/foreach}
                    </div>
                </div>
            </section>
            <aside class="sidebar">
                {template:zb_sidebar_description}{* 侧栏站点描述（自己实现） *}
                {template:zb_sidebar_fenlei}{* 侧栏分类（自己实现） *}
                {template:zb_sidebar_news}{* 侧栏最新文章（自己实现） *}
                {template:zb_sidebar_tags}{* 侧栏热门标签文章（自己实现） *}
            </aside>
        </div>
    </div>
</main>
