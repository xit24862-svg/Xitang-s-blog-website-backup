<?php /** @var ZBLOGPHP $zbp */

if (isset($_POST['language'])) {
    $language = $_POST['language'];
    $zbp->Config('xh_002')->language = $language;
    $zbp->SaveConfig('xh_002');
    $zbp->ShowHint('good', '设置成功', 1);
}

?>


    <table class="tb-set" style="margin: 10px;">
        <tr>
            <th style="text-align:center;width: 200px;"> 灵动白狐（卧雪）</th>
            <th style="text-align:left;width: 800px;"><span
                        class="icon-tv guiyi_ico_pd">  设置语言（中文/英文）: </span></th>
        </tr>

        <form id="form1" name="form1" method="post" enctype="multipart/form-data">
            <?php if (function_exists('CheckIsRefererValid')) {
                echo '<input type="hidden" name="csrfToken" value="' . $zbp->GetCSRFToken() . '">';
            } ?>


            <tr>
                <td style="text-align:center;width: 200px;">
                    <img src="screenshot.png" height="238" style="margin: 5px" title="白狐卧雪而憩，轻嗅雪香，藏尽一身仙气，给您带来好运。">
                    <p style="color: #cacaca">白狐卧雪而憩，轻嗅雪香，藏尽一身仙气。</p>
                </td>
                <td style="text-align:left;width: 600px;">
                    <label for="select1">✅ 请选择一个选项：</label>
                    <select id="language" name="language">
                        <option value="zh-CN" <?= xh_002_language_check("zh-CN") ?>>中文简体（简体）/zh-CN</option>
                        <option value="zh-HK"<?= xh_002_language_check("zh-HK") ?>>中文繁体（香港）/zh-HK</option>
                        <option value="zh-TW"<?= xh_002_language_check("zh-TW") ?>>中文繁体（台湾）/zh-TW</option>
                        <option value="en"<?= xh_002_language_check("en") ?>>全球英文（国际）/en</option>
                    </select>
                    <br><br>
                    <span style="color: #0f54d4;margin-left: 20px">☕ 根据您的站点，选择一个合适网站语言：网站将自动设置为您的网站相关对应语言配置。</span>
                    <br><br>✅ 灵动白狐（卧雪）主题支持的语言：<br>
                    <br><span style="margin-left: 20px">🐉 中文站 中文简体（中国中文）/zh-CN</span>
                    <br><span style="margin-left: 20px">🥟 中文站 中文繁体（中国台湾）/zh-TW</span>
                    <br><span style="margin-left: 20px">🏙️ 中文站 中文繁体（中国香港）/zh-HK</span>
                    <br><span style="margin-left: 20px">🏈 英文站 世界语言（通用英文）/en</span>
                    <br><br>
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
        function replaceSpecialCharacters1(str) {
            return str.replace(/[\s]+/img, '');
        }

        function savenow() {

            var form = document.getElementById('form1');
            form.submit();
        }

        //alert(UE)

        ;
    </script>

    <br>
    <br>
<?php

?>