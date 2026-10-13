<?php
class ly_qq_core
{
	static function Install()
	{
		global $zbp;
		//建表保存QQ登录openid
		if (!$zbp->db->ExistTable($GLOBALS['table']['ly_qq'])) {
			$s = $zbp->db->sql->CreateTable($GLOBALS['table']['ly_qq'], $GLOBALS['datainfo']['ly_qq']);
			$zbp->db->QueryMulit($s);
			//更改mem_Name编码为utf8mb4_general_ci防止用户名表情符号插入数据失败
			$d = $zbp->db->Query('SHOW FULL COLUMNS FROM `' . $zbp->db->dbpre . 'member` where Field = "mem_Name"');
			foreach ($d as $r) {
				if ($r['Field'] == 'mem_Name' && $r['Collation'] != 'utf8mb4_general_ci') {
					$zbp->db->Query("ALTER TABLE `" . $zbp->db->dbpre . "member` CHANGE COLUMN `mem_Name` `mem_Name` VARCHAR(250) NOT NULL DEFAULT '' COLLATE 'utf8mb4_general_ci' AFTER `mem_Status`");
				}
			}
		}
	}
	static function Update($is = 0)
	{
		global $zbp;
		//更新增加unionid字段
		if ($zbp->Config('ly_qq')->update != 1) {
			$zbp->Config('ly_qq')->update = 1;
			if (!$is) $zbp->SaveConfig('ly_qq');
			$add = 1;
			$data = array();
			$a = $zbp->db->Query('SHOW FULL COLUMNS FROM `' . $zbp->db->dbpre . 'ly_qq`');
			foreach ($a as $r) {
				if ($r['Field'] == 'uid' && !$r['Key']) {
					$data[] = $r['Field'];
				}
				if ($r['Field'] == 'openid' && !$r['Key']) {
					$data[] = $r['Field'];
				}
				if ($r['Field'] == 'unionid') {
					$add = 0;
					if (!$r['Key']) {
						$data[] = $r['Field'];
					}
				}
			}
			foreach ($data as $r) {
				$sql = $zbp->db->sql->get()->create($zbp->db->dbpre . 'ly_qq')->index(array($r => array($r)))->sql;
				$zbp->db->Query($sql);
			}
			if ($add) {
				$zbp->db->Query('ALTER TABLE `' . $zbp->db->dbpre . 'ly_qq` ADD COLUMN `unionid` VARCHAR(50) NOT NULL DEFAULT "" AFTER `openid`, ADD INDEX `unionid` (`unionid`)');
			}
		}
	}
	//新表序列
	static function database()
	{
		$database = array(
			'ly_qq' => array(
				'table' => '%pre%ly_qq',
				'datainfo' => array(
					'ID' => array('ID', 'integer', '', 0),
					'Uid' => array('uid', 'integer', '', 0),
					'Openid' => array('openid', 'string', 50, ''),
					'Unionid' => array('unionid', 'string', 50, '')
				)
			)
		);
		foreach ($database as $key => $v) {
			$GLOBALS['table'][$key] = $v['table'];
			$GLOBALS['datainfo'][$key] = $v['datainfo'];
		}
	}
	static function encrypt($d = array())
	{
		$key = ly_qq_Config('appkey');
		$d['time'] = time();
		$s = json_encode($d);
		$s = openssl_encrypt($s, "aes-256-cbc", $key, 0, substr(md5($key), 0, 16)); //php5.4
		return urlencode(base64_encode($s));
	}
	static function decrypt($d)
	{
		$key = ly_qq_Config('appkey');
		$s = base64_decode(urldecode(trim($d)));
		$s = openssl_decrypt($s, "aes-256-cbc", $key, 0, substr(md5($key), 0, 16));
		$d = json_decode($s, true);
		if (!empty($d['time']) && (time() - intval($d['time'])) < 300) {
			return $d;
		}
	}
	//回调地址
	static function Redirect_Uri($uri = '')
	{
		global $zbp;
		return $zbp->host . 'zb_users/plugin/ly_qq/qq.php' . $uri;
	}
	//QQ互联授权回调处理
	static function Authorize()
	{
		$url = self::Redirect_Uri();
		$qq = new ly_qq_oauth2(ly_qq_Config('appid'), ly_qq_Config('appkey'));
		$qq->state = self::Authorize2();
		if (GetVars('code')) {
			$result = $qq->access_token($url, GetVars('code'));
			if (!empty($result['access_token'])) {
				$url = self::currenturl(1);
				$qq->access_token = $result['access_token'];
				$qq_oid = $qq->get_openid(ly_qq_Config('unionid'));
				if (!empty($qq_oid['openid'])) {
					$d = $qq->get_user_info($qq_oid['openid']);
					if (!empty($d['nickname'])) {
						$d = array_merge($qq_oid, $d);
						if (GetVars('state')) {
							$e = self::decrypt(GetVars('state'));
							$d['user'] = !empty($e['user']) ? $e['user'] : '';
							if (!empty($e['uri'])) {
								$url = $e['uri'] . '?ly_qq_data=' . self::encrypt($d);
							} else {
								self::UserData($d);
							}
						} else {
							self::UserData($d);
						}
					}
				}
			}
			die('<script>location.href="' . $url . '";</script>');
		} else {
			$url = $qq->login_url($url, 'get_user_info');
			die('<script>location.href="' . $url . '";</script>');
		}
	}
	//QQ互联授权回调验证
	static function Authorize2()
	{
		global $zbp;
		if (GetVars('ly_qq_Authorize2')) {
			return GetVars('ly_qq_Authorize2');
		} elseif (GetVars('ly_qq_data')) {
			$d = self::decrypt(GetVars('ly_qq_data'));
			if (!empty($d['openid'])) {
				self::UserData($d);
				$url = self::currenturl(1);
			} else {
				$url = $zbp->host;
			}
			die('<script>location.href="' . $url . '";</script>');
		} elseif (preg_match('#^https?://.*?/plugin/ly_qq/qq.php#', ly_qq_Config('appid'))) {
			$d = array('uri' => self::Redirect_Uri(), 'user' => GetVars('user'));
			$url = ly_qq_Config('appid') . '?ly_qq_Authorize2=' . self::encrypt($d);
			die('<script>location.href="' . $url . '";</script>');
		} elseif (ly_qq_Config('host') && $zbp->host != ly_qq_Config('host')) {
			$d = array('uri' => self::Redirect_Uri(), 'user' => GetVars('user'));
			$url = ly_qq_Config('host') . 'zb_users/plugin/ly_qq/qq.php' . '?ly_qq_Authorize2=' . self::encrypt($d);
			die('<script>location.href="' . $url . '";</script>');
		} elseif (GetVars('user')) {
			return self::encrypt(array('user' => 1));
		}
	}
	//登录回调，注册用户或者与用户绑定openid
	static function UserData($d = array())
	{
		global $zbp;
		$openid = $d['openid'];
		$unionid = !empty($d['unionid']) ? $d['unionid'] : '';
		$avatar = preg_replace('#https?://#', '//', $d['figureurl_qq_2']);
		$nickname = addslashes(preg_replace('/[^\p{L}\p{N}._]/u', '', $d['nickname']));
		if (mb_strlen($nickname, 'utf-8') < 2) {
			$isname = 1;
		} else {
			$isname = 0;
		}
		$ip = GetGuestIP();
		self::Update();
		$where = array();
		$where[] = array('=', 'openid', $openid);
		if ($unionid) {
			$where[] = array('=', 'unionid', $unionid);
		}
		if (count($where) > 1) {
			$where = array('or', $where);
		}
		$tb = new ly_qq();
		if (!empty($d['user']) && $d['user'] == 1 && $zbp->user->ID) {
			$sql = $zbp->db->sql->get()->delete($zbp->db->dbpre . 'ly_qq')->where($where)->sql;
			$zbp->db->Query($sql);
			$tb->Uid = $zbp->user->ID;
			$tb->Openid = $openid;
			$tb->Unionid = $unionid;
			$tb->Save();
			if (!$zbp->user->Alias) {
				$zbp->user->Alias = $nickname;
			}
			if (ly_qq_Config('loginx') && $ip != $zbp->user->IP) {
				$zbp->user->Guid = GetGuid();
			}
			$zbp->user->IP = $ip;
			$zbp->user->Metas->ly_qq = 1;
			$zbp->user->Metas->ly_qq_avatar = $avatar;
			if (!$zbp->user->Email) {
				$zbp->user->Email = self::setEmail($nickname);
			}
			$zbp->user->Save();
		} else {
			$sql = $zbp->db->sql->get()->select($zbp->db->dbpre . 'ly_qq')->where($where)->sql;
			$r = $zbp->GetListType('ly_qq', $sql);
			if (!empty($r[0])) {
				$tb = $r[0];
				if ($tb->Uid != $zbp->user->ID) {
					$zbp->user = $zbp->GetMemberByID($tb->Uid);
					if (!$zbp->user->ID) {
						$sql = $zbp->db->sql->get()->delete($zbp->db->dbpre . 'ly_qq')->where($where)->sql;
						$zbp->db->Query($sql);
					}
				}
			}
			if ($tb->Uid && $tb->Uid == $zbp->user->ID) {
				if ($openid != $tb->Openid) {
					$tb->Openid = $openid;
					$tb->Save();
				}
				$sa = 0;
				if (ly_qq_Config('loginx') && $ip != $zbp->user->IP) {
					$sa = 1;
					$zbp->user->Guid = GetGuid();
				}
				if (!$zbp->user->Alias) {
					$sa = 1;
					$zbp->user->Alias = $nickname;
				}
				if ($ip != $zbp->user->IP) {
					$sa = 1;
					$zbp->user->IP = $ip;
				}
				if (!$zbp->user->Metas->ly_qq) {
					$sa = 1;
					$zbp->user->Metas->ly_qq = 1;
				}
				if ($avatar != $zbp->user->Metas->ly_qq_avatar) {
					$sa = 1;
					$zbp->user->Metas->ly_qq_avatar = $avatar;
				}
				if (!$zbp->user->Email) {
					$sa = 1;
					$zbp->user->Email = self::setEmail($nickname);
				}
				if ($sa || !$zbp->user->UpdateTime || date('Ymd') != date('Ymd', $zbp->user->UpdateTime)) {
					$sa = 1;
					$zbp->user->UpdateTime = time();
				}
				if ($sa) {
					$zbp->user->Save();
				}
			} else {
				$zbp->user = new Member();

				//临时授权
				$GLOBALS['actions']['MemberNew'] = 6;
				$GLOBALS['actions']['MemberEdt'] = 6;
				$GLOBALS['actions']['MemberPst'] = 6;
				$GLOBALS['actions']['MemberAll'] = 6;
				$_POST = array();
				$a = array('ID', 'Level', 'Status', 'Name', 'Email', 'HomePage', 'Intro', 'Template');
				foreach ($a as $r) {
					$_POST[$r] = $zbp->user->$r;
				}
				//新用户默认随机密码
				$pw = substr(md5($openid . GetGuid() . time()), 0, 12);
				$s = $zbp->db->sql->Count($zbp->table['Member'], array(array('COUNT', '*', 'num')), array('or', array('=', 'mem_Name', $nickname), array('=', 'mem_Alias', $nickname)));
				$num = GetValueInArrayByCurrent($zbp->db->Query($s), 'num');
				$_POST["Name"] = $nickname;
				if ($num > 0 || $isname) {
					$isname = 1;
					$_POST["Name"] .= time();
				}
				$_POST["Alias"] = $nickname;
				$_POST["Level"] = ly_qq_Config('level', 6);
				$_POST["Password"] = $pw;
				$_POST["PasswordRe"] = $pw;
				$_POST["meta_ly_qq"] = 1;
				$_POST["meta_ly_qq_avatar"] = $avatar;
				$_POST["IP"] = $ip;
				$_POST["Email"] = self::setEmail($nickname);
				$zbp->user = PostMember();
				if ($zbp->user->ID) {
					if ($isname) {
						$zbp->user->Alias =  $nickname . '_' . $zbp->user->ID;
						$zbp->user->Name = $nickname . '_' . substr(md5($openid . GetGuid()), 0, 6);
						$zbp->user->Save();
					}
					$tb->ID = 0;
					$tb->Uid = $zbp->user->ID;
					$tb->Openid = $openid;
					$tb->Unionid = $unionid;
					$tb->Save();
				}
			}
		}
		if ($zbp->user->ID) {
			$zbp->islogin = true;
			$sdt = (time() + 3600 * 24 * 30);
			SetLoginCookie($zbp->user, (int) $sdt);
			foreach ($GLOBALS['hooks']['Filter_Plugin_VerifyLogin_Succeed'] as $fpname => &$fpsignal) {
				$fpname();
			}
		}
	}
	static function Logout_Succeed()
	{
		global $zbp;
		if (ly_qq_Config('loginx') && $zbp->user->ID) {
			$zbp->user->Guid = GetGuid();
			$zbp->user->Save();
		}
	}
	static function setEmail($nickname)
	{
		$mail = ly_qq_Config('mail', '@lyphp.com');
		if ($mail) {
			$mail = (preg_match_all('#\w+#i', base64_encode($nickname), $t) ? implode('', $t[0]) : time()) . $mail;
		} else {
			$mail = '';
		}
		return $mail;
	}
	static function VerifyLogin()
	{
		global $zbp;
		if ($zbp->user->Metas->ly_qq) {
			$sql = $zbp->db->sql->Select($zbp->table['ly_qq'], array('ID'), array(array('=', 'uid', $zbp->user->ID)));
			$d = $zbp->db->Query($sql);
			if (empty($d[0])) {
				$zbp->user->Metas->Del('ly_qq');
				$zbp->user->Metas->Del('ly_qq_avatar');
				$zbp->user->Save();
			}
		}
	}
	//登录页插入QQ登录链接
	static function LoginLink()
	{
		self::currenturl();
		$loginx = function_exists('ly_wxlogin') && ly_wxlogin('IsLock') ? 0 : 1;
		if (ly_qq_Config('loginx') && $loginx && !ly_qq_Config('txt')) {
			echo ('<script>location.href="' . self::Redirect_Uri() . '";</script>');
		}
?>
		<script>
			$(function() {
				let val = '<a href="<?php echo self::Redirect_Uri(); ?>" style="position: relative;color:#fff;margin:2px 5px;padding:5px;border-radius:3px;background:#046f09;display: inline-block;">QQ登录</a>';
				let txt = '<?php echo ly_qq_Config('txt'); ?>';
				$("form").each(function() {
					if ($(this).find("input[type='password']").length > 0) {
						if (txt) {
							$(this).before('<div style="margin:0px auto 20px auto;text-align:center;font-weight:bold;color:#f00;font-size:20px;display:block;">' + txt + '</div>');
						}
						if ($(this).find('.submit').length > 0) {
							return $(this).find('.submit').prepend(val);
						} else {
							return $(this).append(val);
						}
					}
				});
			});
		</script>
<?php
	}
	//文章页面插入QQ登录链接
	static function PostLink()
	{
		if (ly_qq_Config('add')) {
			global $zbp;
			$zbp->Verify();
			if (!$zbp->user->ID) {
				echo '$(function(){';
				$val = '<div style="position: relative;width:100%;margin:20px auto;font-size:1.6rem;text-align:center;overflow:hidden;display:block;">';
				$val .= '<a href="' . self::Redirect_Uri() . '" target="_blank" style="position: relative;color:#fff;margin:20px auto;padding:5px 10px;border-radius:3px;background:#046f09;overflow:hidden;display:inline-block;">QQ登录</a>';
				$val .= '</div>';
				echo '
				$("form").each(function(){
					if($(this).find("textarea").length>0){
						$(this).attr("action","");
						return $(this).html(\'' . $val . '\');
					}
				});';
				echo '});';
			}
		}
	}
	//删除用户同时删除QQ绑定信息
	static function DelMember($mem)
	{
		global $zbp;
		$sql = $zbp->db->sql->Select($zbp->table['ly_qq'], array('*'), array(array('=', 'uid', '' . $mem->ID . '')));
		$tb = $zbp->GetListType('ly_qq', $sql);
		if (!empty($tb[0])) {
			$tb[0]->Del();
		}
	}
	//记录登录前URL，登录后返回原来URL
	static function currenturl($v = 0)
	{
		global $zbp;
		$reurl = ly_qq_Config('reurl');
		if ($reurl) {
			return $reurl;
		} else {
			static $sta = 1;
			if ($sta) {
				$sta = 0;
				$zbp->StartSession();
			}
			$url = !empty($_SESSION['ly_currenturl']) ? urldecode($_SESSION['ly_currenturl']) : '';
			if ($v == 1) {
				return $url ? $url : $zbp->host;
			} elseif (GetVars('reurl', 'GET')) {
				$REFERER = urldecode(GetVars('reurl', 'GET'));
			} else {
				$REFERER = !empty($_SERVER["HTTP_REFERER"]) ? htmlspecialchars($_SERVER["HTTP_REFERER"]) : '';
				if (!$REFERER || stripos($REFERER, $zbp->host) === false || stripos($REFERER, '/zb_users/') !== false || stripos($REFERER, '/zb_system/') !== false) {
					return;
				}
			}
			if (!empty($REFERER)) {
				$_SESSION['ly_currenturl'] = urlencode($REFERER);
			}
		}
	}
	//后台菜单增加绑定QQ链接
	static function TopMenu(&$m)
	{
		global $zbp;
		if (!$zbp->user->Metas->ly_qq && ly_qq_Config('appid')) {
			array_unshift($m, MakeTopMenu("login", ' 绑定QQ', self::Redirect_Uri('?user=1'), '', 'ly_qq_TopMenu'));
		}
	}
	//调用QQ登录头像
	static function Avatar(&$member)
	{
		if ($member->Metas->HasKey('ly_qq_avatar')) {
			return $member->Metas->ly_qq_avatar;
		}
	}
	//用户管理列表显示头像
	static function MemberMng(&$member, &$tabletds, &$tableths)
	{
		$th = '<th>QQ</th>';
		if ($member->Metas->ly_qq_avatar) {
			$td = '<td style="text-align:center"><img src="' . $member->Metas->ly_qq_avatar . '" style="width:30px;height:30px;" /></td>';
		} else {
			$td = '<td style="text-align:center;color:#aaa">/</td>';
		}
		if (array_search($th, $tableths) == false) {
			array_splice($tableths, 3, 0, $th);
		}
		array_splice($tabletds, 3, 0, $td);
	}
	static function Member_Edit()
	{
		global $member;
		if ($member->Metas->ly_qq_avatar) {
			echo '<script>$(function() {$(\'.divHeader2\').append(\'<span style="margin-left:15px;">qq:<img src="' . $member->Metas->ly_qq_avatar . '" style="vertical-align:middle;width:30px;height:30px;margin-left:2px;" /></span>';
			echo '</div>\');});</script>';
		}
	}
	static function Cmd_Begin()
	{
		global $zbp;
		if ($zbp->action == 'verify' && ly_qq_Config('loginx')) {
			self::currenturl();
			self::Authorize();
		} elseif ($zbp->action == 'cmt' && ly_qq_Config('add') && !$zbp->user->ID) {
			die();
			$die = false;
			if (GetVars('isajax', 'POST')) {
				// 兼容老版本的评论前端
				Add_Filter_Plugin('Filter_Plugin_Debug_Handler_Common', 'RespondError', PLUGIN_EXITSIGNAL_RETURN);
				$die = true;
			} elseif (GetVars('format', 'POST') == "json") {
				// 1.5之后的评论以json形式加载给前端
				Add_Filter_Plugin('Filter_Plugin_Debug_Handler_Common', 'JsonError4ShowErrorHook', PLUGIN_EXITSIGNAL_RETURN);
				$die = true;
			}
			$zbp->ShowError(6, __FILE__, __LINE__);
			if ($die) {
				exit;
			} else {
				Redirect_cmd_end(GetVars('HTTP_REFERER', 'SERVER'));
			}
		}
	}
}
