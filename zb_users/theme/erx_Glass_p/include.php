<?php
# erx_Glass_p erx@qq.com www.yiwuku.com
RegisterPlugin("erx_Glass_p","ActivePlugin_erx_Glass_p");
function ActivePlugin_erx_Glass_p() {
	Add_Filter_Plugin('Filter_Plugin_Admin_TopMenu','erx_Glass_p_AddMenu');
	Add_Filter_Plugin('Filter_Plugin_Edit_Response5','erx_Glass_p_ArticlePlus');
	Add_Filter_Plugin('Filter_Plugin_Category_Edit_Response','erx_Glass_p_CategorySeo');
}
function erx_Glass_p_AddMenu(&$m){
	global $zbp;
	array_unshift($m,MakeTopMenu("root",'主题配置',$zbp->host . "zb_users/theme/erx_Glass_p/main.php","","topmenu_erx_Glass_p", "icon-tools"));
}
function erx_Glass_p_exImg($upimg, $default){
	if(file_exists(__DIR__ . '/images/'.$upimg)){
		return $upimg;
	}else{
		return $default;
	}
}
function erx_Glass_p_seotcer(){
	global $zbp;
	$seotcer = $zbp->Config('erx_Glass_p')->seotcer;
	if($seotcer == ""){
		$seotcer = "-";
	}
	return $seotcer;
}
function erx_Glass_p_isMobile(){
    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        return false;
    }
    return strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false;
}
function erx_Glass_p_ArticlePlus(){
    global $zbp, $article;
	echo '<style>
.up-wrap{position:relative;}
.up-btn, .save-btn{position:absolute;top:0;right:0;color:#fff;background:#3a6ea5;padding:0 .5em;cursor:pointer;}
.save-btn{display:none;background:#696;}
</style>';
	echo '<div class="editmod"><table width="99%" class="table_striped table_hover"><tbody>
		<tr><td width="80" align="center"><b>SEO标题</b></td><td width="25%"><input type="text" name="meta_seotitle" value="'.htmlspecialchars($article->Metas->seotitle).'" autocomplete="off" style="width:100%" class="seotitle" placeholder="填写后将替换系统标题展示，可留空"></td><td width="80" align="center"><b>关键词</b></td><td width="20%"><input type="text" name="meta_keywords" value="'.htmlspecialchars($article->Metas->keywords).'" autocomplete="off" style="width:100%" class="keywords" placeholder="英文逗号分隔多个词，可留空"></td><td width="60" align="center"><b>描述</b></td><td><input type="text" name="meta_description" value="'.htmlspecialchars($article->Metas->description).'" autocomplete="off" style="width:100%" class="description" placeholder="建议不超过100字，可留空"></td></tr>
		</tbody></table></div>';
}
function erx_Glass_p_CategorySeo(){
	global $zbp, $cate;
	echo '<p><span class="title">SEO标题:</span><br>
	<input class="edit" size="60" name="meta_seotitle" type="text" value="'.htmlspecialchars($cate->Metas->seotitle).'" placeholder="填写后将替换系统标题展示，可留空"></p>';
	echo '<p><span class="title">关键词:</span><br>
	<input class="edit" size="60" name="meta_keywords" type="text" value="'.htmlspecialchars($cate->Metas->keywords).'" placeholder="英文逗号分隔多个词，可留空"></p>';
}
function InstallPlugin_erx_Glass_p(){
	global $zbp;
	if(!$zbp->HasConfig('erx_Glass_p')){
		$zbp->Config('erx_Glass_p')->logotype = 2;
		$zbp->Config('erx_Glass_p')->login_url = $zbp->host . 'zb_system/admin/index.php?act=login';
		$zbp->Config('erx_Glass_p')->fs1set = 1;
		$zbp->Config('erx_Glass_p')->fs1con = '<a href="'.$zbp->host.'" target="_blank"><img src="'.$zbp->host.'zb_users/theme/erx_Glass_p/images/erxfs.png" alt=""></a>';
		$zbp->Config('erx_Glass_p')->fs1con_mb = '<a href="'.$zbp->host.'" target="_blank"><img src="'.$zbp->host.'zb_users/theme/erx_Glass_p/images/erxfs_mb.gif" alt=""></a>';
		$zbp->Config('erx_Glass_p')->copytip = '<a href="'.$zbp->host.'">'.$zbp->name.'</a>版权声明：以上内容作者已申请原创保护，未经允许不得转载，侵权必究！授权事宜、对本内容有异议或投诉，敬请联系网站管理员，我们将尽快回复您，谢谢合作！';
		$zbp->Config('erx_Glass_p')->titleset = 0;
		$zbp->Config('erx_Glass_p')->title = '首页自定义标题';
		$zbp->Config('erx_Glass_p')->description = '网站首页描述';
		$zbp->Config('erx_Glass_p')->keywords = '网站首页关键词';
		$zbp->Config('erx_Glass_p')->nocate = 0;
		$zbp->Config('erx_Glass_p')->seotcer = '-';
		$zbp->Config('erx_Glass_p')->seotool = 0;
		$zbp->Config('erx_Glass_p')->metaog = 0;
		$zbp->Config('erx_Glass_p')->canonical = 0;
		$zbp->Config('erx_Glass_p')->setsave = 0;
		$zbp->SaveConfig('erx_Glass_p');
	}
}
function erx_Glass_p_AppInfo($name) {
	$app = new App;
	$app->LoadInfoByXml('theme', 'erx_Glass_p');
	return $app->$name;
}
function erx_Glass_p_Img($a, $w = 200){
    global $zbp;
	$pattern = "%<img[^>]*?src=[\'\"]((?:.)+?)[\'\"][^>]*?>%is";
	$content = $a->GetOriginal('Content');
	preg_match_all($pattern,$content,$matchContent);
	$thumb_set = $zbp->Config('erx_Glass_p')->thumb_set;
	if($a->Metas->mpic != ""){
		$temp = $a->Metas->mpic;
	}elseif(isset($matchContent[1][0]) && !$thumb_set){
		$temp = $matchContent[1][0];
	}elseif($a->ImageCount && $thumb_set){
		$temp = $a->Thumbs($w, 500, 1, 0)[0];
	}else{
		$temp = false;
	}
	return $temp;
}
function UninstallPlugin_erx_Glass_p(){
	global $zbp;
	if ($zbp->Config('erx_Glass_p')->setsave){
		$zbp->DelConfig('erx_Glass_p');
	}
}