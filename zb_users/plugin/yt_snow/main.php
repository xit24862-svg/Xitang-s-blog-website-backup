<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';

$zbp->Load();
$action = 'root';
if (!$zbp->CheckRights($action)) {
    $zbp->ShowError(6);
    die();
}

if (!$zbp->CheckPlugin('yt_snow')) {
    $zbp->ShowError(48);
    die();
}

$act = GetVars("act", "GET");
if ($act === "save") {
    CheckIsRefererValid();
    if (isset($_POST['save'])) {
        $zbp->Config('yt_snow')->enable = (int)$_POST['enable'];
        $zbp->Config('yt_snow')->effect_type = $_POST['effect_type'];
        $zbp->Config('yt_snow')->count = (int)$_POST['count'];
        $zbp->Config('yt_snow')->speed_min = (float)$_POST['speed_min'];
        $zbp->Config('yt_snow')->speed_max = (float)$_POST['speed_max'];
        $zbp->Config('yt_snow')->size_min = (int)$_POST['size_min'];
        $zbp->Config('yt_snow')->size_max = (int)$_POST['size_max'];
        $zbp->Config('yt_snow')->color = $_POST['color'];
        $zbp->Config('yt_snow')->opacity_min = (float)$_POST['opacity_min'];
        $zbp->Config('yt_snow')->opacity_max = (float)$_POST['opacity_max'];
        $zbp->Config('yt_snow')->wind = (float)$_POST['wind'];
        $zbp->Config('yt_snow')->sway = (int)$_POST['sway'];
        $zbp->Config('yt_snow')->interaction = (int)$_POST['interaction'];
        $zbp->Config('yt_snow')->z_index = (int)$_POST['z_index'];
        $zbp->Config('yt_snow')->targets = $_POST['targets'];
        $zbp->SaveConfig('yt_snow');
        $zbp->SetHint('good', '参数已保存');
        Redirect("./main.php");
    }
}

$blogtitle = '四季飞扬';
require $blogpath . 'zb_system/admin/admin_header.php';
require $blogpath . 'zb_system/admin/admin_top.php';
?>
<div id="divMain">
    <div class="divHeader"><?php echo $blogtitle; ?></div>
    <div class="SubMenu">
    </div>
    <div id="divMain2">
        <form id="form1" name="form1" method="post" action="?act=save">
            <input type="hidden" name="csrfToken" value="<?php echo $zbp->GetCSRFToken();?>">

            <table width="100%" border="1" class="tableBorder">
                <tr>
                    <th width="15%"><p align="center">参数</p></th>
                    <th width="50%"><p align="center">值</p></th>
                    <th width="35%"><p align="center">说明</p></th>
                </tr>
                
                <tr>
                    <td><p align="center">启用插件</p></td>
                    <td>
                        <input type="radio" name="enable" value="1"<?php echo ($zbp->Config('yt_snow')->enable ? ' checked="checked"' : ''); ?>> 是&nbsp;&nbsp;
                        <input type="radio" name="enable" value="0"<?php echo (!$zbp->Config('yt_snow')->enable ? ' checked="checked"' : ''); ?>> 否
                    </td>
                    <td><p align="center">是否启用雪花效果</p></td>
                </tr>
                
                <tr>
                    <td><p align="center">特效类型</p></td>
                    <td>
                        <input type="radio" name="effect_type" value="snow"<?php echo ($zbp->Config('yt_snow')->effect_type == 'snow' || !$zbp->Config('yt_snow')->HasKey('effect_type') ? ' checked="checked"' : ''); ?>> 雪花效果&nbsp;&nbsp;
                        <input type="radio" name="effect_type" value="spring"<?php echo ($zbp->Config('yt_snow')->effect_type == 'spring' ? ' checked="checked"' : ''); ?>> 樱花效果
                    </td>
                    <td><p align="center">选择要启用的特效类型</p></td>
                </tr>
                <tr>
                    <td><p align="center">飘落数量</p></td>
                    <td>
                        <input type="text" name="count" value="<?php echo (int)($zbp->Config('yt_snow')->count); ?>" style="width:80px;">
                    </td>
                    <td><p align="center">页面上同时显示的雪花数量（建议50-200之间）</p></td>
                </tr>
                
                <tr>
                    <td><p align="center">最小速度</p></td>
                    <td>
                        <input type="text" name="speed_min" value="<?php echo (float)($zbp->Config('yt_snow')->speed_min); ?>" style="width:80px;">
                    </td>
                    <td><p align="center">雪花飘落的最小速度（像素/帧，建议 1）</p></td>
                </tr>
                
                <tr>
                    <td><p align="center">最大速度</p></td>
                    <td>
                        <input type="text" name="speed_max" value="<?php echo (float)($zbp->Config('yt_snow')->speed_max); ?>" style="width:80px;">
                    </td>
                    <td><p align="center">雪花飘落的最大速度（像素/帧，建议 3）</p></td>
                </tr>
                
                <tr>
                    <td><p align="center">最小尺寸</p></td>
                    <td>
                        <input type="text" name="size_min" value="<?php echo (int)($zbp->Config('yt_snow')->size_min); ?>" style="width:80px;"> 像素
                    </td>
                    <td><p align="center">雪花的最小尺寸</p></td>
                </tr>
                
                <tr>
                    <td><p align="center">最大尺寸</p></td>
                    <td>
                        <input type="text" name="size_max" value="<?php echo (int)($zbp->Config('yt_snow')->size_max); ?>" style="width:80px;"> 像素
                    </td>
                    <td><p align="center">雪花的最大尺寸</p></td>
                </tr>

                <tr>
                    <td><p align="center">雪花颜色</p></td>
                    <td>
                        <input type="color" name="color" value="<?php echo $zbp->Config('yt_snow')->color ? $zbp->Config('yt_snow')->color : '#ffffff'; ?>" style="width:80px;">
                    </td>
                    <td><p align="center">雪花的颜色</p></td>
                </tr>

                <tr>
                    <td><p align="center">透明度范围</p></td>
                    <td>
                         最小: <input type="text" name="opacity_min" value="<?php echo (float)($zbp->Config('yt_snow')->opacity_min ? $zbp->Config('yt_snow')->opacity_min : 0.3); ?>" style="width:50px;"> - 
                         最大: <input type="text" name="opacity_max" value="<?php echo (float)($zbp->Config('yt_snow')->opacity_max ? $zbp->Config('yt_snow')->opacity_max : 0.8); ?>" style="width:50px;">
                    </td>
                    <td><p align="center">0.0 (透明) 到 1.0 (不透明)</p></td>
                </tr>

                <tr>
                    <td><p align="center">风力</p></td>
                    <td>
                        <input type="text" name="wind" value="<?php echo (float)($zbp->Config('yt_snow')->wind); ?>" style="width:80px;">
                    </td>
                    <td><p align="center">水平飘动速度，负数向左，正数向右，0为无风</p></td>
                </tr>

                <tr>
                    <td><p align="center">开启摇摆</p></td>
                    <td>
                        <input type="text" class="checkbox" name="sway" value="<?php echo (int)($zbp->Config('yt_snow')->HasKey('sway') ? $zbp->Config('yt_snow')->sway : 1); ?>" />
                    </td>
                    <td><p align="center">雪花是否左右摇摆 (0/1)</p></td>
                </tr>

                <tr>
                    <td><p align="center">鼠标交互</p></td>
                    <td>
                        <input type="text" class="checkbox" name="interaction" value="<?php echo (int)($zbp->Config('yt_snow')->HasKey('interaction') ? $zbp->Config('yt_snow')->interaction : 1); ?>" />
                    </td>
                    <td><p align="center">鼠标是否排斥雪花 (0/1)</p></td>
                </tr>

                <tr>
                    <td><p align="center">层级 (Z-Index)</p></td>
                    <td>
                        <input type="text" name="z_index" value="<?php echo (int)($zbp->Config('yt_snow')->z_index ? $zbp->Config('yt_snow')->z_index : 999999); ?>" style="width:80px;">
                    </td>
                    <td><p align="center">CSS z-index 值</p></td>
                </tr>
                
                <tr>
                    <td><p align="center">作用元素</p></td>
                    <td>
                        <input type="text" name="targets" value="<?php echo htmlspecialchars($zbp->Config('yt_snow')->targets); ?>" style="width:300px;">
                    </td>
                    <td><p align="center">应用雪花效果的CSS选择器，多个用逗号分隔</p></td>
                </tr>
                
                <tr>
                    <td colspan="3">
                        <input name="save" type="submit" value="保存设置" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
require $blogpath . 'zb_system/admin/admin_footer.php';
RunTime();
?>