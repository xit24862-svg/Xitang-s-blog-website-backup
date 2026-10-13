-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2021-05-06 06:21:03
-- 服务器版本： 5.7.30-log
-- PHP 版本： 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `bt`
--

-- --------------------------------------------------------

--
-- 表的结构 `zbp_category`
--

DROP TABLE IF EXISTS `zbp_category`;
CREATE TABLE IF NOT EXISTS `zbp_category` (
  `cate_ID` int(11) NOT NULL AUTO_INCREMENT,
  `cate_Name` varchar(250) NOT NULL DEFAULT '',
  `cate_Order` int(11) NOT NULL DEFAULT '0',
  `cate_Type` int(11) NOT NULL DEFAULT '0',
  `cate_Count` int(11) NOT NULL DEFAULT '0',
  `cate_Alias` varchar(250) NOT NULL DEFAULT '',
  `cate_Group` varchar(250) NOT NULL DEFAULT '',
  `cate_Intro` text NOT NULL,
  `cate_RootID` int(11) NOT NULL DEFAULT '0',
  `cate_ParentID` int(11) NOT NULL DEFAULT '0',
  `cate_CreateTime` int(11) NOT NULL DEFAULT '0',
  `cate_PostTime` int(11) NOT NULL DEFAULT '0',
  `cate_UpdateTime` int(11) NOT NULL DEFAULT '0',
  `cate_Template` varchar(250) NOT NULL DEFAULT '',
  `cate_LogTemplate` varchar(250) NOT NULL DEFAULT '',
  `cate_Meta` longtext NOT NULL,
  PRIMARY KEY (`cate_ID`),
  KEY `zbp_cate_Order` (`cate_Order`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `zbp_category`
--

INSERT INTO `zbp_category` (`cate_ID`, `cate_Name`, `cate_Order`, `cate_Type`, `cate_Count`, `cate_Alias`, `cate_Group`, `cate_Intro`, `cate_RootID`, `cate_ParentID`, `cate_Template`, `cate_LogTemplate`, `cate_Meta`) VALUES
(1, '未分类', 0, 0, 1, 'uncategorized', '', '', 0, 0, '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `zbp_comment`
--

DROP TABLE IF EXISTS `zbp_comment`;
CREATE TABLE IF NOT EXISTS `zbp_comment` (
  `comm_ID` int(11) NOT NULL AUTO_INCREMENT,
  `comm_LogID` int(11) NOT NULL DEFAULT '0',
  `comm_IsChecking` tinyint(4) NOT NULL DEFAULT '0',
  `comm_RootID` int(11) NOT NULL DEFAULT '0',
  `comm_ParentID` int(11) NOT NULL DEFAULT '0',
  `comm_AuthorID` int(11) NOT NULL DEFAULT '0',
  `comm_Name` varchar(250) NOT NULL DEFAULT '',
  `comm_Email` varchar(250) NOT NULL DEFAULT '',
  `comm_HomePage` varchar(250) NOT NULL DEFAULT '',
  `comm_Content` text NOT NULL,
  `comm_PostTime` int(11) NOT NULL DEFAULT '0',
  `comm_IP` varchar(250) NOT NULL DEFAULT '',
  `comm_Agent` text NOT NULL,
  `comm_Meta` longtext NOT NULL,
  PRIMARY KEY (`comm_ID`),
  KEY `zbp_comm_LRI` (`comm_LogID`,`comm_RootID`,`comm_IsChecking`),
  KEY `zbp_comm_IsChecking` (`comm_IsChecking`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `zbp_config`
--

DROP TABLE IF EXISTS `zbp_config`;
CREATE TABLE IF NOT EXISTS `zbp_config` (
  `conf_ID` int(11) NOT NULL AUTO_INCREMENT,
  `conf_Name` varchar(250) NOT NULL DEFAULT '',
  `conf_Key` varchar(250) NOT NULL DEFAULT '',
  `conf_Value` longtext NOT NULL,
  PRIMARY KEY (`conf_ID`),
  KEY `zbp_conf_Name` (`conf_Name`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `zbp_config`
--

INSERT INTO `zbp_config` (`conf_ID`, `conf_Name`, `conf_Key`, `conf_Value`) VALUES
(1, 'cache', 'sidebars_default', 's:142:\"{\"1\":\"calendar|controlpanel|catalog|searchpanel|comments|archives|favorite|link|misc\",\"2\":\"\",\"3\":\"\",\"4\":\"\",\"5\":\"\",\"6\":\"\",\"7\":\"\",\"8\":\"\",\"9\":\"\"}\";'),
(2, 'cache', 'sidebars_Zit', 's:196:\"{\"1\":\"calendar|archives|controlpanel|catalog|favorite|link|misc\",\"2\":\"calendar|catalog|archives|previous\",\"3\":\"catalog|previous|comments\",\"4\":\"comments\",\"5\":\"comments\",\"6\":\"\",\"7\":\"\",\"8\":\"\",\"9\":\"\"}\";'),
(3, 'cache', 'sidebars_tpure', 's:135:\"{\"1\":\"controlpanel|catalog|comments\",\"2\":\"previous|tags\",\"3\":\"catalog|tags|comments\",\"4\":\"tags\",\"5\":\"tags\",\"6\":\"\",\"7\":\"\",\"8\":\"\",\"9\":\"\"}\";'),
(4, 'cache', 'sidebars_WhitePage', 's:135:\"{\"1\":\"controlpanel|catalog|comments\",\"2\":\"previous|tags\",\"3\":\"catalog|tags|comments\",\"4\":\"tags\",\"5\":\"tags\",\"6\":\"\",\"7\":\"\",\"8\":\"\",\"9\":\"\"}\";'),
(5, 'system', 'ZC_CLOSE_SITE', 'b:0;'),
(6, 'system', 'ZC_BLOG_HOST', 's:56:\"h|t|t|p|s|:|/|/|t|e|s|t|.|z|d|e|v|o|.|c|o|m|/|t|e|s|t|/|\";'),
(7, 'system', 'ZC_BLOG_NAME', 's:5:\"ZBLOG\";'),
(8, 'system', 'ZC_BLOG_SUBNAME', 's:17:\"Good Luck To You!\";'),
(9, 'system', 'ZC_BLOG_THEME', 's:7:\"default\";'),
(10, 'system', 'ZC_BLOG_CSS', 's:7:\"default\";'),
(11, 'system', 'ZC_BLOG_COPYRIGHT', 's:44:\"Copyright Your WebSite.Some Rights Reserved.\";'),
(12, 'system', 'ZC_BLOG_LANGUAGE', 's:5:\"zh-CN\";'),
(13, 'system', 'ZC_BLOG_LANGUAGEPACK', 's:5:\"zh-cn\";'),
(14, 'system', 'ZC_USING_PLUGIN_LIST', 's:36:\"AppCentre|UEditor|Totoro|LinksManage\";'),
(15, 'system', 'ZC_BLOG_CLSID', concat('s:32:\"',replace(uuid(),'-',''),'\";')),
(16, 'system', 'ZC_TIME_ZONE_NAME', 's:13:\"Asia/Shanghai\";'),
(17, 'system', 'ZC_UPDATE_INFO_URL', 's:32:\"https://update.zblogcn.com/info/\";'),
(18, 'system', 'ZC_PERMANENT_DOMAIN_ENABLE', 'b:0;'),
(19, 'system', 'ZC_PERMANENT_DOMAIN_SHOW', 'b:0;'),
(20, 'system', 'ZC_DEBUG_MODE', 'b:0;'),
(21, 'system', 'ZC_DEBUG_MODE_STRICT', 'b:0;'),
(22, 'system', 'ZC_DEBUG_MODE_WARNING', 'b:1;'),
(23, 'system', 'ZC_DEBUG_LOG_ERROR', 'b:0;'),
(24, 'system', 'ZC_BLOG_PRODUCT', 's:9:\"Z-BlogPHP\";'),
(25, 'system', 'ZC_BLOG_VERSION', 's:18:\"1.7.5 Build 173540\";'),
(26, 'system', 'ZC_BLOG_COMMIT', 's:0:\"\";'),
(27, 'system', 'ZC_BLOG_PRODUCT_FULL', 's:15:\"Z-BlogPHP 1.7.5\";'),
(28, 'system', 'ZC_BLOG_PRODUCT_HTML', 's:101:\"<a href=\"https://www.zblogcn.com/\" title=\"Z-BlogPHP 1.7.5 Build 173540\" target=\"_blank\">Z-BlogPHP</a>\";'),
(29, 'system', 'ZC_BLOG_PRODUCT_FULLHTML', 's:107:\"<a href=\"https://www.zblogcn.com/\" title=\"Z-BlogPHP 1.7.5 Build 173540\" target=\"_blank\">Z-BlogPHP 1.7.5</a>\";'),
(30, 'system', 'ZC_COMMENT_TURNOFF', 'b:0;'),
(31, 'system', 'ZC_COMMENT_VERIFY_ENABLE', 'b:0;'),
(32, 'system', 'ZC_COMMENT_REVERSE_ORDER', 'b:0;'),
(33, 'system', 'ZC_COMMENT_AUDIT', 'b:0;'),
(34, 'system', 'ZC_COMMENT_VALIDCMTKEY_ENABLE', 'b:0;'),
(35, 'system', 'ZC_VERIFYCODE_STRING', 's:29:\"ABCDEFGHKMNPRSTUVWXYZ23456789\";'),
(36, 'system', 'ZC_VERIFYCODE_WIDTH', 'i:90;'),
(37, 'system', 'ZC_VERIFYCODE_HEIGHT', 'i:30;'),
(38, 'system', 'ZC_VERIFYCODE_FONT', 's:26:\"zb_system/defend/arial.ttf\";'),
(39, 'system', 'ZC_DISPLAY_COUNT', 'i:10;'),
(40, 'system', 'ZC_PAGEBAR_COUNT', 'i:10;'),
(41, 'system', 'ZC_COMMENTS_DISPLAY_COUNT', 'i:100;'),
(42, 'system', 'ZC_DISPLAY_SUBCATEGORYS', 'b:1;'),
(43, 'system', 'ZC_RSS2_COUNT', 'i:10;'),
(44, 'system', 'ZC_RSS_EXPORT_WHOLE', 'b:1;'),
(45, 'system', 'ZC_MANAGE_COUNT', 'i:50;'),
(46, 'system', 'ZC_EMOTICONS_FILENAME', 's:4:\"face\";'),
(47, 'system', 'ZC_EMOTICONS_FILETYPE', 's:11:\"png|gif|jpg\";'),
(48, 'system', 'ZC_EMOTICONS_FILESIZE', 's:2:\"16\";'),
(49, 'system', 'ZC_UPLOAD_FILETYPE', 's:219:\"jpg|gif|png|jpeg|bmp|webp|psd|wmf|ico|rpm|deb|tar|gz|xz|sit|7z|bz2|zip|rar|xml|xsl|svg|svgz|rtf|doc|docx|ppt|pptx|xls|xlsx|wps|chm|txt|md|pdf|mp3|flac|ape|mp4|mkv|avi|mpg|rm|ra|rmvb|mov|wmv|wma|torrent|apk|json|zba|gzba\";'),
(50, 'system', 'ZC_UPLOAD_FILESIZE', 'i:2;'),
(51, 'system', 'ZC_UPLOAD_DIR_YEARMONTHDAY', 'b:0;'),
(52, 'system', 'ZC_USERNAME_MIN', 'i:2;'),
(53, 'system', 'ZC_USERNAME_MAX', 'i:50;'),
(54, 'system', 'ZC_PASSWORD_MIN', 'i:8;'),
(55, 'system', 'ZC_PASSWORD_MAX', 'i:20;'),
(56, 'system', 'ZC_EMAIL_MAX', 'i:50;'),
(57, 'system', 'ZC_HOMEPAGE_MAX', 'i:100;'),
(58, 'system', 'ZC_CONTENT_MAX', 'i:1000;'),
(59, 'system', 'ZC_ARTICLE_TITLE_MAX', 'i:100;'),
(60, 'system', 'ZC_CATEGORY_NAME_MAX', 'i:50;'),
(61, 'system', 'ZC_TAGS_NAME_MAX', 'i:50;'),
(62, 'system', 'ZC_MODULE_NAME_MAX', 'i:50;'),
(63, 'system', 'ZC_ARTICLE_EXCERPT_MAX', 'i:250;'),
(64, 'system', 'ZC_ARTICLE_INTRO_WITH_TEXT', 's:1:\"0\";'),
(65, 'system', 'ZC_COMMENT_EXCERPT_MAX', 'i:20;'),
(66, 'system', 'ZC_STATIC_MODE', 's:6:\"ACTIVE\";'),
(67, 'system', 'ZC_ARTICLE_REGEX', 's:18:\"{%host%}?id={%id%}\";'),
(68, 'system', 'ZC_PAGE_REGEX', 's:18:\"{%host%}?id={%id%}\";'),
(69, 'system', 'ZC_CATEGORY_REGEX', 's:34:\"{%host%}?cate={%id%}&page={%page%}\";'),
(70, 'system', 'ZC_AUTHOR_REGEX', 's:34:\"{%host%}?auth={%id%}&page={%page%}\";'),
(71, 'system', 'ZC_TAGS_REGEX', 's:34:\"{%host%}?tags={%id%}&page={%page%}\";'),
(72, 'system', 'ZC_DATE_REGEX', 's:36:\"{%host%}?date={%date%}&page={%page%}\";'),
(73, 'system', 'ZC_INDEX_REGEX', 's:22:\"{%host%}?page={%page%}\";'),
(74, 'system', 'ZC_ALIAS_BACK_ATTR', 's:4:\"Name\";'),
(75, 'system', 'ZC_DATETIME_SEPARATOR', 's:1:\"-\";'),
(76, 'system', 'ZC_DATETIME_RULE', 's:3:\"Y-n\";'),
(77, 'system', 'ZC_DATETIME_WITHDAY_RULE', 's:5:\"Y-n-j\";'),
(78, 'system', 'ZC_SEARCH_COUNT', 'i:20;'),
(79, 'system', 'ZC_SEARCH_REGEX', 's:40:\"{%host%}search.php?q={%q%}&page={%page%}\";'),
(80, 'system', 'ZC_INDEX_DEFAULT_TEMPLATE', 's:5:\"index\";'),
(81, 'system', 'ZC_POST_DEFAULT_TEMPLATE', 's:6:\"single\";'),
(82, 'system', 'ZC_SEARCH_DEFAULT_TEMPLATE', 's:6:\"search\";'),
(83, 'system', 'ZC_SIDEBAR_ORDER', 's:78:\"calendar|controlpanel|catalog|searchpanel|comments|archives|favorite|link|misc\";'),
(84, 'system', 'ZC_SIDEBAR2_ORDER', 's:0:\"\";'),
(85, 'system', 'ZC_SIDEBAR3_ORDER', 's:0:\"\";'),
(86, 'system', 'ZC_SIDEBAR4_ORDER', 's:0:\"\";'),
(87, 'system', 'ZC_SIDEBAR5_ORDER', 's:0:\"\";'),
(88, 'system', 'ZC_SIDEBAR6_ORDER', 's:0:\"\";'),
(89, 'system', 'ZC_SIDEBAR7_ORDER', 's:0:\"\";'),
(90, 'system', 'ZC_SIDEBAR8_ORDER', 's:0:\"\";'),
(91, 'system', 'ZC_SIDEBAR9_ORDER', 's:0:\"\";'),
(92, 'system', 'ZC_SYNTAXHIGHLIGHTER_ENABLE', 'b:1;'),
(93, 'system', 'ZC_CODEMIRROR_ENABLE', 'b:1;'),
(94, 'system', 'ZC_ALLOW_AUDITTING_MEMBER_VISIT_MANAGE', 'b:0;'),
(95, 'system', 'ZC_CATEGORY_MANAGE_LEGACY_DISPLAY', 'b:1;'),
(96, 'system', 'ZC_GZIP_ENABLE', 'b:0;'),
(97, 'system', 'ZC_ADMIN_HTML5_ENABLE', 'b:1;'),
(98, 'system', 'ZC_LOADMEMBERS_LEVEL', 'i:1;'),
(99, 'system', 'ZC_LAST_VERSION', 's:6:\"173000\";'),
(100, 'system', 'ZC_MODULE_CATALOG_STYLE', 'i:0;'),
(101, 'system', 'ZC_MODULE_ARCHIVES_STYLE', 'i:0;'),
(102, 'system', 'ZC_VIEWNUMS_TURNOFF', 'b:0;'),
(103, 'system', 'ZC_LISTONTOP_TURNOFF', 'b:0;'),
(104, 'system', 'ZC_RELATEDLIST_COUNT', 'i:10;'),
(105, 'system', 'ZC_RUNINFO_DISPLAY', 'b:1;'),
(106, 'system', 'ZC_POST_ALIAS_USE_ID_NOT_TITLE', 'b:0;'),
(107, 'system', 'ZC_COMPATIBLE_ASP_URL', 'b:1;'),
(108, 'system', 'ZC_LARGE_DATA', 'b:0;'),
(109, 'system', 'ZC_VERSION_IN_HEADER', 'b:1;'),
(110, 'system', 'ZC_ADDITIONAL_SECURITY', 'b:1;'),
(111, 'system', 'ZC_XMLRPC_ENABLE', 'b:0;'),
(112, 'system', 'ZC_XMLRPC_USE_WEBTOKEN', 'b:0;'),
(113, 'system', 'ZC_USING_CDN_GUESTIP_TYPE', 's:11:\"REMOTE_ADDR\";'),
(114, 'system', 'ZC_POST_BATCH_DELETE', 'b:0;'),
(115, 'system', 'ZC_JS_304_ENABLE', 'b:1;'),
(116, 'system', 'ZC_API_ENABLE', 'b:0;'),
(117, 'system', 'ZC_API_THROTTLE_ENABLE', 'b:0;'),
(118, 'system', 'ZC_API_THROTTLE_MAX_REQS_PER_MIN', 'i:60;'),
(119, 'system', 'ZC_NOW_VERSION', 's:6:\"173050\";'),
(120, 'cache', 'templates_md5', 's:32:\"81f84c2124ebe3d3ffea9b3397f6ea67\";'),
(121, 'AppCentre', 'enabledcheck', 'i:1;'),
(122, 'AppCentre', 'checkbeta', 'i:0;'),
(123, 'AppCentre', 'enabledevelop', 'i:0;'),
(124, 'AppCentre', 'enablegzipapp', 'i:0;'),
(125, 'AppCentre', 'lastchecktime', 'i:1620281830;'),
(126, 'cache', 'success_updated_app', 's:0:\"\";'),
(127, 'cache', 'normal_article_nums', 's:1:\"1\";'),
(128, 'cache', 'top_post_array_0', 's:6:\"a:0:{}\";'),
(129, 'cache', 'all_comment_nums', 'i:0;'),
(130, 'cache', 'check_comment_nums', 's:1:\"0\";'),
(131, 'cache', 'normal_comment_nums', 'i:0;'),
(132, 'cache', 'reload_statistic', 's:1067:\"<!--debug_mode_note--><tr><td class=\'td20\'>当前用户</td><td class=\'td30\'><a href=\'../cmd.php?act=misc&type=vrs\' target=\'_blank\'>{$zbp->user->Name}</a></td><td class=\'td20\'>当前版本</td><td class=\'td30\'>{$zbp->version}</td></tr><tr><td class=\'td20\'>文章总数</td><td>1</td><td>分类总数</td><td>1</td></tr><tr><td class=\'td20\'>页面总数</td><td>1</td><td>标签总数</td><td>0</td></tr><tr><td class=\'td20\'>评论总数</td><td>0</td><td>浏览总数</td><td>0</td></tr><tr><td class=\'td20\'>当前主题</td><td>{$zbp->theme}/{$zbp->style} {$theme_version}</td><td>用户总数</td><td>1</td></tr><!--debug_mode_moreinfo--><tr><td class=\'td20\'>协议地址</td><td><a href=\"{#ZC_BLOG_HOST#}zb_system/api.php\" target=\"_blank\">API地址</a> , <a href=\"{#ZC_BLOG_HOST#}zb_system/xml-rpc/index.php\" target=\"_blank\">XML-RPC地址</a></td><td>系统环境</td><td><a href=\'../cmd.php?act=misc&type=phpinfo\' target=\'_blank\'>{$system_environment}</a></td></tr><script type=\"text/javascript\">$(\'#statistic\').attr(\'title\',\'2021-05-06T14:17:10+08:00\');</script>\";'),
(133, 'cache', 'reload_statistic_time', 'i:1620281830;'),
(134, 'cache', 'system_environment', 's:72:\"WINNT10.0; IIS10.0; PHP8.0.3x64; mysqli5.7.30; curl7.75.0; OpenSSL1.1.1j\";'),
(135, 'cache', 'all_article_nums', 's:1:\"1\";'),
(136, 'cache', 'all_page_nums', 's:1:\"1\";'),
(137, 'cache', 'all_category_nums', 's:1:\"1\";'),
(138, 'cache', 'all_view_nums', 's:1:\"0\";'),
(139, 'cache', 'all_tag_nums', 's:1:\"0\";'),
(140, 'cache', 'all_member_nums', 's:1:\"1\";'),
(141, 'cache', 'reload_updateinfo', 's:1956:\"<tr><td><p><a href=\"https://blog.zblogcn.com/2021/05/04/121/\" target=\"_blank\">只需三步，快速在 Serverless 架构部署 Z-BlogPHP 博客 (2021-5-4)</a></p>\r\n\r\n<p><a href=\"https://blog.zblogcn.com/2021/04/10/122/\" target=\"_blank\"><b>Z-BlogPHP 1.7 Tenet 终于发布了 (2021-4-10)</b></a></p>\r\n\r\n<p><a href=\"https://blog.zblogcn.com/2021/01/28/119/\" target=\"_blank\">紧急公告：Z-Blog用户中心域名切换通知 (2021-1-28)</a></p>\r\n\r\n<p><a href=\"https://blog.zblogcn.com/2020/10/24/114/\" target=\"_blank\">ZBLOG应用中心“工单系统”上线了！ (2020-10-24)</a></p>\r\n\r\n<p>[Wiki]  \r\n<a href=\"https://wiki.zblogcn.com/doku.php?id=zblogphp:changelog\" target=\"_blank\">ZBlogPHP详细更新日志</a>\r\n    \r\n<a href=\"https://wiki.zblogcn.com/doku.php?id=zblogphp:development\" target=\"_blank\">ZBlogPHP应用开发指南</a>\r\n    \r\n<a href=\"https://wiki.zblogcn.com/doku.php?id=zblogphp:development:migration:1.5_-_1.6\" target=\"_blank\">开发者更新指南</a>\r\n</p>\r\n\r\n<p>[故障处理]  \r\n<a href=\"https://wiki.zblogcn.com/doku.php?id=zblogphp:failure:forgetpassword\" target=\"_blank\">ZBlogPHP密码找回工具</a>\r\n    \r\n<a href=\"https://wiki.zblogcn.com/doku.php?id=zblogphp:failure:permanentdomainerror\" target=\"_blank\">固定域名出错</a>\r\n    \r\n<a href=\"https://wiki.zblogcn.com/doku.php?id=zblogphp:failure:cannotemoji\" target=\"_blank\">不能发Emoji表情</a>\r\n</p>\r\n\r\n<p><a href=\"https://blog.zblogcn.com/2018/02/12/99/\" target=\"_blank\">大吉大利，天天吃鸡——Z-Blog祝您2018新春快乐，应用中心红包活动开始了！ (2018-2-12)</a></p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n<p><a href=\"https://bbs.zblogcn.com/thread-83785-1-1.html\" target=\"_blank\">2014年ASP版全新发布！Z-Blog 2.2 Prism Build 140101 发布了。(2014-01-02)</a></p>\r\n\r\n<p><a href=\"https://bbs.zblogcn.com/thread-77001-1-1.html\" target=\"_blank\">Z-Blog应用中心正式上线，欢迎开发者进驻。(2013-01-01)</a></p></td></tr>\";'),
(142, 'cache', 'reload_updateinfo_time', 'i:1620281849;');

-- --------------------------------------------------------

--
-- 表的结构 `zbp_member`
--

DROP TABLE IF EXISTS `zbp_member`;
CREATE TABLE IF NOT EXISTS `zbp_member` (
  `mem_ID` int(11) NOT NULL AUTO_INCREMENT,
  `mem_Guid` varchar(36) NOT NULL DEFAULT '',
  `mem_Level` tinyint(4) NOT NULL DEFAULT '0',
  `mem_Status` tinyint(4) NOT NULL DEFAULT '0',
  `mem_Name` varchar(250) NOT NULL DEFAULT '',
  `mem_Password` varchar(250) NOT NULL DEFAULT '',
  `mem_Email` varchar(250) NOT NULL DEFAULT '',
  `mem_HomePage` varchar(250) NOT NULL DEFAULT '',
  `mem_IP` varchar(250) NOT NULL DEFAULT '',
  `mem_CreateTime` int(11) NOT NULL DEFAULT '0',
  `mem_PostTime` int(11) NOT NULL DEFAULT '0',
  `mem_UpdateTime` int(11) NOT NULL DEFAULT '0',
  `mem_Alias` varchar(250) NOT NULL DEFAULT '',
  `mem_Intro` text NOT NULL,
  `mem_Articles` int(11) NOT NULL DEFAULT '0',
  `mem_Pages` int(11) NOT NULL DEFAULT '0',
  `mem_Comments` int(11) NOT NULL DEFAULT '0',
  `mem_Uploads` int(11) NOT NULL DEFAULT '0',
  `mem_Template` varchar(250) NOT NULL DEFAULT '',
  `mem_Meta` longtext NOT NULL,
  PRIMARY KEY (`mem_ID`),
  KEY `zbp_mem_Name` (`mem_Name`),
  KEY `zbp_mem_Alias` (`mem_Alias`),
  KEY `zbp_mem_Level` (`mem_Level`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `zbp_member`
--

INSERT INTO `zbp_member` (`mem_ID`, `mem_Guid`, `mem_Level`, `mem_Status`, `mem_Name`, `mem_Password`, `mem_Email`, `mem_HomePage`, `mem_IP`, `mem_CreateTime`, `mem_PostTime`, `mem_UpdateTime`, `mem_Alias`, `mem_Intro`, `mem_Articles`, `mem_Pages`, `mem_Comments`, `mem_Uploads`, `mem_Template`, `mem_Meta`) VALUES
(1, '994429f09591f493de341d0ddfa2f200', 1, 0, 'admin', 'c61667e98ca0c0071fc88d9e3baa5413', 'null@null.com', '', '192.168.1.11', 1620281819, 1620281819, 0, '', '', 0, 0, 0, 0, '', '');
update `zbp_member` set `mem_Guid` = replace(uuid(),'-','') where `mem_ID` = 1;
update `zbp_member` set `mem_Password` = md5(concat(md5('zblogger'),`mem_Guid`)) where `mem_ID` = 1;

-- --------------------------------------------------------

--
-- 表的结构 `zbp_module`
--

DROP TABLE IF EXISTS `zbp_module`;
CREATE TABLE IF NOT EXISTS `zbp_module` (
  `mod_ID` int(11) NOT NULL AUTO_INCREMENT,
  `mod_Name` varchar(250) NOT NULL DEFAULT '',
  `mod_FileName` varchar(250) NOT NULL DEFAULT '',
  `mod_Content` text NOT NULL,
  `mod_SidebarID` int(11) NOT NULL DEFAULT '0',
  `mod_HtmlID` varchar(250) NOT NULL DEFAULT '',
  `mod_Type` varchar(5) NOT NULL DEFAULT '',
  `mod_MaxLi` int(11) NOT NULL DEFAULT '0',
  `mod_Source` varchar(250) NOT NULL DEFAULT '',
  `mod_IsHideTitle` tinyint(4) NOT NULL DEFAULT '0',
  `mod_Meta` longtext NOT NULL,
  PRIMARY KEY (`mod_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `zbp_module`
--

INSERT INTO `zbp_module` (`mod_ID`, `mod_Name`, `mod_FileName`, `mod_Content`, `mod_SidebarID`, `mod_HtmlID`, `mod_Type`, `mod_MaxLi`, `mod_Source`, `mod_IsHideTitle`, `mod_Meta`) VALUES
(1, '导航栏', 'navbar', '<li id=\"nvabar-item-index\"><a href=\"{#ZC_BLOG_HOST#}\">首页</a></li><li id=\"navbar-page-2\"><a href=\"{#ZC_BLOG_HOST#}?id=2\">留言本</a></li>', 0, 'divNavBar', 'ul', 0, 'system', 0, ''),
(2, '日历', 'calendar', '<table id=\"tbCalendar\">\r\n    <caption><a title=\"上个月\" href=\"{#ZC_BLOG_HOST#}?date=2021-4\">«</a>&nbsp;&nbsp;&nbsp;<a href=\"{#ZC_BLOG_HOST#}?date=2021-5\">\r\n    2021年5月    </a>&nbsp;&nbsp;&nbsp;<a title=\"下个月\" href=\"{#ZC_BLOG_HOST#}?date=2021-6\">»</a></caption>\r\n    <thead><tr> <th title=\"星期一\" scope=\"col\"><small>一</small></th> <th title=\"星期二\" scope=\"col\"><small>二</small></th> <th title=\"星期三\" scope=\"col\"><small>三</small></th> <th title=\"星期四\" scope=\"col\"><small>四</small></th> <th title=\"星期五\" scope=\"col\"><small>五</small></th> <th title=\"星期六\" scope=\"col\"><small>六</small></th> <th title=\"星期日\" scope=\"col\"><small>日</small></th></tr></thead>\r\n    <tbody>\r\n        <tr><td></td><td></td><td></td><td></td><td></td><td>1</td><td>2</td></tr>\r\n    <tr><td>3</td><td>4</td><td>5</td><td><a href=\"{#ZC_BLOG_HOST#}?date=2021-5-6\" title=\"2021-5-6 (1)\" target=\"_blank\">6</a></td><td>7</td><td>8</td><td>9</td></tr>\r\n    <tr><td>10</td><td>11</td><td>12</td><td>13</td><td>14</td><td>15</td><td>16</td></tr>\r\n    <tr><td>17</td><td>18</td><td>19</td><td>20</td><td>21</td><td>22</td><td>23</td></tr>\r\n    <tr><td>24</td><td>25</td><td>26</td><td>27</td><td>28</td><td>29</td><td>30</td></tr>\r\n    <tr><td>31</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>\r\n    	</tbody>\r\n</table>', 0, 'divCalendar', 'div', 0, 'system', 1, ''),
(3, '控制面板', 'controlpanel', '<span class=\"cp-hello\">您好，欢迎到访网站！</span><br/><span class=\"cp-login\"><a href=\"{#ZC_BLOG_HOST#}zb_system/cmd.php?act=login\">登录后台</a></span>&nbsp;&nbsp;<span class=\"cp-vrs\"><a href=\"{#ZC_BLOG_HOST#}zb_system/cmd.php?act=misc&amp;type=vrs\">查看权限</a></span>', 0, 'divContorPanel', 'div', 0, 'system', 0, ''),
(4, '网站分类', 'catalog', '<li><a title=\"未分类\" href=\"{#ZC_BLOG_HOST#}?cate=1\">未分类</a></li>\r\n', 0, 'divCatalog', 'ul', 0, 'system', 0, ''),
(5, '搜索', 'searchpanel', '<form name=\"search\" method=\"post\" action=\"{#ZC_BLOG_HOST#}zb_system/cmd.php?act=search\"><input type=\"text\" name=\"q\" size=\"11\" /> <input type=\"submit\" value=\"搜索\" /></form>', 0, 'divSearchPanel', 'div', 0, 'system', 0, ''),
(6, '最新留言', 'comments', '', 0, 'divComments', 'ul', 0, 'system', 0, ''),
(7, '文章归档', 'archives', '<li><a title=\"2021年5月\" href=\"{#ZC_BLOG_HOST#}?date=2021-5\">2021年5月 (1)</a></li>\r\n', 0, 'divArchives', 'ul', 0, 'system', 0, ''),
(8, '站点信息', 'statistics', '<li>文章总数:1</li>\r\n<li>页面总数:1</li>\r\n<li>分类总数:1</li>\r\n<li>标签总数:0</li>\r\n<li>评论总数:0</li>\r\n<li>浏览总数:0</li>\r\n', 0, 'divStatistics', 'ul', 0, 'system', 0, ''),
(9, '网站收藏', 'favorite', '<li><a href=\"https://app.zblogcn.com/\" target=\"_blank\">Z-Blog应用中心</a></li><li><a href=\"https://bbs.zblogcn.com/\" target=\"_blank\">ZBlogger社区</a></li><li><a href=\"https://z5encrypt.com/\" target=\"_blank\" title=\"全新的PHP加密方案，致力于PHP源码的保护\">Z5 PHP加密</a></li>', 0, 'divFavorites', 'ul', 0, 'system', 0, ''),
(10, '友情链接', 'link', '<li><a href=\"https://github.com/zblogcn\" target=\"_blank\" title=\"Z-Blog on Github\">Z-Blog on Github</a></li><li><a href=\"https://zbloghost.cn/\" target=\"_blank\" title=\"Z-Blog官方主机\">Z-Blog主机</a></li>', 0, 'divLinkage', 'ul', 0, 'system', 0, ''),
(11, '作者列表', 'authors', '<li><a title=\"admin\" href=\"{#ZC_BLOG_HOST#}?auth=1\">admin<span class=\"article-nums\"> (0)</span></a></li>\r\n', 0, 'divAuthors', 'ul', 0, 'system', 0, ''),
(12, '最近发表', 'previous', '<li><a title=\"欢迎在宝塔面板安装Z-BlogPHP！\" href=\"{#ZC_BLOG_HOST#}?id=1\">欢迎在宝塔面板安装Z-BlogPHP！</a></li>\r\n', 0, 'divPrevious', 'ul', 0, 'system', 0, ''),
(13, '标签列表', 'tags', '', 0, 'divTags', 'ul', 0, 'system', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `zbp_post`
--

DROP TABLE IF EXISTS `zbp_post`;
CREATE TABLE IF NOT EXISTS `zbp_post` (
  `log_ID` int(11) NOT NULL AUTO_INCREMENT,
  `log_CateID` int(11) NOT NULL DEFAULT '0',
  `log_AuthorID` int(11) NOT NULL DEFAULT '0',
  `log_Tag` varchar(250) NOT NULL DEFAULT '',
  `log_Status` tinyint(4) NOT NULL DEFAULT '0',
  `log_Type` int(11) NOT NULL DEFAULT '0',
  `log_Alias` varchar(250) NOT NULL DEFAULT '',
  `log_IsTop` tinyint(4) NOT NULL DEFAULT '0',
  `log_IsLock` tinyint(4) NOT NULL DEFAULT '0',
  `log_Title` varchar(250) NOT NULL DEFAULT '',
  `log_Intro` text NOT NULL,
  `log_Content` longtext NOT NULL,
  `log_CreateTime` int(11) NOT NULL DEFAULT '0',
  `log_PostTime` int(11) NOT NULL DEFAULT '0',
  `log_UpdateTime` int(11) NOT NULL DEFAULT '0',
  `log_CommNums` int(11) NOT NULL DEFAULT '0',
  `log_ViewNums` int(11) NOT NULL DEFAULT '0',
  `log_Template` varchar(250) NOT NULL DEFAULT '',
  `log_Meta` longtext NOT NULL,
  PRIMARY KEY (`log_ID`),
  KEY `zbp_log_TPISC` (`log_Type`,`log_PostTime`,`log_IsTop`,`log_Status`,`log_CateID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `zbp_post`
--

INSERT INTO `zbp_post` (`log_ID`, `log_CateID`, `log_AuthorID`, `log_Tag`, `log_Status`, `log_Type`, `log_Alias`, `log_IsTop`, `log_IsLock`, `log_Title`, `log_Intro`, `log_Content`, `log_CreateTime`, `log_PostTime`, `log_UpdateTime`, `log_CommNums`, `log_ViewNums`, `log_Template`, `log_Meta`) VALUES
(1, 1, 1, '', 0, 0, '', 0, 0, '欢迎在宝塔面板安装Z-BlogPHP！', '<p>\r\n    <strong>管理员账号：admin</strong>\r\n</p>\r\n<p>\r\n    <br/>\r\n</p>\r\n<p>\r\n    <strong>管理员密码：zblogger</strong>\r\n</p><br/>\r\n<p><strong>请安装成功后登入后台更改初始化的密码为安全密码！</strong></p>', '<p><strong>管理员账号：admin</strong></p><p><br/></p><p><strong>管理员密码：zblogger</strong></p><br/>\r\n<p><strong>请安装成功后登入后台更改初始化的密码为安全密码！</strong></p>', 1620281819, 1620281819, 1620281915, 0, 0, '', ''),
(2, 0, 1, '', 0, 1, '', 0, 0, '留言本', '', '这是一个留言本，是由程序自动生成的页面，您可以对其进行任意操作。', 1620281819, 1620281819, 1620281819, 0, 0, '', '');

-- --------------------------------------------------------

--
-- 表的结构 `zbp_tag`
--

DROP TABLE IF EXISTS `zbp_tag`;
CREATE TABLE IF NOT EXISTS `zbp_tag` (
  `tag_ID` int(11) NOT NULL AUTO_INCREMENT,
  `tag_Name` varchar(250) NOT NULL DEFAULT '',
  `tag_Order` int(11) NOT NULL DEFAULT '0',
  `tag_Type` int(11) NOT NULL DEFAULT '0',
  `tag_Count` int(11) NOT NULL DEFAULT '0',
  `tag_Alias` varchar(250) NOT NULL DEFAULT '',
  `tag_Group` varchar(250) NOT NULL DEFAULT '',
  `tag_Intro` text NOT NULL,
  `tag_CreateTime` int(11) NOT NULL DEFAULT '0',
  `tag_PostTime` int(11) NOT NULL DEFAULT '0',
  `tag_UpdateTime` int(11) NOT NULL DEFAULT '0',
  `tag_Template` varchar(250) NOT NULL DEFAULT '',
  `tag_Meta` longtext NOT NULL,
  PRIMARY KEY (`tag_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `zbp_upload`
--

DROP TABLE IF EXISTS `zbp_upload`;
CREATE TABLE IF NOT EXISTS `zbp_upload` (
  `ul_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ul_AuthorID` int(11) NOT NULL DEFAULT '0',
  `ul_Size` int(11) NOT NULL DEFAULT '0',
  `ul_Name` varchar(250) NOT NULL DEFAULT '',
  `ul_SourceName` varchar(250) NOT NULL DEFAULT '',
  `ul_MimeType` varchar(250) NOT NULL DEFAULT '',
  `ul_PostTime` int(11) NOT NULL DEFAULT '0',
  `ul_DownNums` int(11) NOT NULL DEFAULT '0',
  `ul_LogID` int(11) NOT NULL DEFAULT '0',
  `ul_Intro` text NOT NULL,
  `ul_Meta` longtext NOT NULL,
  PRIMARY KEY (`ul_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
