<?php die();//主题定制需求联系作者[www.yiwuku.com qq:77940140]?>{* Template Name:文章模板 *}
		<div class="erx-m-bot erx-m-bg erx-current"><a href="{$host}">首页</a>{if $article.Category.Parent}<a href="{$article.Category.Parent.Url}">{$article.Category.Parent.Name}</a>{/if}<a href="{$article.Category.Url}">{$article.Category.Name}</a><a href="{$article.Url}">{$article.Title}</a></div>
		<div class="s{$article.ID*$article.Category.ID}erx erx-flex erx-m-bot erx-content">
			<aside class="erx-sidebar">
{template:sidebar3}
			</aside>
			<main class="erx-main">
				<article class="erx erx-m-bot erx-m-bg erx-article">
					<h1>{$article.Title}</h1>
					<section class="erx-m-bot i">
						<span class="cate"><em>分类</em><a href="{$article.Category.Url}">{$article.Category.Name}</a></span><span class="time"><em>时间</em><i>{if erx_Glass_p_isMobile()}{$article.Time('m-d H:i')}{else}{$article.Time('Y-m-d H:i:s')}{/if}</i></span><span class="auth"><em>发布</em><a href="{$article.Author.Url}">{$article.Author.StaticName}</a></span><span class="view"><em>浏览</em><i>{$article.ViewNums}</i></span>
					</section>
					<section class="con erx-has-tip">
						<div class="intro"><strong>摘要：</strong>{php}$description = preg_replace('/[\r\n\s)]|(\s|\&nbsp\;|　|\xc2\xa0)+/', ' ', trim(SubStrUTF8(FormatString($article->Intro,'[nohtml]'),$zbp->Config('erx_Glass_p')->intro_count)).'...');if($description=='...'){$description = preg_replace('/[\r\n\s)]|(\s|\&nbsp\;|　|\xc2\xa0)+/', ' ', trim(SubStrUTF8(FormatString($article->Content,'[nohtml]'),180)).'...');}{/php}{$description}</div>
{$article.Content}
<p>{$zbp->Config('erx_Glass_p')->copytip}</p>
					</section>
{if $article.Tags}
					<section class="tags">
						{foreach $article.Tags as $tag}<a href="{$tag.Url}" target="_blank">{$tag.Name}</a>{/foreach}
					</section>
{/if}
					<section class="erx-flex p">
{if $article.Prev}
						<span class="prev"><a href="{$article.Prev.Url}" title="上一篇：{$article.Prev.Title}">{$article.Prev.Title}</a></span>
{/if}
{if $article.Next}
						<span class="next"><a href="{$article.Next.Url}" title="下一篇：{$article.Next.Title}">{$article.Next.Title}</a></span>
{/if}
					</section>
				</article>
{if !$article.IsLock}
{template:comments}
{/if}
			</main>
		</div>