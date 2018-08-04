<!DOCTYPE html>
<!--[if IE 9]>         <html class="ie9 no-focus" lang="zh"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-focus" lang="zh">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <title>跳转提示 | TPFRAME.COM</title>
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
    <!-- Stylesheets -->
    <!-- Bootstrap and OneUI CSS framework -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/2.3.1/css/bootstrap.min.css">
    <!-- END Stylesheets -->
    <style type="text/css">
    html,
    body {
        height: 100%;
    }

    .push-50 {
        margin-bottom: 50px !important;
    }

    body {
        font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size: 14px;
        color: #646464;
        background-color: #f5f5f5;
    }

    .btn {
        font-weight: 600;
        border-radius: 2px;
        -webkit-transition: all 0.15s ease-out;
        transition: all 0.15s ease-out;
    }

    .text-city {
        color: #ff6b6b;
    }

    .push-10 {
        margin-bottom: 10px !important;
    }

    .font-w300 {
        font-weight: 300 !important;
    }

    .bg-white {
        background-color: #fff;
    }

    .content {
        margin: 0 auto;
        padding: 16px 14px 1px;
        max-width: 100%;
        overflow-x: visible;
    }

    @media screen and (min-width: 768px) {
        .content {
            margin: 0 auto;
            padding: 30px 30px 1px;
            max-width: 100%;
            overflow-x: visible;
        }
        .content p,
        .content .push,
        .content .block,
        .content .items-push>div {
            margin-bottom: 30px;
        }
        .content .items-push-2x>div {
            margin-bottom: 60px;
        }
        .content .items-push-3x>div {
            margin-bottom: 90px;
        }
        .content.content-full {
            padding-bottom: 30px;
        }
        .content.content-full .pull-b {
            margin-bottom: -30px;
        }
        .content .pull-t {
            margin-top: -30px;
        }
        .content .pull-r-l {
            margin-right: -30px;
            margin-left: -30px;
        }
        .content .pull-b {
            margin-bottom: -1px;
        }
        .content.content-boxed {
            max-width: 1280px;
        }
        .content.content-narrow {
            max-width: 95%;
        }
    }

    .btn:active,
    .btn.active {
        -webkit-box-shadow: none;
        box-shadow: none;
    }

    .btn.btn-square {
        border-radius: 0;
    }

    .btn.btn-rounded {
        border-radius: 20px;
    }

    .btn.btn-minw {
        min-width: 110px;
    }

    .btn.btn-noborder {
        border: none !important;
    }

    .btn.btn-image {
        position: relative;
        padding-left: 40px;
    }

    .btn.btn-image>img {
        position: absolute;
        top: 3px;
        left: 3px;
        display: block;
        width: 26px;
        height: 26px;
        border-radius: 3px;
    }

    .btn>i.pull-left {
        margin-top: 3px;
        margin-right: 5px;
    }

    .btn>i.pull-right {
        margin-top: 3px;
        margin-left: 5px;
    }

    .btn-link,
    .btn-link:hover,
    .btn-link:focus {
        text-decoration: none;
    }

    .btn-default {
        color: #545454;
        background-color: #f5f5f5;
        border-color: #e9e9e9;
    }

    .btn-default:focus,
    .btn-default.focus,
    .btn-default:hover {
        color: #545454;
        background-color: #e1e1e1;
        border-color: #cacaca;
    }

    .btn-default:active,
    .btn-default.active,
    .open>.dropdown-toggle.btn-default {
        color: #545454;
        background-color: #c7c7c7;
        border-color: #b1b1b1;
    }

    .btn-default:active:hover,
    .btn-default.active:hover,
    .open>.dropdown-toggle.btn-default:hover,
    .btn-default:active:focus,
    .btn-default.active:focus,
    .open>.dropdown-toggle.btn-default:focus,
    .btn-default:active.focus,
    .btn-default.active.focus,
    .open>.dropdown-toggle.btn-default.focus {
        color: #545454;
        background-color: #c7c7c7;
        border-color: #b1b1b1;
    }

    .btn-default:active,
    .btn-default.active,
    .open>.dropdown-toggle.btn-default {
        background-image: none;
    }

    .btn-default.disabled,
    .btn-default[disabled],
    fieldset[disabled] .btn-default,
    .btn-default.disabled:hover,
    .btn-default[disabled]:hover,
    fieldset[disabled] .btn-default:hover,
    .btn-default.disabled:focus,
    .btn-default[disabled]:focus,
    fieldset[disabled] .btn-default:focus,
    .btn-default.disabled.focus,
    .btn-default[disabled].focus,
    fieldset[disabled] .btn-default.focus,
    .btn-default.disabled:active,
    .btn-default[disabled]:active,
    fieldset[disabled] .btn-default:active,
    .btn-default.disabled.active,
    .btn-default[disabled].active,
    fieldset[disabled] .btn-default.active {
        background-color: #f5f5f5;
        border-color: #e9e9e9;
    }

    .btn-default .badge {
        color: #f5f5f5;
        background-color: #545454;
    }

    .btn-primary {
        color: #fff;
        background-color: #5c90d2;
        border-color: #3675c5;
    }

    .btn-primary:focus,
    .btn-primary.focus,
    .btn-primary:hover {
        color: #fff;
        background-color: #3c7ac9;
        border-color: #295995;
    }

    .btn-primary:active,
    .btn-primary.active,
    .open>.dropdown-toggle.btn-primary {
        color: #fff;
        background-color: #2d62a5;
        border-color: #1e416d;
    }

    .btn-primary:active:hover,
    .btn-primary.active:hover,
    .open>.dropdown-toggle.btn-primary:hover,
    .btn-primary:active:focus,
    .btn-primary.active:focus,
    .open>.dropdown-toggle.btn-primary:focus,
    .btn-primary:active.focus,
    .btn-primary.active.focus,
    .open>.dropdown-toggle.btn-primary.focus {
        color: #fff;
        background-color: #2d62a5;
        border-color: #1e416d;
    }

    .btn-primary:active,
    .btn-primary.active,
    .open>.dropdown-toggle.btn-primary {
        background-image: none;
    }

    .btn-primary.disabled,
    .btn-primary[disabled],
    fieldset[disabled] .btn-primary,
    .btn-primary.disabled:hover,
    .btn-primary[disabled]:hover,
    fieldset[disabled] .btn-primary:hover,
    .btn-primary.disabled:focus,
    .btn-primary[disabled]:focus,
    fieldset[disabled] .btn-primary:focus,
    .btn-primary.disabled.focus,
    .btn-primary[disabled].focus,
    fieldset[disabled] .btn-primary.focus,
    .btn-primary.disabled:active,
    .btn-primary[disabled]:active,
    fieldset[disabled] .btn-primary:active,
    .btn-primary.disabled.active,
    .btn-primary[disabled].active,
    fieldset[disabled] .btn-primary.active {
        background-color: #5c90d2;
        border-color: #3675c5;
    }

    .btn-primary .badge {
        color: #5c90d2;
        background-color: #fff;
    }

    .btn-success {
        color: #fff;
        background-color: #46c37b;
        border-color: #34a263;
    }

    .btn-success:focus,
    .btn-success.focus,
    .btn-success:hover {
        color: #fff;
        background-color: #37a967;
        border-color: #257346;
    }

    .btn-success:active,
    .btn-success.active,
    .open>.dropdown-toggle.btn-success {
        color: #fff;
        background-color: #2a8350;
        border-color: #194d2f;
    }

    .btn-success:active:hover,
    .btn-success.active:hover,
    .open>.dropdown-toggle.btn-success:hover,
    .btn-success:active:focus,
    .btn-success.active:focus,
    .open>.dropdown-toggle.btn-success:focus,
    .btn-success:active.focus,
    .btn-success.active.focus,
    .open>.dropdown-toggle.btn-success.focus {
        color: #fff;
        background-color: #2a8350;
        border-color: #194d2f;
    }

    .btn-success:active,
    .btn-success.active,
    .open>.dropdown-toggle.btn-success {
        background-image: none;
    }

    .btn-success.disabled,
    .btn-success[disabled],
    fieldset[disabled] .btn-success,
    .btn-success.disabled:hover,
    .btn-success[disabled]:hover,
    fieldset[disabled] .btn-success:hover,
    .btn-success.disabled:focus,
    .btn-success[disabled]:focus,
    fieldset[disabled] .btn-success:focus,
    .btn-success.disabled.focus,
    .btn-success[disabled].focus,
    fieldset[disabled] .btn-success.focus,
    .btn-success.disabled:active,
    .btn-success[disabled]:active,
    fieldset[disabled] .btn-success:active,
    .btn-success.disabled.active,
    .btn-success[disabled].active,
    fieldset[disabled] .btn-success.active {
        background-color: #46c37b;
        border-color: #34a263;
    }

    .btn-success .badge {
        color: #46c37b;
        background-color: #fff;
    }

    .btn-info {
        color: #fff;
        background-color: #70b9eb;
        border-color: #43a3e5;
    }

    .btn-info:focus,
    .btn-info.focus,
    .btn-info:hover {
        color: #fff;
        background-color: #4ca7e6;
        border-color: #1d86ce;
    }

    .btn-info:active,
    .btn-info.active,
    .open>.dropdown-toggle.btn-info {
        color: #fff;
        background-color: #1f92e0;
        border-color: #1769a1;
    }

    .btn-info:active:hover,
    .btn-info.active:hover,
    .open>.dropdown-toggle.btn-info:hover,
    .btn-info:active:focus,
    .btn-info.active:focus,
    .open>.dropdown-toggle.btn-info:focus,
    .btn-info:active.focus,
    .btn-info.active.focus,
    .open>.dropdown-toggle.btn-info.focus {
        color: #fff;
        background-color: #1f92e0;
        border-color: #1769a1;
    }

    .btn-info:active,
    .btn-info.active,
    .open>.dropdown-toggle.btn-info {
        background-image: none;
    }

    .btn-info.disabled,
    .btn-info[disabled],
    fieldset[disabled] .btn-info,
    .btn-info.disabled:hover,
    .btn-info[disabled]:hover,
    fieldset[disabled] .btn-info:hover,
    .btn-info.disabled:focus,
    .btn-info[disabled]:focus,
    fieldset[disabled] .btn-info:focus,
    .btn-info.disabled.focus,
    .btn-info[disabled].focus,
    fieldset[disabled] .btn-info.focus,
    .btn-info.disabled:active,
    .btn-info[disabled]:active,
    fieldset[disabled] .btn-info:active,
    .btn-info.disabled.active,
    .btn-info[disabled].active,
    fieldset[disabled] .btn-info.active {
        background-color: #70b9eb;
        border-color: #43a3e5;
    }

    .btn-info .badge {
        color: #70b9eb;
        background-color: #fff;
    }

    .btn-warning {
        color: #fff;
        background-color: #f3b760;
        border-color: #efa231;
    }

    .btn-warning:focus,
    .btn-warning.focus,
    .btn-warning:hover {
        color: #fff;
        background-color: #f0a63a;
        border-color: #d38310;
    }

    .btn-warning:active,
    .btn-warning.active,
    .open>.dropdown-toggle.btn-warning {
        color: #fff;
        background-color: #e68f11;
        border-color: #a3660c;
    }

    .btn-warning:active:hover,
    .btn-warning.active:hover,
    .open>.dropdown-toggle.btn-warning:hover,
    .btn-warning:active:focus,
    .btn-warning.active:focus,
    .open>.dropdown-toggle.btn-warning:focus,
    .btn-warning:active.focus,
    .btn-warning.active.focus,
    .open>.dropdown-toggle.btn-warning.focus {
        color: #fff;
        background-color: #e68f11;
        border-color: #a3660c;
    }

    .btn-warning:active,
    .btn-warning.active,
    .open>.dropdown-toggle.btn-warning {
        background-image: none;
    }

    .btn-warning.disabled,
    .btn-warning[disabled],
    fieldset[disabled] .btn-warning,
    .btn-warning.disabled:hover,
    .btn-warning[disabled]:hover,
    fieldset[disabled] .btn-warning:hover,
    .btn-warning.disabled:focus,
    .btn-warning[disabled]:focus,
    fieldset[disabled] .btn-warning:focus,
    .btn-warning.disabled.focus,
    .btn-warning[disabled].focus,
    fieldset[disabled] .btn-warning.focus,
    .btn-warning.disabled:active,
    .btn-warning[disabled]:active,
    fieldset[disabled] .btn-warning:active,
    .btn-warning.disabled.active,
    .btn-warning[disabled].active,
    fieldset[disabled] .btn-warning.active {
        background-color: #f3b760;
        border-color: #efa231;
    }

    .btn-warning .badge {
        color: #f3b760;
        background-color: #fff;
    }

    .btn-danger {
        color: #fff;
        background-color: #d26a5c;
        border-color: #c54736;
    }

    .btn-danger:focus,
    .btn-danger.focus,
    .btn-danger:hover {
        color: #fff;
        background-color: #c94d3c;
        border-color: #953629;
    }

    .btn-danger:active,
    .btn-danger.active,
    .open>.dropdown-toggle.btn-danger {
        color: #fff;
        background-color: #a53c2d;
        border-color: #6d271e;
    }

    .btn-danger:active:hover,
    .btn-danger.active:hover,
    .open>.dropdown-toggle.btn-danger:hover,
    .btn-danger:active:focus,
    .btn-danger.active:focus,
    .open>.dropdown-toggle.btn-danger:focus,
    .btn-danger:active.focus,
    .btn-danger.active.focus,
    .open>.dropdown-toggle.btn-danger.focus {
        color: #fff;
        background-color: #a53c2d;
        border-color: #6d271e;
    }

    .btn-danger:active,
    .btn-danger.active,
    .open>.dropdown-toggle.btn-danger {
        background-image: none;
    }

    .btn-danger.disabled,
    .btn-danger[disabled],
    fieldset[disabled] .btn-danger,
    .btn-danger.disabled:hover,
    .btn-danger[disabled]:hover,
    fieldset[disabled] .btn-danger:hover,
    .btn-danger.disabled:focus,
    .btn-danger[disabled]:focus,
    fieldset[disabled] .btn-danger:focus,
    .btn-danger.disabled.focus,
    .btn-danger[disabled].focus,
    fieldset[disabled] .btn-danger.focus,
    .btn-danger.disabled:active,
    .btn-danger[disabled]:active,
    fieldset[disabled] .btn-danger:active,
    .btn-danger.disabled.active,
    .btn-danger[disabled].active,
    fieldset[disabled] .btn-danger.active {
        background-color: #d26a5c;
        border-color: #c54736;
    }

    .btn-danger .badge {
        color: #d26a5c;
        background-color: #fff;
    }

    .pulldown {
        position: relative;
        top: 50px;
    }

    @media screen and (min-width: 992px) {
        .pulldown {
            top: 150px;
        }
    }
    </style>
</head>

<body>
    <!-- Error Content -->
    <div class="content bg-white text-center pulldown overflow-hidden">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <!-- Error Titles -->
                <h1 class="font-w300 text-city push-10 animated flipInX">
            <?php
                if(isset($msg)){
                    echo(strip_tags($msg));
                }
                else if(isset($message)){
                   echo nl2br(htmlentities($message)); 
                }else{
                    echo $title;
                }
            ?>
            </h1>
                <p class="font-w300 push-20 animated fadeInUp">页面自动 <a id="href" href="<?php if(empty($url)){echo '/';}else{echo $url;}?>">跳转</a> 等待时间： <b id="wait">3</b>秒</p>
                <div class="push-50">
                    <a class="btn btn-minw btn-rounded btn-success" href="<?php if(empty($url)){echo '/';}else{echo $url;}?>"></i> 立即跳转</a>
                    <button class="btn btn-minw btn-rounded btn-warning" type="button" onclick="stop()">禁止跳转</button>
                    <a class="btn btn-minw btn-rounded btn-default" href="/">返回首页</a>
                </div>
                <!-- END Error Titles -->
            </div>
        </div>
    </div>
    <!-- END Error Content -->
    <!-- Error Footer -->
    <div class="content pulldown text-muted text-center">
        极速 · 精简 · 高效
        <br> TPFRAME.COM ，让开发更快速！
        <br> 由 <a class="link-effect" href="http://www.tpframe.com">TPFRAME.COM</a> 强力驱动
    </div>
    <!-- END Error Footer -->
    <script type="text/javascript">
    (function() {
        var wait = document.getElementById('wait'),
            href = document.getElementById('href').href;
        var interval = setInterval(function() {
            var time = --wait.innerHTML;
            if (time <= 0) {
                location.href = href;
                clearInterval(interval);
            };
        }, 1000);

        // 禁止跳转
        window.stop = function() {
            clearInterval(interval);
        }
    })();
    </script>
</body>

</html>