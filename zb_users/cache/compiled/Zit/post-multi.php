<?php  $album=$cfg->ListAlbum&&$article->ImageCount>3;  ?>
<article class="log<?php if ($article->IsTop) { ?> pin<?php } ?><?php if ($album) { ?> album<?php }elseif($article->Cover) {  ?> poster<?php } ?>">
<?php if ($article->Cover) { ?>
  <figure>
  <?php if ($album) { ?>
    <span>
    <?php  foreach ( $article->AllImages as $k=>$v) { ?>
      <?php if ($k<4) { ?><img src="<?php  echo $v;  ?>" alt="<?php  echo $article->Title;  ?>" class="cover"><?php } ?>
    <?php }   ?>
    </span>
  <?php }else{  ?>
    <a href="<?php  echo $article->Url;  ?>"><img src="<?php  echo $article->Cover;  ?>" alt="<?php  echo $article->Title;  ?>" class="cover<?php if ($article->Cover===$host . 'zb_users/theme/Zit/style/bg.jpg') { ?> hue<?php } ?>"></a>
  <?php } ?>
  </figure>
<?php } ?>
  <section class="pane">
    <h4 class="zit"><?php if ($article->IsTop) { ?><b class="kico-flag"><?php  echo $msg->sticky;  ?></b> <?php } ?><a href="<?php  echo $article->Category->Url;  ?>" title="<?php  echo $article->Category->Name;  ?>"><?php  echo $article->Category->Name;  ?></a></h4>
    <h3><a href="<?php  echo $article->Url;  ?>" title="<?php  echo TransferHTML($article->Title,'[nohtml]');  ?>"><?php  echo $article->Title;  ?></a></h3>
    <h5><?php  include $this->GetTemplate('kit-loginfo');  ?></h5>
    <div><?php  echo $article->Intro;  ?></div>
    <?php if ($cfg->ListTags&&$article->TagsName&&!$album) { ?><div class="tags"><span class="tag kico-hash"><?php  echo str_replace(',','</span> <span class="tag kico-hash">',$article->TagsName);  ?></span></div><?php } ?>
  </section>
</article>