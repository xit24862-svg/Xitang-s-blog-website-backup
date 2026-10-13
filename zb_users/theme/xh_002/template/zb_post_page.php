{* @formatter:off *}{* 页面内容 *}
<main class="main">
    <div class="container">
        <div class="breadcrumb">
            <a href="{$host}">{xh_002_msg('tm_home')}</a>&nbsp;&gt;&nbsp;
            <span>{$article.Title}</span>
        </div>
        <div class="content-wrapper">
            <article class="main-content article-content">
                <div class="article-header">
                    <h1>{$article.Title}</h1>

                    <div class="article-meta">
                        <div class="meta-info">

                            <span class="date"><i class="iconfont icon-shijian"></i>{$article.Time("PostTime","Y-m-d H:i:s")}</span>
                            <span class="read-time"><i class="iconfont icon-chakan"></i>{$article.ViewNums}</span>
                        </div>
                    </div>
                </div>


                <div class="article-body">
                    {$article.Content}
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
