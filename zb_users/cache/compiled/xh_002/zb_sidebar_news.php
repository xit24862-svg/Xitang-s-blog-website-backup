<?php  /* @formatter:off */  ?><?php  /* 侧栏最新文章（自己实现） */  ?>
<div class="widget">
    <h3><?php  echo xh_002_msg('tm_news');  ?></h3>
    <ul class="recent-posts-list">
<?php  // 原生php
    $article_news = xh_002_get_news($num = 10);
    $article_new_html = '';
    foreach ($article_news as $article_new) {
        $article_new_title = $article_new->Title;
        $article_new_url = $article_new->Url;

        //$article_new_intro = xh_002_get_article_intro($article_new,10);
        $article_new_img = xh_002_get_article_img($article_new);
        $article_new_time = $article_new->PostTime;
        $article_new_time = date('Y-m-d H:i:s', $article_new_time); # 格式化时间

        # ✅✅✅✅✅✅✅✅✅✅✅✅✅✅✅✅✅✅ 输出内容
        $article_new_html = $article_new_html .'
        <li>
            <a href="'.$article_new_url.'" target="_blank">
                <img src="'.$article_new_img.'" alt="'.$article_new_title.'">
                <div class="wz">
                    <h4>'.$article_new_title.'</h4>
                    <p>'.$article_new_time.'</p>
                </div>
            </a>
        </li>
        ';
        /*
        <li>
            <a href="/symptom/2246.html" target="_blank">
                <img src="https://images.quitsmoking7.com/zb_users/upload/2025/10/202510251761327919383832.jpg" alt="What to Expect When Quitting Smoking: A Comprehensive Guide">
                <div class="wz">
                    <h4>What to Expect When Quitting Smoking: A Comprehensive Guide</h4>
                    <p>November 1, 2025</p>
                </div>
            </a>
        </li>
        */
        //break; // 只显示一条数据，如果要显示多条，去掉这行代码即可。
    }
    echo $article_new_html;

 ?>
    </ul>
</div>