<?php
RegisterPlugin("yt_snow","ActivePlugin_yt_snow");
function ActivePlugin_yt_snow() {
    global $zbp;
    Add_Filter_Plugin('Filter_Plugin_Index_Begin', 'yt_snow_js');
}
function yt_snow_js() {
    global $zbp;
    $on=(int)$zbp->Config('yt_snow')->enable;
    if ($on) {
        $effect_type=$zbp->Config('yt_snow')->effect_type;
        if ($effect_type === 'snow') {
            $config = $zbp->Config('yt_snow');
            $targets = $config->targets ?? '';
            if (!empty($targets)) {
                $selectors = explode(',', $targets);
                $parents = [];
                $snows = [];
                
                foreach ($selectors as $s) {
                    $s = trim($s);
                    if (!empty($s)) {
                        $parents[] = $s;
                        $snows[] = $s . '::before';
                    }
                }
                
                if (!empty($snows)) {
                    $parent_selector = implode(',', $parents);
                    $snow_selector = implode(',', $snows);
                    $plugin_url = $zbp->host . 'zb_users/plugin/yt_snow';
                    $zbp->footer.="<style>{$parent_selector} {position: relative !important;overflow: visible !important;}{$snow_selector} {content: '';display: block;position: absolute;top: -10px;left: 0;right: 0;height: 23px;z-index: 1055;pointer-events: none;background: url({$plugin_url}/images/snow1.png) no-repeat 0 0,url({$plugin_url}/images/snow2.png) no-repeat 50% 0,url({$plugin_url}/images/snow3.png) no-repeat 100% 0;}</style>";
                }
            }
        }

        
        $config_data = array(
            'enable' => true,
            'count' => (int)($zbp->Config('yt_snow')->count ?? 100),
            'speed_min' => (int)($zbp->Config('yt_snow')->speed_min ?? 1),
            'speed_max' => (int)($zbp->Config('yt_snow')->speed_max ?? 3),
            'size_min' => (int)($zbp->Config('yt_snow')->size_min ?? 2),
            'size_max' => (int)($zbp->Config('yt_snow')->size_max ?? 5),
            'color' => $zbp->Config('yt_snow')->color ?? '#ffffff',
            'opacity_min' => (float)($zbp->Config('yt_snow')->opacity_min ?? 0.3),
            'opacity_max' => (float)($zbp->Config('yt_snow')->opacity_max ?? 0.8),
            'wind' => (float)($zbp->Config('yt_snow')->wind ?? 0),
            'sway' => (bool)($zbp->Config('yt_snow')->sway ?? true),
            'interaction' => (bool)($zbp->Config('yt_snow')->interaction ?? true),
            'z_index' => (int)($zbp->Config('yt_snow')->z_index ?? 999999)
        );
        
        $json_config = json_encode($config_data);

        $script_url = $zbp->host . 'zb_users/plugin/yt_snow/'.$effect_type.'.js';

        
        $zbp->footer .= "<script>window.ytConfig = {$json_config};</script>";
        $zbp->footer .= "<script src='{$script_url}'></script>";
    }
}
function InstallPlugin_yt_snow() {
    global $zbp;
    if (!$zbp->Config('yt_snow')->HasKey('enable')) {
        $zbp->Config('yt_snow')->enable = '1';
        $zbp->Config('yt_snow')->effect_type = 'spring';
        $zbp->Config('yt_snow')->count = '50';
        $zbp->Config('yt_snow')->speed_min = '5';
        $zbp->Config('yt_snow')->speed_max = '15';
        $zbp->Config('yt_snow')->size_min = '2';
        $zbp->Config('yt_snow')->size_max = '8';
        $zbp->Config('yt_snow')->targets = '.sidebox';
        $zbp->SaveConfig('yt_snow');
    }
}
function UninstallPlugin_yt_snow() {
    global $zbp;
    $zbp->DelConfig('yt_snow');
}