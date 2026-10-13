<?php  /* Template Name:单页模板 */  ?>
		<div class="erx-m-bot erx-m-bg erx-current">
			<a href="<?php  echo $host;  ?>">首页</a><a href="<?php  echo $article->Url;  ?>"><?php  echo $article->Title;  ?></a>
		</div>
		<div class="erx-flex erx-m-bot erx-content">
			<main class="erx-main">
				<article class="erx-m-bot erx-m-bg erx-article erx-page">
					<h1><?php  echo $article->Title;  ?></h1>
					<section class="con">
<?php  echo $article->Content;  ?>
					</section>
				</article>
<?php if (!$article->IsLock) { ?>
<?php  include $this->GetTemplate('comments');  ?>
<?php } ?>
			</main>
		</div>