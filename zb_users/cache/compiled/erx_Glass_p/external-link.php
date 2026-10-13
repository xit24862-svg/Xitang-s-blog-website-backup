
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="robots" content="none" />
    <meta name="viewport" content="width=device-width,viewport-fit=cover" />
    <meta name="generator" content="<?php  echo $option['ZC_BLOG_PRODUCT_FULL'];  ?>" />
    <meta name="renderer" content="webkit" />
    <link rel="stylesheet" href="<?php  echo $host;  ?>zb_system/image/icon/icon.css" />
	<script src="<?php  echo $host;  ?>zb_system/script/jquery-latest.min.js?v=<?php  echo $version;  ?>"></script>
	<script src="<?php  echo $host;  ?>zb_system/script/zblogphp.js?v=<?php  echo $version;  ?>"></script>
	<script src="<?php  echo $host;  ?>zb_system/script/c_html_js_add.php?hash=<?php  echo $html_js_hash;  ?>&v=<?php  echo $version;  ?>"></script>
    <title><?php  echo $name;  ?> - <?php  echo $lang['msg']['external_link_about_to_leave'];  ?></title>

    <style>
        body,
        h1,
        p {
            margin: 0;
            padding: 0;
        }

        a {
            text-decoration: none;
        }

        button {
            padding: 0;
            font-family: inherit;
            background: none;
            border: none;
            outline: none;
            cursor: pointer;
        }

        html {
            width: 100%;
            height: 100%;
            background-color: #eff0f2;
        }

        body {
            padding-top: 100px;
            color: #222;
            font-size: 15px;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.5;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }

        .info {
            padding: 12px;
            background: #f7f8f9;
            color: #a3a3a3;
            line-height: 1.6;
        }

        .link {
            color: #3a6ea5;
        }

        .link span, .link i, .info span, .info i {
            vertical-align: middle;
        }

        @media (max-width: 490px) {
            body {
                font-size: 14px;
            }
        }

        .button {
            display: inline-block;
            padding: 10px 16px;
            color: #fff;
            font-size: 14px;
            line-height: 1;
            background-color: #3a6ea5;
            border-radius: 3px;
        }

        @media (max-width: 490px) {
            .button {
                font-size: 16px;
            }
        }

        .button:hover {
            background-color: #3399cc;
        }

        .button:active {
            background-color: #3399cc;
        }

        .wrapper {
            margin: auto;
            padding-left: 30px;
            padding-right: 30px;
            max-width: 420px;
            padding-top: 25px;
            padding-bottom: 25px;
            background: #fff;
            padding: 24px;
            border-radius: 12px;
            border: 1px solid #E1E1E1;
        }

        @media (max-width: 490px) {
            .wrapper {
                margin: 0 10px;
            }
        }

        h1 {
            margin-top: 6px;
            margin-bottom: 22px;
            font-size: 20px;
            font-weight: 700;
            line-height: 1;
            text-align: center;
        }

        @media (max-width: 490px) {
            h1 {
                font-size: 18px;
            }
        }

        .link {
            margin-top: 8px;
            word-wrap: normal;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .no-link {
            color: #333;
        }

        .actions {
            margin-top: 15px;
            padding-top: 30px;
            text-align: right;
            border-top: 1px solid #d8d8d8;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="content">
            <h1><?php  echo $lang['msg']['external_link_about_to_leave'];  ?> <?php  echo $name;  ?></h1>
            <div class="info">
                <i class="icon-exclamation-triangle"></i>
                <span><?php  echo $lang['msg']['external_link_info'];  ?></span>
            </div>
            <?php if ($ok) { ?>
            <p class="link">
                <i class="icon-link-45deg"></i>
                <span><?php  echo $link;  ?></span>
            </p>
            <?php }else{  ?>
            <p class="no-link link"><?php  echo $lang['msg']['external_link_no_url_error'];  ?></p>
            <?php } ?>
        </div>
        <?php if ($ok) { ?>
        <div class="actions">
            <a class="button" href="<?php  echo $link;  ?>" rel="nofollow">
            <?php  echo $lang['msg']['external_link_continue'];  ?>
            </a>
        </div>
        <?php } ?>
    </div>
</body>
</html>
