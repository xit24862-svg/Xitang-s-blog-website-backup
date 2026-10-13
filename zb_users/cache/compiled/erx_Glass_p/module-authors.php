<?php  foreach ( $authors as $author) { ?>
<li><a title="<?php  echo $author->StaticName;  ?>" href="<?php  echo $author->Url;  ?>"><?php  echo $author->StaticName;  ?><span class="article-nums"> (<?php  echo $author->Articles;  ?>)</span></a></li>
<?php }   ?>
