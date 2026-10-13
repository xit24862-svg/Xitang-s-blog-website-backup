{* Template Name:搜索页模板 * Template Type:search *}
<!DOCTYPE html>
<html>
<head>
    {template:header}
</head>
<body>
{template:top}
<div class="weizhi">
    <div class="box">
        <i class="iconfont icon-shouye1"></i><a href="{$host}">{$lang['msg']['top_index']}</a> &gt; <b>"{GetVars('q')}"</b>搜索结果
    </div>
</div>
<main>
    <div class="box">
        <div class="main-left">

            <div class="index-list">
                <div class="index-list-bt">
                    <h2>搜索结果如下：</h2>
                </div>
                {foreach $articles as $article}
                <div class="index-list-li{if xh_one_xh_img($article)== ''} noimg{/if}">
                    {if xh_one_xh_img($article) != ''}
                    <div class="list-li-img">
                        <a href="{$article.Url}">
                            <img src="{xh_one_xh_img($article)}" alt="">
                        </a>
                    </div>
                    {/if}

                    <div class="list-li-wen">
                        <div class="list-li-wen-tit">
                            <a href="{$article.Category.Url}" class="lm"><i></i>{$article.Category.Name}</a><a href="{$article.Url}" class="bt">
                                <h3>{$article.Title}</h3>
                            </a>
                        </div>
                        <div class="list-li-wen-info">
                            <span><i class="iconfont icon-rili"></i>{$article.Time()}</span>
                            <span><i class="iconfont icon-yanjing"></i>{$lang['xh_one']['view']}（{$article.ViewNums}）</span>
                            <span><i class="iconfont icon-taolunqu"></i>{$lang['msg']['comment']}（<a href="{$article.Url}#pl-list">{$article.CommNums}</a>）</span>
                        </div>
                        <div class="list-li-wen-con">
                            <p>{$article.Intro}
                            </p>


                        </div>
                    </div>
                </div>
                {/foreach}

                <div class="index-list-yema yema">
                    {template:pagebar}
                </div>
            </div>
        </div>

        <div class="main-right">
            {template:sidebar4}
        </div>
    </div>
</main>
{template:footer}
</body>
</html>