<?php /** @var ZBLOGPHP $zbp */

if ($_POST) {
    foreach ($_POST as $k => $v) {
        if ($k == 'csrfToken') continue;
        $zbp->Config('xh_002')->$k = $v;
    }
    $zbp->SaveConfig('xh_002');
    $zbp->ShowHint('good', '设置成功', 1);
}


$logo = $zbp->Config('xh_002')->logo ?? '';
$ico = $zbp->Config('xh_002')->ico ?? '';
$default_logo = $zbp->host . 'zb_users/theme/xh_002/style/logo.png';
$default_ico = $zbp->host . 'zb_users/theme/xh_002/style/favicon.ico';
?>
    <table class="tb-set" style="margin: 10px;">
        <tr>
            <th style="text-align:center;width: 200px;"><span class="icon-share guiyi_ico_pd"></span> 设置</th>
            <th style="text-align:left;width: 800px;"><span
                        class="icon-tv guiyi_ico_pd">  网站的Logo和ico图片设置: </span></th>
        </tr>

        <form id="form1" name="form1" method="post" enctype="multipart/form-data">
            <?php if (function_exists('CheckIsRefererValid')) {
                echo '<input type="hidden" name="csrfToken" value="' . $zbp->GetCSRFToken() . '">';
            } ?>
            <tr>
                <td style="text-align:center;width: 200px;"><span class="icon-paperclip guiyi_ico_pd"></span>网站Logo设置：</td>
                <td style="text-align:left;width: 600px;">
                    <br>
                    <input id="logo" name="logo" class="guiyi_upload_img_ok" STYLE="width: 600px; " value="<?= $logo ?>"/>
                    <input type="button" class="guiyi_upload_img_click" value="上传图片（Logo）">
                    <br>默认地址：<?= $default_logo ?>
                    <br>留空设置：为空则使用默认地址图片。
                    <br><br>
                </td>
            </tr>
            <tr>
                <td style="text-align:center;width: 200px;"><span class="icon-paperclip guiyi_ico_pd"></span>网站ico设置：</td>
                <td style="text-align:left;width: 600px;">
                    <br>
                    <input id="ico" name="ico" class="guiyi_upload_img_ok" STYLE="width: 600px; " value="<?= $ico ?>"/>
                    <input type="button" class="guiyi_upload_img_click" value="上传图片（ico）">
                    <br>默认地址：<?= $default_ico ?>
                    <br>留空设置：为空则使用默认地址图片。
                    <br><br>
                </td>
            </tr>

            <tr>
                <td style="text-align:center;width: 200px;"><span class="icon-paperclip guiyi_ico_pd"></span>保存设置：</td>
                <td style="text-align:left;width: 600px;"><br>
                    <input type="button" class="btn-green" onclick="savenow()" value="保存"><br><br>
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
xh_002_upload_img();
?>