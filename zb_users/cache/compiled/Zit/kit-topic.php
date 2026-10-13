<article id="topic"<?php if ($cfg->HideRand) { ?> class="hidem"<?php } ?>>
  <?php if ($type!=='index') { ?><nav id="path" class="kico-guide kico-gap"><a href="<?php  echo $host;  ?>"><?php  echo $msg->home;  ?></a> | <a><?php  echo $title;  ?></a></nav><?php } ?>
  <?php  $skip=array();  ?>
  <?php  foreach ( $articles as $v) { ?>
    <?php  $skip[]=$v->ID;  ?>
  <?php }   ?>
  <?php if (!$pagebar||$pagebar&&$pagebar->Count-count($skip)<1) { ?>
    <?php  $cfg->RandLog=false;  ?>
  <?php } ?>
  <?php  $where=array(array('not in','log_ID',$skip),array('=', 'log_Status', 0),array('=', 'log_IsTop', 0));  ?>
<?php if ($cfg->RandLog) { ?>
  <?php  $randstr=$zbp->db->type==='sqlite'?'RANDOM()':'RAND()';;  ?>
  <?php if ($type=='category') { ?><?php  $where[]=array('=','log_CateID',$category->ID);  ?><?php } ?>
  <?php  $randlogs=$zbp->GetArticleList('',$where,array($randstr),4);  ?>
  <ul>
  <?php  foreach ( $randlogs as $log) { ?>
    <li class="log">
      <a href="<?php  echo $log->Url;  ?>" title="<?php  echo $msg->view;  ?>《<?php  echo $log->Title;  ?>》<?php  echo $msg->details;  ?>">
        <img src="<?php if ($log->Cover) { ?><?php  echo $log->Cover;  ?><?php }else{  ?><?php  echo $host;  ?>zb_users/theme/Zit/style/bg.jpg<?php } ?>" alt="<?php  echo $log->Title;  ?>" class="cover<?php if (!$log->Cover) { ?> hue<?php } ?>">
        <span class="pane">
          <span class="zit"><?php if ($log->Tags) { ?><?php  echo $log->FirstTag->Name;  ?><?php }else{  ?><?php  echo $log->Category->Name;  ?><?php } ?></span>
          <b><?php  echo $log->Title;  ?></b>
          <span><small class="kico-eye"><dfn><?php  echo $msg->views;  ?></dfn><?php  echo $log->ViewNums;  ?></small> <small class="kico-ping"><dfn><?php  echo $msg->comments;  ?></dfn><?php  echo $log->CommNums;  ?></small>
          </span>
        </span>
      </a>
    </li>
  <?php }   ?>
  </ul>
<?php }else{  ?>
  <?php  $cmtids=json_decode(isset($modules['zit_cmtids'])?$modules['zit_cmtids']->Content:'',true);  ?>
  <?php if (trim($cfg->CmtIds,',')) { ?>
    <?php  $cmtids=explode(',',$cfg->CmtIds);  ?>
  <?php } ?>
<?php if ($cmtids) { ?>
  <?php  $cmtid=$cmtids[array_rand($cmtids,1)];  ?>
  <?php  $cmt=$zbp->GetCommentByID($cmtid);  ?>
  <?php if ($cmt->Post->Tags) { ?>
  <h4>
    <?php  foreach ( $cmt->Post->Tags as $tag) { ?>
    <a href="<?php  echo $tag->Url;  ?>" class="tag kico-hash"><?php  echo $tag->Name;  ?></a> 
    <?php }   ?>
    <?php  $tag=null;  ?>
  </h4>
  <?php } ?>
  <h2 class="kico-ping"><a href="<?php  echo $cmt->Post->Url;  ?>" title="<?php  echo $msg->view;  ?>《<?php  echo $cmt->Post->Title;  ?>》<?php  echo $msg->details;  ?>"><?php  echo SubStrUTF8(TransferHTML($cmt->Content,'[nohtml]'),40);  ?>...</a></h2>
  <p <?php if ($cfg->HideIntro) { ?> class="hidem"<?php } ?>><?php  echo SubStrUTF8(TransferHTML($cmt->Post->Content,'[nohtml]'),140);  ?>...</p>
  <small><?php if ($cmt->Post->CommNums>1) { ?><?php  echo $msg->other;  ?> <?php  echo $cmt->Post->CommNums-1;  ?> <?php  echo $msg->commented;  ?><?php }else{  ?><?php  echo $msg->expect;  ?><?php } ?></small>
  <a href="<?php  echo $cmt->Post->Url;  ?>" title="<?php  echo $msg->view;  ?>《<?php  echo $cmt->Post->Title;  ?>》<?php  echo $msg->details;  ?>" rel="nofollow" class="more"><?php  echo $msg->join;  ?><span class="zit"><?php  echo $cmt->Post->ViewNums;  ?><?php  echo $msg->guys;  ?></span><?php  echo $msg->crowds;  ?></a>
  <?php  $logs=null;  ?>
<?php }else{  ?>
  <h2><?php  echo $msg->welcome;  ?></h2>
  <small><?php  echo $msg->advice;  ?></small>
  <?php  $gbook=$zbp->GetPostByID(trim($cfg->GbookID));  ?>
  <a href="<?php  echo $gbook->Url;  ?>" rel="nofollow" class="more"><?php  echo $msg->message;  ?><span class="zit"><?php  echo $msg->sofa;  ?></span></a>
<?php } ?>
<?php } ?>
</article>