<?php /** @var ZBLOGPHP $zbp */

if ($_POST) {
    foreach ($_POST as $k => $v) {
        if ($k == 'csrfToken') continue;
        $zbp->Config('xh_002')->$k = $v;
    }
    $zbp->SaveConfig('xh_002');
    $zbp->ShowHint('good', '设置成功', 1);
}


$jieshao_img = $zbp->Config('xh_002')->jieshao_img ?? '';
$jieshao_msg = $zbp->Config('xh_002')->jieshao_msg ?? '';
$jieshao_msg_default = $zbp->host . 'zb_users/theme/xh_002/style/logo_baidu.png';
?>
    <table class="tb-set" style="margin: 10px;">
        <tr>
            <th style="text-align:center;width: 200px;"><span class="icon-share guiyi_ico_pd"></span> 设置</th>
            <th style="text-align:left;width: 800px;"><span
                        class="icon-tv guiyi_ico_pd">  首页站点介绍和收录图设置(seo必备): </span></th>
        </tr>

        <form id="form1" name="form1" method="post" enctype="multipart/form-data">
            <?php if (function_exists('CheckIsRefererValid')) {
                echo '<input type="hidden" name="csrfToken" value="' . $zbp->GetCSRFToken() . '">';
            } ?>
            <tr>
                <td style="text-align:center;width: 200px;"><span class="icon-paperclip guiyi_ico_pd"></span>首页收录图设置：</td>
                <td style="text-align:left;width: 600px;">
                    <br>
                    <input id="jieshao_img" name="jieshao_img" class="guiyi_upload_img_ok" STYLE="width: 600px; " value="<?= $jieshao_img ?>"/>
                    <input type="button" class="guiyi_upload_img_click" value="上传图片（Logo）">
                    <br>默认地址：<?= $jieshao_msg_default ?>
                    <br>留空设置：为空则使用默认地址图片。
                    <br><br>
                </td>
            </tr>
            <tr>
                <td style="text-align:center;width: 200px;"><span class="icon-paperclip guiyi_ico_pd"></span>首页站点介绍设置：</td>
                <td style="text-align:left;width: 600px;">
                    <br>
                    <textarea id="jieshao_msg" name="jieshao_msg" class="guiyi_upload_img_ok" STYLE="width: 500px; height: 180px;padding: 10px"><?= $jieshao_msg ?></textarea>

                    <br> * 请写网站介绍，便于搜索引擎对您的网站进行精准定位。
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