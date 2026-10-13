<?php
# erx_Glass_p erx@qq.com www.yiwuku.com
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$action='root';
if (!$zbp->CheckRights($action)) {$zbp->ShowError(6);die();}
if (!$zbp->CheckPlugin('erx_Glass_p')) {$zbp->ShowError(48);die();}
$blogtitle="Glass主题配置";
require $blogpath . 'zb_system/admin/admin_header.php';
require $blogpath . 'zb_system/admin/admin_top.php';
if(isset($_POST['Items'])){
    CheckIsRefererValid();
    foreach($_POST['Items'] as $key=>$val){
       $zbp->Config('erx_Glass_p')->$key = $val;
    }
    $zbp->SaveConfig('erx_Glass_p');
    $zbp->ShowHint('good');
}
?>
<link href="manage/erxset.css" rel="stylesheet">
<script src="manage/erxset.js"></script>
<div id="divMain">
	<div class="divHeader"><?php echo $blogtitle;?></div>
	<div class="SubMenu">
        <a href="main.php"><span class="m-left m-now">基本设置</span></a>
        <a href="<?php echo $bloghost; ?>zb_users/plugin/AppCentre/main.php?id=51277" target="_blank"><span class="m-left"><b style="color:#f50">有VIP版?</b></span></a>
        <a href="<?php echo $bloghost; ?>zb_users/plugin/AppCentre/main.php?auth=3ec7ee20-80f2-498a-a5dd-fda19b198194"><span class="m-left">作者作品</span></a>
        <a href="http://www.yiwuku.com/diy-zblog.html" target="_blank"><span class="m-left">定制服务</span></a>
        <a href="http://www.yiwuku.com/" target="_blank"><span class="m-right">联系作者</span></a>
    </div>
	<div id="divMain2">
        <fieldset class="erx-set-box">
            <legend>图片上传</legend>
            <ul class="erx-set-list">
                <li>
                    <div class="lti">上传网站LOGO图</div>
                    <div class="rco">
<form enctype="multipart/form-data" method="post" action="save.php?type=logo"><input name="logo.png" type="file"><input name="" type="Submit" class="button" value="上传"><span class="xtips">请上传png格式图片，尺寸适宜即可</span><span class="xtips-i"><?php if(!file_exists("images/logo.png")): ?>未上传<?php else: ?>当前(<?php echo round(filesize("images/logo.png")/1048576, 2); ?>MB)，<a href="images/logo.png" target="_blank">查看</a><?php endif; ?></span></form>
                    </div>
                </li>
                <li>
                    <div class="lti"><span>上传网页背景图</span></div>
                    <div class="rco">
<form enctype="multipart/form-data" method="post" action="save.php?type=bg"><input name="bg.jpg" type="file"><input name="" type="Submit" class="button" value="上传"><span class="xtips">请上传jpg格式图片，尺寸适宜即可</span><span class="xtips-i"><?php if(!file_exists("images/bg.jpg")): ?>未上传<?php else: ?>当前(<?php echo round(filesize("images/bg.jpg")/1048576, 2); ?>MB)，<a href="images/bg.jpg" target="_blank">查看</a><?php endif; ?></span></form>
                    </div>
                </li>
                <li>
                    <div class="lti"></div>
                    <div class="rco">
提示：浏览器和第三方加速平台均可能缓存图片，若上传后看到的仍是旧图片，可Ctrl+F5刷新或手动清除缓存
                    </div>
                </li>
            </ul>
        </fieldset>
        <fieldset class="erx-set-box">
            <legend>参数设定</legend>
            <form action="<?php echo BuildSafeURL("main.php"); ?>" method="post">
            <ul class="erx-set-list">
                <li>
                    <div class="lti"><span>Logo设置</span></div>
                    <div class="rco">
                        <span class="xytab-tit">
                            类型：<label for="logotype1"><input type="radio" id="logotype1" name="Items[logotype]" value="1" <?php echo ($zbp->Config('erx_Glass_p')->logotype=='1')?' checked="checked"':''; ?>> 文字</label>&emsp;
                            <label for="logotype2"><input type="radio" id="logotype2" name="Items[logotype]" value="2" <?php echo ($zbp->Config('erx_Glass_p')->logotype=='2')?' checked="checked"':''; ?>> 图片</label>
                        </span>
                        <span class="xytab-con">
                            <span class="hide xtips">显示网站标题</span>
                            <?php if(!file_exists("images/logo.png")): ?><span class="hide xtips-i">请保存设置后上传LOGO图</span><?php else: ?><span class="hide xtips">已上传LOGO图，<a href="images/logo.png" target="_blank">查看</a></span><?php endif; ?>
                        </span>
                    </div>
                </li>
                <li>
                    <div class="lti"><span>头部登录地址</span></div>
                    <div class="rco">
                        <input type="text" value="<?php echo $zbp->Config('erx_Glass_p')->login_url;?>" name="Items[login_url]" size="49"><span class="xtips">留空则不展示，登录后仍为后台入口</span>
                    </div>
                </li>
                <li>
                    <div class="lti"><span>首页右侧上广告</span></div>
                    <div class="rco">
                        <input name="Items[fs1set]" type="text" value="<?php echo $zbp->Config('erx_Glass_p')->fs1set;?>" class="checkbox">是否启用？&emsp;
                        <a href="javascript:;" class="xydiybtn">编辑电脑端内容</a>
                        <span class="hide xydiycon">
                            <div class="xylayer"><textarea name="Items[fs1con]"><?php echo $zbp->Config('erx_Glass_p')->fs1con;?></textarea></div>
                        </span>&emsp;
                        <a href="javascript:;" class="xydiybtn">编辑手机端内容</a>
                        <span class="hide xydiycon">
                            <div class="xylayer"><textarea name="Items[fs1con_mb]"><?php echo $zbp->Config('erx_Glass_p')->fs1con_mb;?></textarea></div>
                        </span>
                    </div>
                </li>
                <li>
                    <div class="lti"><span>文章内容版权声明</span></div>
                    <div class="rco">
                        <a href="javascript:;" class="xydiybtn">编辑版权声明内容</a>
                        <span class="hide xydiycon">
                            <div class="xylayer"><textarea name="Items[copytip]"><?php echo $zbp->Config('erx_Glass_p')->copytip;?></textarea></div>
                        </span>
                        <span class="xtips">文章内容下方展示</span>
                    </div>
                </li>
                <li>
                    <div class="lti"><span>首页自定义标题</span></div>
                    <div class="rco">
                        <input name="Items[titleset]" type="text" value="<?php echo $zbp->Config('erx_Glass_p')->titleset;?>" class="checkbox">是否启用？&emsp;
                        <input type="text" value="<?php echo $zbp->Config('erx_Glass_p')->title;?>" name="Items[title]" size="40"><span class="xtips">启用后将替换默认的网站标题+副标题方案，浏览器标题栏显示</span>
                    </div>
                </li>
                <li>
                    <div class="lti"><span>列表自动缩略图</span></div>
                    <div class="rco">
                        <input name="Items[thumb_set]" type="text" value="<?php echo $zbp->Config('erx_Glass_p')->thumb_set;?>" class="checkbox">是否启用？
                        <span class="xtips">启用时系统将自动缩略并缓存图片，可在列表需加载较多大图时开启</span>
                    </div>
                </li>
                <li>
                    <div class="lti"><span>首页描述</span></div>
                    <div class="rco">
                        <input type="text" value="<?php echo $zbp->Config('erx_Glass_p')->description;?>" name="Items[description]" size="60"><span class="xtips">一段概括网站主题内容的简要文字，一般不超过100个汉字</span>
                    </div>
                </li>
                <li>
                    <div class="lti"><span>首页关键词</span></div>
                    <div class="rco">
                        <input type="text" value="<?php echo $zbp->Config('erx_Glass_p')->keywords;?>" name="Items[keywords]" size="60"><span class="xtips">多个关键词用半角逗号隔开，一般不超过50个汉字</span>
                    </div>
                </li>
                <li>
                    <div class="lti"><span>标题SEO设置</span></div>
                    <div class="rco">
                    <input name="Items[nocate]" type="text" value="<?php echo $zbp->Config('erx_Glass_p')->nocate;?>" class="checkbox">文章页标题去掉分类名？&emsp;
                    标题连接符：<input type="text" value="<?php echo $zbp->Config('erx_Glass_p')->seotcer;?>" name="Items[seotcer]" size="1" maxlength="3"><span class="xtips">请根据自己喜好填写，常见 _ - | 这三种，留空时默认为-</span>
                    </div>
                </li>
                <li>
                    <div class="lti"><span>头部SEO标签增强</span></div>
                    <div class="rco">
                    <input name="Items[metaog]" type="text" value="<?php echo $zbp->Config('erx_Glass_p')->metaog;?>" class="checkbox">启用og标签组？&emsp;
                    <input name="Items[canonical]" type="text" value="<?php echo $zbp->Config('erx_Glass_p')->canonical;?>" class="checkbox"> 启用canonical标签？
                    <span class="xtips">建议在知晓功效情况下开启，不懂可保持默认</span>
                    </div>
                </li>
                <li>
                    <div class="lti"><span>第三方SEO插件支持</span></div>
                    <div class="rco">
                        <input name="Items[seotool]" type="text" value="<?php echo $zbp->Config('erx_Glass_p')->seotool;?>" class="checkbox"><span class="xtips">主题自带标题优化方案，仅在需要兼容第三方SEO插件时开启</span>
                    </div>
                </li>
                <li>
                    <div class="lti"><span>主题配置初始化</span></div>
                    <div class="rco">
                        <input name="Items[setsave]" type="text" value="<?php echo $zbp->Config('erx_Glass_p')->setsave;?>" class="checkbox"><span class="xtips">仅在需要恢复本页配置初始值时开启，停用该主题时生效</span>
                    </div>
                </li>
            </ul>
            <input type="Submit" class="button btnfix" value="保存参数设定">
            </form>
        </fieldset>
        <fieldset class="erx-set-box erx-theme-tip">
            <legend>教程和说明</legend>
            <dl>
                <dt>错过后悔系列</dt>
                <dd>
                <span class="dot">■</span><a href="https://www.yiwuku.com/a/20123.html" target="_blank" style="color:#f00;">Z-BlogPHP专用采集器：Z-Blog采集填充器 get! get!</a><br>
                <span class="dot">■</span><a href="https://app.zblogcn.com/?id=33171" target="_blank" style="color:#690;">反手招：怕被别人采？那么防采集组合拳插件你值得拥有!</a><br>
                <span class="dot">■</span><a href="https://www.yiwuku.com/s/youhui/" target="_blank" style="color:#f09;"><b>重磅</b>：优惠合集来袭，快来看看有没有你心仪的东东~</a></dd>
                <dt>Z-Blog教程</dt>
                <dd>
                <span class="dot">■</span><a href="http://www.yiwuku.com/a/19915.html" target="_blank">ZblogPHP导航栏模块最新设置教程</a><br>
                <span class="dot">■</span><a href="http://www.yiwuku.com/a/20014.html" target="_blank">ZBlog使用教程：ZBlogPHP基本设置和后台管理</a><br>
                <span class="dot">■</span><a href="http://www.yiwuku.com/a/19896.html" style="color:#3a6ea5;" target="_blank">ZblogPHP伪静态设置方法最新教程</a></dd>
                <dd><a href="http://www.yiwuku.com/s/zblog/" class="more" target="_blank">更多……</a></dd>
            </dl>
            <dl>
                <dt>温馨提示</dt>
                <dd>当前主题模板代码为原创撰写，默认所用Logo、背景图、广告图等素材仅为效果示例，网站正式启用前请先替换，以防造成不利影响；</dd>
                <dd>当前主题首页、分类/列表、文章分别对应默认侧栏、侧栏2、侧栏3，可在“模块管理”中拖曳模块自由配置；</dd>
                <dd>当不确定所设置项为何处内容或不知是什么效果时，可保存设置后刷新前台网页查看确认，设置本身不会导致主题损坏，必要时可将配置初始化；</dd>
                <dd>当前主题通过将网站域名巧妙嵌入模板源码、文章内容区域类名动态化、版权声明并入文章内容等手段，让模板加持唯一性特征的同时，还能在一定程度上防抄袭；</dd>
                <dd>首页右侧主列表文章展示数量为系统设置：<a href="<?php echo $bloghost; ?>zb_system/admin/index.php?act=SettingMng">网站设置->页面设置->列表页显示文章的数量</a>，首页与分类差异化设置可用<a href="<?php echo $bloghost; ?>zb_users/plugin/AppCentre/main.php?id=36577" target="_blank">网站超级设置</a>插件实现；</dd>
                <dd>发布文章：手动复制他站文章易产生背景色样式，为避免影响美观，建议使用格式刷清除样式，或以纯文本粘贴模式粘贴（UEditor编辑器）；</dd>
                <dd>推荐插件：<a href="<?php echo $bloghost; ?>zb_users/plugin/AppCentre/main.php?id=21972" target="_blank">文章超级附加器</a>、<a href="<?php echo $bloghost; ?>zb_users/plugin/AppCentre/main.php?id=1422" target="_blank">游客发布-投稿</a>、<a href="<?php echo $bloghost; ?>zb_users/plugin/AppCentre/main.php?id=40590" target="_blank">自动别名</a>、<a href="<?php echo $bloghost; ?>zb_users/plugin/AppCentre/main.php?id=50859" target="_blank">双语神器</a>、<a href="<?php echo $bloghost; ?>zb_users/plugin/AppCentre/main.php?id=33171" target="_blank">防采集组合拳</a>、<a href="<?php echo $bloghost; ?>zb_users/plugin/AppCentre/main.php?id=46518" target="_blank">中文繁简体转换</a>、<a href="<?php echo $bloghost; ?>zb_users/plugin/AppCentre/main.php?id=48992" target="_blank">不同分类文章不同URL</a>、<a href="<?php echo $bloghost; ?>zb_users/plugin/AppCentre/main.php?id=49307" target="_blank">单站裂变站群</a>；</dd>
                <dd>免费应用：<a href="<?php echo $bloghost; ?>zb_users/plugin/AppCentre/main.php?id=1544" target="_blank">图式附件管理</a>、<a href="<?php echo $bloghost; ?>zb_users/plugin/AppCentre/main.php?id=2165" target="_blank">Favicon站标设置</a>、<a href="<?php echo $bloghost; ?>zb_users/plugin/AppCentre/main.php?id=1435" target="_blank">新评论提醒</a>、<a href="<?php echo $bloghost; ?>zb_users/plugin/AppCentre/main.php?id=1569" target="_blank">禁止游客评论</a>、<a href="<?php echo $bloghost; ?>zb_users/plugin/AppCentre/main.php?id=33404" target="_blank">禁止普通用户访问后台</a>等插件可让网站更强！<a href="<?php echo $bloghost; ?>zb_users/plugin/AppCentre/main.php?auth=3ec7ee20-80f2-498a-a5dd-fda19b198194" target="_blank">查看更多</a></dd>
                <dd><b>当前主题有对应<a href="<?php echo $bloghost; ?>zb_users/plugin/AppCentre/main.php?id=51277" target="_blank">VIP版本</a>，特有多种内容模块，功能更强大，适用范围更广，若有需要可以<a href="<?php echo $bloghost; ?>zb_users/plugin/AppCentre/main.php?id=51277" target="_blank">点击这里</a>查看；</b></dd>
                <dd>成品应用仅为满足大众化需要，主题相关疑问和建议以及定制修改需求敬请前往<a href="http://www.yiwuku.com/" target="_blank">作者主页</a>联系作者。</dd>
            </dl>
        </fieldset>
	</div>
</div>
<script>ActiveTopMenu("topmenu_erx_Glass_p");</script> 
<?php
require $blogpath . 'zb_system/admin/admin_footer.php';
RunTime();