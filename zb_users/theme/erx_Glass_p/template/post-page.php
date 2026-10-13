<?php die();//主题定制需求联系作者[www.yiwuku.com qq:77940140]?>{* Template Name:单页模板 *}
		<div class="erx-m-bot erx-m-bg erx-current">
			<a href="{$host}">首页</a><a href="{$article.Url}">{$article.Title}</a>
		</div>
		<div class="erx-flex erx-m-bot erx-content">
			<main class="erx-main">
				<article class="erx-m-bot erx-m-bg erx-article erx-page">
					<h1>{$article.Title}</h1>
					<section class="con">
{$article.Content}
					</section>
				</article>
{if !$article.IsLock}
{template:comments}
{/if}
			</main>
		</div>