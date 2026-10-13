<?php
function xh_002_menu($id)
{
    global $zbp;
    $arySubMenu = array(
        1 => array('<span class="icon-house-door guiyi_ico_pd"></span> 设置语言（中文/英文）', 'main', 'left', false),
        8 => array('<span class="icon-upc-scan guiyi_ico_pd"></span> 首页 SEO 设置', 'seo', 'left', false),
        88 => array('<span class="icon-credit-card guiyi_ico_pd"></span> Logo和ico图片设置', 'img', 'left', false),
        98 => array('<span class="icon-credit-card guiyi_ico_pd"></span> 首页站点介绍和收录图设置(seo必备)', 'jieshao', 'left', false),
        888 => array('<span class="icon-cog guiyi_ico_pd"></span> 帮助', 'fenxiang', 'left', false),
    );
    foreach ($arySubMenu as $k => $v) {
        echo '<a href="?act=' . $v[1] . '" ' . ($v[3] == true ? 'target="_blank"' : '') . '><span class="m-' . $v[2] . ' ' . ($id == $v[1] ? 'm-now' : '') . '">' . $v[0] . '</span></a>';
    }

}

function xh_002_language()
{
    global $zbp;
    return $zbp->Config('xh_002')->language ?? "zh-CN";
}

function xh_002_index_seo($name, $title)
{
    global $zbp;
    $header_html = "";

    if ($zbp->Config('xh_002')->seo && $zbp->Config('xh_002')->seo == '1') {
        if ($zbp->Config('xh_002')->seo_title != '') {
            $header_html = $header_html . "<title>{$zbp->Config('xh_002')->seo_title}</title>";
        } else {
            $header_html = $header_html . "<title>{$name}-{$title}</title>";
        }
        if ($zbp->Config('xh_002')->seo_keywords != '') {
            $header_html = $header_html . PHP_EOL . '<meta name="keywords" content="' . $zbp->Config("xh_002")->seo_keywords . '">';
        }
        if ($zbp->Config('xh_002')->seo_description != '') {
            $header_html = $header_html . PHP_EOL . '<meta name="description" content="' . $zbp->Config("xh_002")->seo_description . '">';
        }
    } else {
        $header_html = $header_html . "<title>{$name}-{$title}</title>";
        $header_html = $header_html . PHP_EOL . "<meta name=\"description\" content=\"{$name},{$title}\"/>";
    }
    return $header_html;
}

function xh_002_ico_html() // favicon.ico ico设置
{
    global $zbp;
    if ($zbp->Config('xh_002')->ico != '') {
        $ico_html = '<link rel="icon" href="' . $zbp->Config('xh_002')->ico . '">';
    } else {
        $ico_html = '<link rel="icon" href="' . $zbp->host . 'zb_users/theme/xh_002/style/favicon.ico">' . PHP_EOL;
    }
    return $ico_html;
}

function xh_002_logo() // favicon.ico ico设置
{
    global $zbp;
    if ($zbp->Config('xh_002')->logo) {
        $logo_src = $zbp->Config('xh_002')->logo;
    } else {
        $logo_src = $zbp->host . 'zb_users/theme/xh_002/style/logo.png';
    }
    return $logo_src;
}

function xh_002_language_check($language_check)
{
    $language = xh_002_language(); // 获取当前语言
    if ($language == $language_check) {
        return " selected='selected'";
    } else {
        return "";
    }
}

$xh_002_msg_arr = require_once 'language.php';

function xh_002_msg($key) # 替代  {$lang['msg']['search']}，会自动判断语言 返回 $key只用传入 tm_search 即可
{
    /*
    'tm_search' => '文章搜索...',// xh_002_msg($key) 会自动判断语言 返回 $key只用传入 tm_search 即可
    'tm_search_tw' => '文章搜索...',
    'tm_search_hk' => '文章搜索...',
    'tm_search_en' => 'Search articles...',
    <option value="zh-CN" <?= xh_002_language_check("zh-CN") ?>>中文简体（简体）/zh-CN</option>
    <option value="zh-HK"<?= xh_002_language_check("zh-HK") ?>>中文繁体（香港）/zh-HK</option>
    <option value="zh-TW"<?= xh_002_language_check("zh-TW") ?>>中文繁体（台湾）/zh-TW</option>
    <option value="en"<?= xh_002_language_check("en") ?>>全球英文（国际）/en</option>
    */

    global $xh_002_msg_arr;
    # 如果 $key 不包含 _tw / _hk / _en 则返回默认中文
    $language = xh_002_language();
    if ($language == 'zh-CN') {
        return $xh_002_msg_arr[$key] ?? "";
    } elseif ($language == 'zh-TW') {
        return $xh_002_msg_arr[$key . '_tw'] ?? "";
    } elseif ($language == 'zh-HK') {
        return $xh_002_msg_arr[$key . '_hk'] ?? "";
    } elseif ($language == 'en') {
        return $xh_002_msg_arr[$key . '_en'] ?? "";
    } else {
        return "";
    }
}

//图片获取
function xh_002_xh_img($article)
{
    if ($article->ImageCount) {
        $img = $article->AllImages[0];
    } else {
        $img = "";
    }
    return $img;
}

function xh_002_nohtml($source)
{
    $source = preg_replace("/<([^<>]*)>/si", "", $source);
    $source = str_replace("<", "", $source);
    $source = str_replace(">", "", $source);
    return $source;
}

function xh_002_get_article_intro($article, $zishu = 180)
{
    $source = $article->Intro;
    $source = xh_002_nohtml($source);
    $intro = preg_replace('/[\r\n\s]+/u', '', trim(SubStrUTF8($source, $zishu)) . '...');
    if (strlen($source) < $zishu) {
        $source = $article->Content;
        $source = xh_002_nohtml($source);
        $intro = preg_replace('/[\r\n\s]+/u', '', trim(SubStrUTF8($source, $zishu)) . '...');
        return $intro;
    } else {
        return $intro;
    }
}

function xh_002_get_article_img($article) // 获取文章第一张图片 如果没图 取第一张图
{
    global $zbp;
    $article_img = xh_002_xh_img($article);
    $article_id = $article->ID;
    #$img_id = $article_id % 27;
    $img_id = mt_rand(1, 27);
    if ($article_img == "") {
        $article_img = $zbp->host . 'zb_users/theme/xh_002/style/img/' . $img_id . '.png';
    }
    return $article_img;
}

function xh_002_get_tags() // 左侧标签云
{
    global $zbp;
    $tags_html = isset($zbp->modulesbyfilename['tags']->Content) ? $zbp->modulesbyfilename['tags']->Content : '';
    $tags_html = str_replace('<li>', '', $tags_html);
    $tags_html = str_replace('</li>', '', $tags_html);
    return $tags_html;
}

function xh_002_get_fenlei() // 左侧分类
{
    global $zbp;
    $html = isset($zbp->modulesbyfilename['catalog']->Content) ? $zbp->modulesbyfilename['catalog']->Content : '';
    $html = preg_replace('%<i\s?[^>]*>|</i>%', "", $html);
    #$html = str_replace('<li>', '', $tags_html);
    #$html = str_replace('</li>', '', $tags_html);
    return $html;
}

function xh_002_get_navbar() // 顶部导航
{
    global $zbp;
    $daohang_json_str = $zbp->modulesbyfilename['navbar']->Metas->LM_json; # $mod = $zbp->GetModuleByFileName('navbar');
    $daohang_json = json_decode($daohang_json_str, true);
    #print_r(($daohang_json));
    /*{
    "首页": {
        "href": "http://moban001.com/",
        "title": "",
        "text": "首页",
        "target": "",
        "ico": "",
        "subs": [

        ],
        "issub": 0
    },
    "留言本": {
        "href": "http://moban001.com/?id=2",
        "title": "",
        "text": "留言本",
        "target": "",
        "ico": "",
        "subs": [

        ],
        "issub": 0
    },
    "中学": {
        "href": "http://moban001.com/?cate=2",
        "title": "",
        "text": "中学",
        "target": "",
        "ico": "",
        "subs": {
            "初一": {
                "href": "http://moban001.com/?cate=3",
                "title": "",
                "text": "初一",
                "target": "_blank",
                "ico": "",
                "subs": [

                ],
                "issub": 1
            }
        },
        "issub": 0
    }
}*/

    $daohang_html = '';
    if ($daohang_json) {
        foreach ($daohang_json as $key => $item) {
            $daohang_html .= '<li>';
            $daohang_html .= '<a href="' . $item['href'] . '" target="_blank">' . $item['text'] . '</a>';
            if (count($item['subs'])) {
                $daohang_html .= '<ul class="sub_daohang">';
                foreach ($item['subs'] as $key => $itemSub) {
                    $daohang_html .= '<li><a href="' . $itemSub['href'] . '" target="_blank">' . $itemSub['text'] . '</a></li>';
                }
                $daohang_html .= '</ul>';
            }
            $daohang_html .= "</li>\n";
        }
    } else {
        $daohang_html = $zbp->modulesbyfilename['navbar']->Content;
        $daohang_html = str_replace('<ul>', '<ul class="sub_daohang">', $daohang_html);
    }
    #var_dump($daohang_html);
    #die();
    return $daohang_html;
}


function xh_002_get_news($num = 10)
{
    global $zbp;
    $where = array(array('=', 'log_Status', '0'), array('=', 'log_Type', 0));
    $order = array('log_ID' => 'desc');
    $limit = array(0, $num);
    $articles = $zbp->GetPostList(array('*'), $where, $order, $limit);
    return $articles;
}

function xh_002_daohang() # 等价于 {module:navbar} 暂时不用
{
    global $zbp;
    $modules_now = $zbp->modules;
    #var_dump($modules_now); #die();
    foreach ($modules_now as $key => $module) {
        if ($module->Source != 'system') {
            continue;
        }
        #$name = $module->Name;
        $fileName = $module->FileName;
        $fileType = $module->Type;
        if ($fileName == 'navbar' and $fileType == 'ul') {
            $content = $module->Content;
            return $content;
        }
    }
    return "";
}


function xh_002_upload_img() # 图片上传功能
{
    global $zbp;
########################################################################################################################## 图片上传功能 开始
    /*
    # 使用方法：上传按钮，class定义为="guiyi_upload_img_click"，图片地址input框class定义为="guiyi_upload_img_ok"。即可实现上传图片功能。
    <父元素>
    <input id="uplod_img1" name="uplod_img1" class="guiyi_upload_img_ok" STYLE="width: 600px; " value="222"/>
    <input type="button" class="guiyi_upload_img_click" value="上传图片">
    </父元素>
     */

    $ueditor_url = $zbp->host . 'zb_users/plugin/AppCentre/main.php?id=228';
    if ($zbp->LoadApp('plugin', 'UEditor')->isloaded) {//判断是否安装“UEditor”插件，配置页图片上传依赖此插件
        echo '<script type="text/javascript" src="' . $zbp->host . 'zb_users/plugin/UEditor/ueditor.config.php"></script>';
        echo '<script type="text/javascript" src="' . $zbp->host . 'zb_users/plugin/UEditor/ueditor.all.min.js"></script>';
        $guiyi_upload_img_js = "
$(document).ready(function () {
    // 这里写页面加载完毕后要执行的代码
    var guiyi_container = document.createElement('script');
    $(guiyi_container).attr('type', 'text/plain').attr('id', 'guiyi_img_editor');
    $('body').append(guiyi_container);
    guiyi_editor = UE.getEditor('guiyi_img_editor');
    guiyi_editor.ready(function () {
        guiyi_editor.hide();
        $('.guiyi_upload_img_click').click(function () {
            object = $(this).parent().find('.guiyi_upload_img_ok');
            guiyi_editor.getDialog('insertimage').open();
            guiyi_editor.addListener('beforeInsertImage', function (t, arg) {
                object.attr('value', arg[0].src);
                object.val(arg[0].src);
            });
        });
    })
});
";
        echo '<script type="text/javascript">' . PHP_EOL . $guiyi_upload_img_js . PHP_EOL . '</script>';

    } else {
        $zbp->ShowHint('bad', ' (<a href="' . $ueditor_url . '" target="_blank">请先安装 UEditor 插件。</a>) ');
    }
########################################################################################################################## 图片上传功能 结束
}

?>