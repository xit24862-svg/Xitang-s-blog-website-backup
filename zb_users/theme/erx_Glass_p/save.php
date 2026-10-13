<?php
# erx_Glass_p erx@qq.com www.yiwuku.com
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$action='root';
if (!$zbp->CheckRights($action)) {$zbp->ShowError(6);die();}
if (!$zbp->CheckPlugin('erx_Glass_p')) {$zbp->ShowError(48);die();}
if($_GET['type'] == 'bg'){
	global $zbp;
	foreach ($_FILES as $key => $value) {
		if(!strpos($key, "_php")){
			if (is_uploaded_file($_FILES[$key]['tmp_name'])) {
				$tmp_name = $_FILES[$key]['tmp_name'];
				$name = $_FILES[$key]['name'];
				@move_uploaded_file($_FILES[$key]['tmp_name'], $zbp->usersdir.'theme/erx_Glass_p/images/bg.jpg');
			}
		}
	}
	$zbp->SetHint('good','背景图上传成功！');
	Redirect('main.php');
}
if($_GET['type'] == 'logo'){
	global $zbp;
	foreach ($_FILES as $key => $value) {
		if(!strpos($key, "_php")){
			if (is_uploaded_file($_FILES[$key]['tmp_name'])) {
				$tmp_name = $_FILES[$key]['tmp_name'];
				$name = $_FILES[$key]['name'];
				@move_uploaded_file($_FILES[$key]['tmp_name'], $zbp->usersdir.'theme/erx_Glass_p/images/logo.png');
			}
		}
	}
	$zbp->SetHint('good','LOGO图上传成功！');
	Redirect('main.php');
}