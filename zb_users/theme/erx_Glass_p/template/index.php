<?php die();//主题定制需求联系作者[www.yiwuku.com qq:77940140]?>{* Template Name:首页列表模板 *}
{template:header}
		<div class="erx-flex erx-m-bot erx-content">
			<aside class="erx-sidebar">
{if $type=='index'}
{template:sidebar}
{else}
{template:sidebar2}
{/if}
			</aside>
			<main class="erx-main">
				<div class="erx-item-wrap">
					<div class="erx-flex erx-m-tit"><h3>{if $type=='index'}最新发布{else}{$title}{/if}</h3>{template:pagebar-index}</div>
					<ul>
{if $articles}
{foreach $articles as $article}
						<li class="erx-m-bot erx-m-bg item{if $article.IsTop} istop{/if}">
							<div class="a"><a href="{$article.Url}" target="_blank" class="main">{$article.Title}</a></div>
							<div class="erx-flex c">{php}$description = preg_replace('/[\r\n\s)]|(\s|\&nbsp\;|　|\xc2\xa0)+/', ' ', trim(SubStrUTF8(FormatString($article->Intro,'[nohtml]'),150)));if($description=='...'){$description = preg_replace('/[\r\n\s)]|(\s|\&nbsp\;|　|\xc2\xa0)+/', ' ', trim(SubStrUTF8(FormatString($article->Content,'[nohtml]'),150)));}{/php}<p class="t">{$description}</p>{if erx_Glass_p_Img($article)}<p class="p"><a href="{$article.Url}"><img src="{erx_Glass_p_Img($article)}" alt="{$article.Title}"></a></p>{/if}</div>
							<div class="i"><span class="cate"><a href="{$article.Category.Url}">{$article.Category.Name}</a></span><span class="view" title="浏览">{$article.ViewNums}</span><span class="comm">{$article.CommNums}</span><span class="time">{$article.Time('Y-m-d H:i:s')}</span>{if !erx_Glass_p_isMobile() && $zbp->CheckPlugin('ArticelEdit')}<span class="dele">{ArticelEdit_Diy($article.ID, 'list', '', '&#10005', 'dele')}</span>{ArticelEdit_Diy($article.ID, 'list', '', '[编辑]', 'edit')}{/if}</div>
						</li>
{/foreach}
{else}
						<li class="nothing">暂无内容！</li>
{/if}
					</ul>
					<div class="erx-pagebar">{template:pagebar}</div>
				</div>
			</main>
		</div>
{template:footer}
