{* @formatter:off *}{* 文章内容 *}
<main class="main">
    <div class="container">
        <div class="breadcrumb">
            <a href="{$host}">{xh_002_msg('tm_home')}</a>&nbsp;&gt;&nbsp;<a href="{$article.Category.Url}">{$article.Category.Name}</a> &gt;
            <span>{$article.Title}</span>
        </div>
        <div class="content-wrapper">
            <article class="main-content article-content">
                <div class="article-header">
                    <h1>{$article.Title}</h1>

                    <div class="article-meta">
                        <div class="meta-info">
                            <span class="author"><i class="iconfont icon-fenlei"></i>{$article.Author.StaticName}</span>
                            <span class="category"><i class="iconfont icon-fenlei"></i><a href="{$article.Category.Url}">{$article.Category.Name}</a></span>
                            <span class="date"><i class="iconfont icon-shijian"></i>{$article.Time("PostTime","Y-m-d H:i:s")}</span>
                            <span class="read-time"><i class="iconfont icon-chakan"></i>{$article.ViewNums}</span>
                            <span class="comment"><i class="iconfont icon-chakan"></i>{$article.CommNums}</span>
                        </div>
                    </div>
                </div>


                <div class="article-body">
                    {$article.Content}
                </div>

                <div class="article-footer">
                    <div class="tags">
                        <span class="tag-label">{xh_002_msg('tm_taglist')}:</span>
                        {foreach $article.Tags as $tag}
                            <a href="{$tag.Url}">{$tag.Name}</a>
                        {/foreach}
                    </div>

                    <div class="article-navigation">
                        <div class="nav-previous">
                            <span class="nav-label">{xh_002_msg('tm_shang')}:</span>
                            {if $article.Prev}
                                <a href="{$article.Prev.Url}" target="_blank">{$article.Prev.Title}</a>
                            {else}
                                {xh_002_msg('tm_nomore')}
                            {/if}
                        </div>
                        <div class="nav-next">
                            <span class="nav-label">{xh_002_msg('tm_xia')}:</span>
                            {if $article.Next}
                                <a href="{$article.Next.Url}" target="_blank">{$article.Next.Title}</a>
                            {else}
                                {xh_002_msg('tm_nomore')}
                            {/if}
                        </div>
                    </div>
                </div>

                {if !$article.IsLock}
                <div class="article-comments">
                    {template:comments}
                </div>
                {/if}
            </article>

            <aside class="sidebar">
                {template:zb_sidebar_news}{* 侧栏最新文章（自己实现） *}
                {template:zb_sidebar_tags}{* 侧栏热门标签文章（自己实现） *}
                {template:zb_sidebar_fenlei}{* 侧栏分类（自己实现） *}
            </aside>
        </div>
    </div>
</main>
