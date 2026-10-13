<?php  /* Template Name:主题自主SEO方案标题模块 * Template Type: none */  ?>
<?php if ($type=='index') { ?>
<title><?php if ($zbp->Config('erx_Glass_p')->titleset) { ?><?php  echo $zbp->Config('erx_Glass_p')->title;  ?><?php if ($page>'1') { ?><?php  echo erx_Glass_p_seotcer();  ?>第<?php  echo $page;  ?>页<?php } ?><?php }else{  ?><?php  echo $name;  ?><?php if ($page>'1') { ?><?php  echo erx_Glass_p_seotcer();  ?>第<?php  echo $page;  ?>页<?php } ?><?php  echo erx_Glass_p_seotcer();  ?><?php  echo $subname;  ?><?php } ?></title>
<meta name="keywords" content="<?php  echo $zbp->Config('erx_Glass_p')->keywords;  ?>">
<meta name="description" content="<?php  echo $zbp->Config('erx_Glass_p')->description;  ?>">
<?php }elseif($type=='article') {  ?>
<title><?php if ($article->Metas->seotitle) { ?><?php  echo $article->Metas->seotitle;  ?><?php }else{  ?><?php  echo $title;  ?><?php if (!$zbp->Config('erx_Glass_p')->nocate) { ?><?php  echo erx_Glass_p_seotcer();  ?><?php  echo $article->Category->Name;  ?><?php } ?><?php  echo erx_Glass_p_seotcer();  ?><?php  echo $name;  ?><?php } ?></title>
<meta name="keywords" content="<?php if ($article->Metas->keywords) { ?><?php  echo $article->Metas->keywords;  ?><?php }else{  ?><?php  foreach ( $article->Tags as $tag) { ?><?php  echo $tag->Name;  ?>,<?php }   ?><?php  echo $article->Category->Name;  ?><?php } ?>">
<?php $description = preg_replace('/[\r\n\s)]|(\s|\&nbsp\;|　|\xc2\xa0)+/', ' ', trim(SubStrUTF8(FormatString($article->Intro,'[nohtml]'),100)).'...');if($description=='...'){$description = preg_replace('/[\r\n\s)]|(\s|\&nbsp\;|　|\xc2\xa0)+/', ' ', trim(SubStrUTF8(FormatString($article->Content,'[nohtml]'),100)).'...');} ?>
<meta name="description" content="<?php if ($article->Metas->description) { ?><?php  echo $article->Metas->description;  ?><?php }else{  ?><?php  echo $description;  ?><?php } ?>">
<?php }elseif($type=='page') {  ?>
<title><?php if ($article->Metas->seotitle) { ?><?php  echo $article->Metas->seotitle;  ?><?php }else{  ?><?php  echo $title;  ?><?php  echo erx_Glass_p_seotcer();  ?><?php  echo $name;  ?><?php } ?></title>
<meta name="keywords" content="<?php if ($article->Metas->keywords) { ?><?php  echo $article->Metas->keywords;  ?><?php }else{  ?><?php  echo $title;  ?>,<?php  echo $name;  ?><?php } ?>">
<?php $description = preg_replace('/[\r\n\s)]|(\s|\&nbsp\;|　|\xc2\xa0)+/', ' ', trim(SubStrUTF8(FormatString($article->Content,'[nohtml]'),100)).'...'); ?>
<meta name="description" content="<?php if ($article->Metas->description) { ?><?php  echo $article->Metas->description;  ?><?php }else{  ?><?php  echo $description;  ?><?php } ?>">
<?php }elseif($type=='category') {  ?>
<title><?php if ($category->Metas->seotitle) { ?><?php  echo $category->Metas->seotitle;  ?><?php }else{  ?><?php  echo $title;  ?><?php  echo erx_Glass_p_seotcer();  ?><?php  echo $name;  ?><?php } ?></title>
<meta name="keywords" content="<?php if ($category->Metas->keywords) { ?><?php  echo $category->Metas->keywords;  ?><?php }else{  ?><?php  echo $title;  ?>,<?php  echo $name;  ?><?php } ?>">
<meta name="description" content="<?php  echo $category->Intro;  ?>">
<?php }elseif($type=='tag') {  ?>
<title><?php  echo $title;  ?><?php  echo erx_Glass_p_seotcer();  ?><?php  echo $name;  ?></title>
<meta name="keywords" content="<?php  echo $tag->Name;  ?><?php if ($tag->Alias) { ?>,<?php  echo $tag->Alias;  ?><?php } ?>">
<meta name="description" content="<?php  echo $tag->Intro;  ?>">
<?php }elseif($type=='author') {  ?>
<title><?php  echo $title;  ?><?php  echo erx_Glass_p_seotcer();  ?><?php  echo $name;  ?></title>
<meta name="keywords" content="<?php  echo $author->Name;  ?><?php if ($author->Alias) { ?>,<?php  echo $author->Alias;  ?><?php } ?>">
<meta name="description" content="<?php  echo preg_replace('/[\r\n\s]+/', ' ', trim(FormatString($author->Intro,'[nohtml]')));  ?>">
<?php }else{  ?>
<title><?php  echo $title;  ?><?php  echo erx_Glass_p_seotcer();  ?><?php  echo $name;  ?></title>
<meta name="keywords" content="<?php  echo $title;  ?>">
<meta name="description" content="<?php  echo $title;  ?>">
<?php } ?>
<?php if ($zbp->Config('erx_Glass_p')->metaog) { ?>
<meta property="og:type" content="<?php  echo $type;  ?>">
<meta property="og:url" content="<?php  echo $zbp->fullcurrenturl;  ?>">
<meta property="og:image" content="<?php  echo $host;  ?>zb_users/theme/<?php  echo $theme;  ?>/images/<?php  echo erx_Glass_p_exImg('logo.png', 'erxlogo.png');  ?>">
<meta property="og:title" content="<?php if ($type=='index') { ?><?php  echo $name;  ?><?php }else{  ?><?php  echo $title;  ?><?php } ?>">
<meta property="og:description" content="<?php if ($type=='article' || $type=='page') { ?><?php if ($article->Metas->description) { ?><?php  echo $article->Metas->description;  ?><?php }else{  ?><?php  echo $description;  ?><?php } ?><?php }elseif($type=='category') {  ?><?php  echo $category->Intro;  ?><?php }elseif($type=='tag') {  ?><?php  echo $tag->Intro;  ?><?php }elseif($type=='author') {  ?><?php  echo preg_replace('/[\r\n\s]+/', ' ', trim(FormatString($author->Intro,'[nohtml]')));  ?><?php }else{  ?><?php  echo $zbp->Config('erx_Glass_p')->description;  ?><?php } ?>">
<?php } ?>
<?php if ($zbp->Config('erx_Glass_p')->canonical) { ?>
<link rel="canonical" href="<?php  echo $zbp->fullcurrenturl;  ?>">
<?php } ?>