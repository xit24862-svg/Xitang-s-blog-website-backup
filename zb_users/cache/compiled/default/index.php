<?php  /* Template Name:首页及列表页 */  ?>
<!DOCTYPE html>
<html lang="<?php  echo $lang['lang_bcp47'];  ?>">

<head>
  <?php  include $this->GetTemplate('header');  ?>
</head>

<body class="multi <?php  echo $type;  ?>">
  <div id="divAll">
    <div id="divPage">
      <div id="divMiddle">
        <div id="divTop">
          <h1 id="BlogTitle"><a href="<?php  echo $host;  ?>"><?php  echo $name;  ?></a></h1>
          <h2 id="BlogSubTitle"><?php  echo $subname;  ?></h2>
        </div>
        <div id="divNavBar">
          <ul>
            <?php  if(isset($modules['navbar'])){echo $modules['navbar']->Content;}  ?>
          </ul>
        </div>
        <div id="divMain">
          <?php  foreach ( $articles as $article) { ?>

          <?php if ($article->TopType) { ?>
          <?php  include $this->GetTemplate('post-istop');  ?>
          <?php }else{  ?>
          <?php  include $this->GetTemplate('post-multi');  ?>
          <?php } ?>

          <?php }   ?>
          <div class="pagebar"><?php  include $this->GetTemplate('pagebar');  ?></div>
        </div>
        <div id="divSidebar">
          <?php  include $this->GetTemplate('sidebar');  ?>
        </div>
        <?php  include $this->GetTemplate('footer');  ?>
      </div>
      <div class="clear"></div>
    </div>
    <div class="clear"></div>
  </div>
</body>

</html>