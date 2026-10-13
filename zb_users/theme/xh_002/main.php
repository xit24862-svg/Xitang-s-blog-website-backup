<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$action = 'root';
if (!$zbp->CheckRights($action)) {
    $zbp->ShowError(6);
    die();
}
if (!$zbp->CheckPlugin('xh_002')) {
    $zbp->ShowError(48);
    die();
}

if (count($_POST) > 0) {
    CheckIsRefererValid();
}

$blogtitle = '灵动白狐（卧雪）';
require $blogpath . 'zb_system/admin/admin_header.php';
require $blogpath . 'zb_system/admin/admin_top.php';
?>
    <div id="divMain">
        <div class="divHeader"><?php echo $blogtitle; ?></div>
        <div class="SubMenu">
            <?php
            $act = isset($_GET['act']) ? $_GET['act'] : "main";
            xh_002_menu($act);
            ?>
        </div>
        <div id="divMain2">
            <?php
            if ($act == "main") {
                require "tool/act/main.php";
            } elseif ($act == "seo") {
                require "tool/act/seo.php";
            } elseif ($act == "img") {
                require "tool/act/img.php";
            } elseif ($act == "jieshao") {
                require "tool/act/jieshao.php";
            }
            ?>
        </div>
    </div>
    <script type="text/javascript">AddHeaderIcon("<?php echo $bloghost . 'zb_users/theme/xh_002/logo.png'; ?>");</script>

<?php
require $blogpath . 'zb_system/admin/admin_footer.php';
RunTime();
?>