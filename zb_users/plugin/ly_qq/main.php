<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$action = 'root';
if (!$zbp->CheckRights($action)) {
	$zbp->ShowError(6);
	die();
}
if (!$zbp->CheckPlugin('ly_qq')) {
	$zbp->ShowError(48);
	die();
}
$app = new App();
$app->LoadInfoByXml('plugin', 'ly_qq');
$blogtitle = $app->name . ' - 设置';
if (GetVars('act') == 'save') {
	CheckIsRefererValid();
	unset($_POST['csrfToken']);
	ly_qq_core::Update(1);
	foreach ($_POST as $k => $v) {
		if ($k == 'loginx') {
			if (!$zbp->user->Metas->HasKey('ly_qq') && ly_qq_Config('appid')) {
				$v = 0;
			}
		} elseif ($k == 'host') {
			$v = str_replace(':', '@', $v);
		}
		$zbp->Config('ly_qq')->$k = $v;
	}
	$zbp->SaveConfig('ly_qq');
	$zbp->SetHint('good');
	Redirect('./main.php');
}
require $blogpath . 'zb_system/admin/admin_header.php';
require $blogpath . 'zb_system/admin/admin_top.php';
?>
<div id='divMain'>
	<div class='divHeader'><?php echo $blogtitle; ?></div>
	<div id='divMain2'>
		<style>
			#divMain a {
				color: #4662D9;
				text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.1);
			}

			form .w50 {
				min-width: 50%;
			}

			form .w100 {
				width: 100%;
			}

			table {
				width: 100%;
			}

			table th,
			table td {
				word-break: break-all;
			}

			table.ul2 th:nth-child(1) {
				text-align: center;
				min-width: 150px !important;
			}

			table.ul2 th:nth-child(2) {
				width: 100%;
			}
		</style>
		<form action='?act=save' method='post'>
			<table class='ul2'>
				<tbody>
					<tr>
						<th><a href="<?php echo $app->url; ?>" target="_blank"><?php echo $app->author_name; ?></a></th>
						<th><?php echo $app->note; ?></th>
					</tr>
					<tr>
						<td>默认用户级别</td>
						<td>
							<p>
								<?php
								$a = array(6 => '游客', 5 => '评论者', 4 => '协作者', 3 => '作者');
								echo '<select name="level" class="form-control">';
								foreach ($a as $k => $r) {
									echo '<option value="' . $k . '"';
									if ($k == ly_qq_Config('level', 6)) echo ' selected="selected"';
									echo '>' . $r . '</option>';
								}
								echo '</select>';
								?>
						</td>
					</tr>
					<tr>
						<td>限制登录评论：</td>
						<td>
							<input name='add' type='text' value="<?php echo ly_qq_Config('add'); ?>" class='checkbox' style='display:none;' />-》必须登录后才能评论留言
						</td>
					</tr>
					<tr>
						<td>APP ID：</td>
						<td><input name='appid' type='text' value="<?php echo ly_qq_Config('appid'); ?>" class='form-control' /></td>
					</tr>
					<tr>
						<td>APP Key：</td>
						<td><input name='appkey' type='text' value="<?php echo ly_qq_Config('appkey'); ?>" class='form-control' /></td>
					</tr>
					<tr>
						<td>unionid：</td>
						<td>
							<input name='unionid' type='text' value="<?php echo ly_qq_Config('unionid'); ?>" class='checkbox' style='display:none;' />
							-》平台统一ID信息，有unionid权限才可以开启
						</td>
					</tr>
					<tr>
						<td>应用网址：</td>
						<td><input name='host' type='text' value="<?php echo ly_qq_Config('host', $zbp->host); ?>" class='form-control' />-》与应用信息一致的网址</td>
					</tr>
					<tr>
						<td>登录页提示：</td>
						<td><input name='txt' type='text' value="<?php echo ly_qq_Config('txt'); ?>" class='form-control w50' />-》如：请使用【QQ登录】自动注册登录</td>
					</tr>
					<tr>
						<td>只允许QQ登录：</td>
						<td>
							<input name='loginx' type='text' value="<?php echo ly_qq_Config('loginx'); ?>" class='checkbox' style='display:none;' />
							-》注意：开启此功能后登录页面就不能使用用户名和密码登录
						</td>
					</tr>
					<tr>
						<td>登录返回页面：</td>
						<td>
							<input name='reurl' type='text' value="<?php echo ly_qq_Config('reurl'); ?>" class='form-control' />
							-》登录成功后返回的地址页面，留空是自动返回来源页面
						</td>
					</tr>
					<tr>
						<td>用户默认邮箱：</td>
						<td><input name="mail" class="form-control" value="<?php echo ly_qq_Config('mail', '@lyphp.com'); ?>">-》默认：@lyphp.com，自动注册的用户邮箱后缀，用Gravatar类头像插件需要邮箱必填。</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<input type='hidden' name='csrfToken' value="<?php echo $zbp->GetCsrfToken(); ?>">
							<input type='submit' value=' 保 存 ' class='button' />
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							QQ互联：<a href="https://connect.qq.com/index.html" target="_blank">https://connect.qq.com/index.html</a><br>
							回调地址：<a href="<?php echo ly_qq_core::Redirect_Uri(); ?>" target="_blank"><?php echo ly_qq_core::Redirect_Uri(); ?></a><br>
							其它网站共用互联登录方式：应用网址设置对应QQ互联主站网址
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</div>
<script type='text/javascript'>
	AddHeaderIcon("<?php echo $bloghost . 'zb_users/plugin/ly_qq/logo.png'; ?>");
</script>
<?php
require '../../../zb_system/admin/admin_footer.php';
RunTime();
