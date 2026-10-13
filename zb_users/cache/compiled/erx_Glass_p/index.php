<?php  /* Template Name:首页列表模板 */  ?>
<?php  include $this->GetTemplate('header');  ?>
		<div class="erx-flex erx-m-bot erx-content">
			<aside class="erx-sidebar">
<?php if ($type=='index') { ?>
<?php  include $this->GetTemplate('sidebar');  ?>
<?php }else{  ?>
<?php  include $this->GetTemplate('sidebar2');  ?>
<?php } ?>
			</aside>
			<main class="erx-main">
				<div class="erx-item-wrap">
					<div class="erx-flex erx-m-tit"><h3><?php if ($type=='index') { ?>最新发布<?php }else{  ?><?php  echo $title;  ?><?php } ?></h3><?php  include $this->GetTemplate('pagebar-index');  ?></div>
					<ul>
<?php if ($articles) { ?>
<?php  foreach ( $articles as $article) { ?>
						<li class="erx-m-bot erx-m-bg item<?php if ($article->IsTop) { ?> istop<?php } ?>">
							<div class="a"><a href="<?php  echo $article->Url;  ?>" target="_blank" class="main"><?php  echo $article->Title;  ?></a></div>
							<div class="erx-flex c"><?php $description = preg_replace('/[\r\n\s)]|(\s|\&nbsp\;|　|\xc2\xa0)+/', ' ', trim(SubStrUTF8(FormatString($article->Intro,'[nohtml]'),150)));if($description=='...'){$description = preg_replace('/[\r\n\s)]|(\s|\&nbsp\;|　|\xc2\xa0)+/', ' ', trim(SubStrUTF8(FormatString($article->Content,'[nohtml]'),150)));} ?><p class="t"><?php  echo $description;  ?></p><?php if (erx_Glass_p_Img($article)) { ?><p class="p"><a href="<?php  echo $article->Url;  ?>"><img src="<?php  echo erx_Glass_p_Img($article);  ?>" alt="<?php  echo $article->Title;  ?>"></a></p><?php } ?></div>
							<div class="i"><span class="cate"><a href="<?php  echo $article->Category->Url;  ?>"><?php  echo $article->Category->Name;  ?></a></span><span class="view" title="浏览"><?php  echo $article->ViewNums;  ?></span><span class="comm"><?php  echo $article->CommNums;  ?></span><span class="time"><?php  echo $article->Time('Y-m-d H:i:s');  ?></span><?php if (!erx_Glass_p_isMobile() && $zbp->CheckPlugin('ArticelEdit')) { ?><span class="dele"><?php  echo ArticelEdit_Diy($article->ID, 'list', '', '&#10005', 'dele');  ?></span><?php  echo ArticelEdit_Diy($article->ID, 'list', '', '[编辑]', 'edit');  ?><?php } ?></div>
						</li>
<?php }   ?>
<?php }else{  ?>
						<li class="nothing">暂无内容！</li>
<?php } ?>
					</ul>
					<div class="erx-pagebar"><?php  include $this->GetTemplate('pagebar');  ?></div>
				</div>
			</main>
		</div>
<?php  include $this->GetTemplate('footer');  ?>
