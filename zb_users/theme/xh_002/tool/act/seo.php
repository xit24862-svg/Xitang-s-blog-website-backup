<?php /** @var ZBLOGPHP $zbp */

if ($_POST) {
    foreach ($_POST as $k => $v) {
        if ($k == 'csrfToken') continue;
        $zbp->Config('xh_002')->$k = trim(str_replace('"', "'", $v));# 替换 " 为 '
    }
    $zbp->SaveConfig('xh_002');
    $zbp->ShowHint('good', '设置成功', 1);
}


$seo = $zbp->Config('xh_002')->seo ?? 0;
$seo_title = $zbp->Config('xh_002')->seo_title ?? '';
$seo_keywords = $zbp->Config('xh_002')->seo_keywords ?? '';
$seo_description = $zbp->Config('xh_002')->seo_description ?? '';
?>
    <table class="tb-set" style="margin: 10px;">
        <tr>
            <th style="text-align:center;width: 200px;"><span class="icon-share guiyi_ico_pd"></span> 设置</th>
            <th style="text-align:left;width: 800px;"><span
                        class="icon-tv guiyi_ico_pd">  首页SEO设置: </span></th>
        </tr>

        <form id="form1" name="form1" method="post" enctype="multipart/form-data">
            <?php if (function_exists('CheckIsRefererValid')) {
                echo '<input type="hidden" name="csrfToken" value="' . $zbp->GetCSRFToken() . '">';
            } ?>
            <tr>
                <td style="text-align:center;width: 200px;"><span class="icon-paperclip guiyi_ico_pd"></span>开关设置：</td>
                <td style="text-align:left;width: 600px;">
                    <br>
                    <input name="seo" id="seo" type="text" class="checkbox" value="<?= $seo ?>"/>
                    是否开启『首页SEO』功能
                    <br><br>
                    <span style="color: #0f54d4;margin-left: 20px">☕ 开启后：网站首页TDK，会按照你的设置个性化显示。</span><br>
                    <br>
                </td>
            </tr>
            <tr>


                <td style="text-align:left;width: 1000px;" colspan="2">
                    <table class="tb-set" style="margin: 10px;width: 1000px;">
                        <tr style="width: 1000px;">
                            <td style="width: 10%">SEO标题</td>
                            <td style="width: 90%">
                                <p>✅ 网站首页SEO标题（title）设置</p>
                                <p><input type="text" name="seo_title" style="width:98%;" value="<?= $seo_title ?>"/></p>
                            </td>
                        </tr>
                        <tr>
                            <td>SEO关键词</td>
                            <td>
                                <p>✅ 网站首页SEO关键词（keywords）设置</p>
                                <p>
                                    <input type="text" name="seo_keywords" style="width:98%;" value="<?= $seo_keywords ?>"/>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>SEO描述</td>
                            <td>
                                <p>✅ 网站首页SEO描述（description）设置</p>
                                <p>
                                    <textarea name="seo_description" type="text" style="width:98%;height: 100px"><?= $seo_description ?></textarea>
                                </p>
                            </td>

                        </tr>
                    </table>


                </td>
            </tr>
            <tr>
                <td style="text-align:center;width: 200px;"><span class="icon-paperclip guiyi_ico_pd"></span>保存设置：</td>
                <td style="text-align:left;width: 600px;">
                    <input type="button" class="btn-green" onclick="savenow()" value="保存">
                </td>
            </tr>
        </form>
    </table>
    <br><br><br><br>
    <script>
        function savenow() {

            var form = document.getElementById('form1');
            form.submit();
        }

    </script>

    <br>
    <br>
<?php

?>