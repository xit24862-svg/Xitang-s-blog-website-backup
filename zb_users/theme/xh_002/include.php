<?php
RegisterPlugin("xh_002", "ActivePlugin_xh_002");

function ActivePlugin_xh_002()
{

}

function InstallPlugin_xh_002()
{
    global $zbp;
    if (!$zbp->Config('xh_002')) { # $zbp->hasConfig('xh_002')
        $zbp->Config('xh_002')->language = "zh-CN";# <html lang="zh-CN"> 中文简体/zh-CN 中文繁体（台湾）/zh-TW  中文繁体（香港）/zh-HK  英文/en
        $zbp->SaveConfig('xh_002');
    }
}

function UninstallPlugin_xh_002()
{

}


include_once __DIR__ . '/tool/zbb_tool.php';
