<?php  /* Template Name:文章模板 */  ?>
		<div class="erx-m-bot erx-m-bg erx-current"><a href="<?php  echo $host;  ?>">首页</a><?php if ($article->Category->Parent) { ?><a href="<?php  echo $article->Category->Parent->Url;  ?>"><?php  echo $article->Category->Parent->Name;  ?></a><?php } ?><a href="<?php  echo $article->Category->Url;  ?>"><?php  echo $article->Category->Name;  ?></a><a href="<?php  echo $article->Url;  ?>"><?php  echo $article->Title;  ?></a></div>
		<div class="s<?php  echo $article->ID*$article->Category->ID;  ?>erx erx-flex erx-m-bot erx-content">
			<aside class="erx-sidebar">
<?php  include $this->GetTemplate('sidebar3');  ?>
			</aside>
			<main class="erx-main">
				<article class="erx erx-m-bot erx-m-bg erx-article">
					<h1><?php  echo $article->Title;  ?></h1>
					<section class="erx-m-bot i">
						<span class="cate"><em>分类</em><a href="<?php  echo $article->Category->Url;  ?>"><?php  echo $article->Category->Name;  ?></a></span><span class="time"><em>时间</em><i><?php if (erx_Glass_p_isMobile()) { ?><?php  echo $article->Time('m-d H:i');  ?><?php }else{  ?><?php  echo $article->Time('Y-m-d H:i:s');  ?><?php } ?></i></span><span class="auth"><em>发布</em><a href="<?php  echo $article->Author->Url;  ?>"><?php  echo $article->Author->StaticName;  ?></a></span><span class="view"><em>浏览</em><i><?php  echo $article->ViewNums;  ?></i></span>
					</section>
					<section class="con erx-has-tip">
						<div class="intro"><strong>摘要：</strong><?php $description = preg_replace('/[\r\n\s)]|(\s|\&nbsp\;|　|\xc2\xa0)+/', ' ', trim(SubStrUTF8(FormatString($article->Intro,'[nohtml]'),$zbp->Config('erx_Glass_p')->intro_count)).'...');if($description=='...'){$description = preg_replace('/[\r\n\s)]|(\s|\&nbsp\;|　|\xc2\xa0)+/', ' ', trim(SubStrUTF8(FormatString($article->Content,'[nohtml]'),180)).'...');} ?><?php  echo $description;  ?></div>
<?php  echo $article->Content;  ?>
<p><?php  echo $zbp->Config('erx_Glass_p')->copytip;  ?></p>
					</section>
<?php if ($article->Tags) { ?>
					<section class="tags">
						<?php  foreach ( $article->Tags as $tag) { ?><a href="<?php  echo $tag->Url;  ?>" target="_blank"><?php  echo $tag->Name;  ?></a><?php }   ?>
					</section>
<?php } ?>
					<section class="erx-flex p">
<?php if ($article->Prev) { ?>
						<span class="prev"><a href="<?php  echo $article->Prev->Url;  ?>" title="上一篇：<?php  echo $article->Prev->Title;  ?>"><?php  echo $article->Prev->Title;  ?></a></span>
<?php } ?>
<?php if ($article->Next) { ?>
						<span class="next"><a href="<?php  echo $article->Next->Url;  ?>" title="下一篇：<?php  echo $article->Next->Title;  ?>"><?php  echo $article->Next->Title;  ?></a></span>
<?php } ?>
					</section>
				</article>
<?php if (!$article->IsLock) { ?>
<?php  include $this->GetTemplate('comments');  ?>
<?php } ?>
			</main>
		</div>