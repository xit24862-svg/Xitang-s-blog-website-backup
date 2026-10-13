<?php  /* Template Name:搜索页模板 * Template Type:search */  ?>
<!DOCTYPE html>
<html>
<head>
    <?php  include $this->GetTemplate('header');  ?>
</head>
<body>
<?php  include $this->GetTemplate('top');  ?>
<div class="weizhi">
    <div class="box">
        <i class="iconfont icon-shouye1"></i><a href="<?php  echo $host;  ?>"><?php  echo $lang['msg']['top_index'];  ?></a> &gt; <b>"<?php  echo GetVars('q');  ?>"</b>搜索结果
    </div>
</div>
<main>
    <div class="box">
        <div class="main-left">

            <div class="index-list">
                <div class="index-list-bt">
                    <h2>搜索结果如下：</h2>
                </div>
                <?php  foreach ( $articles as $article) { ?>
                <div class="index-list-li<?php if (xh_one_xh_img($article)== '') { ?> noimg<?php } ?>">
                    <?php if (xh_one_xh_img($article) != '') { ?>
                    <div class="list-li-img">
                        <a href="<?php  echo $article->Url;  ?>">
                            <img src="<?php  echo xh_one_xh_img($article);  ?>" alt="">
                        </a>
                    </div>
                    <?php } ?>

                    <div class="list-li-wen">
                        <div class="list-li-wen-tit">
                            <a href="<?php  echo $article->Category->Url;  ?>" class="lm"><i></i><?php  echo $article->Category->Name;  ?></a><a href="<?php  echo $article->Url;  ?>" class="bt">
                                <h3><?php  echo $article->Title;  ?></h3>
                            </a>
                        </div>
                        <div class="list-li-wen-info">
                            <span><i class="iconfont icon-rili"></i><?php  echo $article->Time();  ?></span>
                            <span><i class="iconfont icon-yanjing"></i><?php  echo $lang['xh_one']['view'];  ?>（<?php  echo $article->ViewNums;  ?>）</span>
                            <span><i class="iconfont icon-taolunqu"></i><?php  echo $lang['msg']['comment'];  ?>（<a href="<?php  echo $article->Url;  ?>#pl-list"><?php  echo $article->CommNums;  ?></a>）</span>
                        </div>
                        <div class="list-li-wen-con">
                            <p><?php  echo $article->Intro;  ?>
                            </p>


                        </div>
                    </div>
                </div>
                <?php }   ?>

                <div class="index-list-yema yema">
                    <?php  include $this->GetTemplate('pagebar');  ?>
                </div>
            </div>
        </div>

        <div class="main-right">
            <?php  include $this->GetTemplate('sidebar4');  ?>
        </div>
    </div>
</main>
<?php  include $this->GetTemplate('footer');  ?>
</body>
</html>