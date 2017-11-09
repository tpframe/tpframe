<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:41:"./theme/frontend/default/index\about.html";i:1501150982;s:36:"./theme/frontend/default/layout.html";i:1501150982;s:43:"./theme/frontend/default/layout\header.html";i:1501150982;s:43:"./theme/frontend/default/layout\footer.html";i:1505802386;}*/ ?>
<?php
use tpfcore\Core;
use tpfcore\helpers\StringHelper;
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="applicable-device" content="pc,mobile">
    <meta name="description" content="全部-微信公众号设计,微信界面设计,微信公众号界面设计,微信公众号原型设计,app设计,app界面设计,手机app界面设计,app原型设计-迅虎设计-专为初创企业提供UI设计及开发服务" />
    <meta name="keywords" content="全部-微信公众号设计,微信界面设计,微信公众号界面设计,微信公众号原型设计,app设计,app界面设计,手机app界面设计,app原型设计-迅虎设计-专为初创企业提供UI设计及开发服务" />
    <script type="text/javascript" src="__THEMES__/js/jquery.js"></script>
    <script type="text/javascript" src="__THEMES__/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="__THEMES__/js/common.js"></script>
    <title>全部-微信公众号设计,微信界面设计,微信公众号界面设计,微信公众号原型设计,app设计,app界面设计,手机app界面设计,app原型设计-迅虎设计-专为初创企业提供UI设计及开发服务</title>
    <!-- Bootstrap -->
    <link href="__THEMES__/css/bootstrap.min.css" rel="stylesheet">
    <link href="__THEMES__/css/font-awesome.min.css" rel="stylesheet">
    <link href="__THEMES__/css/animate.css" rel="stylesheet">
    <link rel="stylesheet" href="__THEMES__/css/reset.css">
    <link rel="stylesheet" href="__THEMES__/css/style.css">
    <link rel="stylesheet" type="text/css" href="__THEMES__/css/responsive.css">
    <link rel="stylesheet" href="__THEMES__/css/swiper.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if IE]>
    <script src="__THEMES__/js/html5shiv.js"></script>
    ![endif]-->
    <style type="text/css">
    img.wp-smiley,
    img.emoji {
        display: inline !important;
        border: none !important;
        box-shadow: none !important;
        height: 1em !important;
        width: 1em !important;
        margin: 0 .07em !important;
        vertical-align: -0.1em !important;
        background: none !important;
        padding: 0 !important;
    }
    body {
        padding-top: 80px;
    }
    </style>
</head>

<body>
    <hearder class="header">
        <div class="container ">
            <nav class="navbar navbar-fixed-top" role="navigation">
                <a href="/" class="logo"><img src="/data/assets/images/logo.png"/>Frame</a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#topmenu">
                    <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
                </button>
                <a class="logo navbar-brand " href="/"></a>
                <div class="collapse navbar-collapse" id="topmenu">
                    <ul class="navbar-nav navbar-right">
                        <li><a href="/">首页</a></li>
                        <?php $_result=Core::loadAction("Nav/getNav");if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <li><a href="<?php echo $vo['href']; ?>" target="<?php echo $vo['target']; ?>"><?php echo $vo['label']; ?></a></li>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
            </nav>
        </div>
    </hearder>

<div class="abouttop"></div>
<!-- 案例 -->
<div class="mycontainer bgwhite clearfix p20 pB40" style="margin-top:20px;">
    <div class="con_rank_title">
        <h2>TPFrame团队</h2>
        <h4>平均超过5年工作经验的活力团队</h4>
    </div>
    <ul class="td clearfix">
        <li>
            <div><img src="__THEMES__/images/nan3.jpg" alt=""></div>
            <h4 class="mT10">Jeff </h4>
            <p class="mT5">产品经理，前端工程师</p>
        </li>
        <li>
            <div><img src="__THEMES__/images/nan2.jpg" alt=""></div>
            <h4 class="mT10">Hoter </h4>
            <p class="mT5">Android,Ios开发工程师</p>
        </li>
        <li>
            <div><img src="__THEMES__/images/nv2.jpg" alt=""></div>
            <h4 class="mT10">Catiy </h4>
            <p class="mT5">UI设计师，VI视觉设计师</p>
        </li>
        <li>
            <div><img src="__THEMES__/images/nan1.jpg" alt=""></div>
            <h4 class="mT10">Norman </h4>
            <p class="mT5">PHP开发工程师</p>
        </li>
        <li>
            <div><img src="__THEMES__/images/nv1.jpg" alt=""></div>
            <h4 class="mT10">Amanda </h4>
            <p class="mT5">APP视觉设计师</p>
    </ul>
</div>
<section class="home-contact">
    <div class="con_rank_title">
        <h2 style="color: #fff;">联系方式</h2>
        <h4>每种联系方式总能找到我们</h4>
    </div>
    <div class="container" style="padding-top:55px;">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12">
                <h1 class="white">TPFrame 开发工作室</h1>
                <dl class="clearfix">
                    <dt><i class="fa fa-phone"></i></dt>
                    <dd>
                        <h3><?php echo Core::loadAction("Setting/getSetting",['column'=>"toll_free"]); ?></h3>
                        <p><?php echo Core::loadAction("Setting/getSetting",['column'=>"landline"]); ?> 座机电话</p>
                    </dd>
                </dl>
                <dl class="clearfix">
                    <dt><i class="fa fa-qq"></i></dt>
                    <dd>
                        <h3><?php echo Core::loadAction("Setting/getSetting",['column'=>"landline"]); ?></h3>
                        <p><a href="http://wpa.qq.com/msgrd?v=3&uin=510974211&site=qq&menu=yes" class="white">点击QQ咨询</a></p>
                    </dd>
                </dl>
                <dl class="clearfix">
                    <dt><i class="fa fa-map-marker"></i></dt>
                    <dd>
                        <h3>重庆市高新区</h3>
                        <p><a href="" class="white"><?php echo Core::loadAction("Setting/getSetting",['column'=>"address"]); ?></a></p>
                    </dd>
                </dl>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12" id="allmap">
                <img src="__THEMES__/images/contactImg.jpg" alt="" class="img-responsive">
            </div>
            <style type="text/css">#allmap {width:580px;height:480px;overflow: hidden;margin:0;font-family:"微软雅黑";}</style>
            <script type="text/javascript">
                //百度地图API功能
                function loadJScript() {
                    var script = document.createElement("script");
                    script.type = "text/javascript";
                    script.src = "http://api.map.baidu.com/api?v=2.0&ak=您的密钥&callback=init";
                    document.body.appendChild(script);
                }
                function init() {
                    var map = new BMap.Map("allmap");            // 创建Map实例
                    var point = new BMap.Point(106.539, 29.580); // 创建点坐标
                    map.centerAndZoom(point,15);                 
                    map.enableScrollWheelZoom();                 //启用滚轮放大缩小
                }  
                window.onload = loadJScript;  //异步加载地图
            </script>

        </div>
    </div>
    </div>
</section>
</div>
<footer class="footer mycontainer">
    <?php echo Core::loadAction("Setting/getSetting",['column'=>"site_icp"]); ?> | Powered By <a target="_blank" href="http://www.tpframe.com">TPFrame team</a>
</footer>
<script type="text/javascript">
function add_animate(xh_class, ai_class) {

    $("." + xh_class).mouseover(function() {

        var $self = $(this);
        if ($self.attr("data-animate")) {
            return;
        }

        $self.attr("data-animate", "1");
        $self.addClass(ai_class);

        setTimeout(function() {
            $self.removeClass(ai_class);
            $self.removeAttr("data-animate");
        }, 5000);
    });
}
add_animate("xh-flipInY", "animated flipInY");
add_animate("xh-flipInX", "animated flipInX");
add_animate("xh-pulse", "animated pulse");
add_animate("xh-bounceln", "animated bounceln");
add_animate("xh-zoomIn", "animated zoomIn");
$(function() {
    $(".xh-bounceInLeft").addClass('animated bounceInLeft');
    $(".xh-bounceInRight").addClass('animated bounceInRight');
    $(".xh-bounceInUp").addClass('animated bounceInUp');
    $(".xh-bounce").addClass('animated bounce');

});
</script>
<div id="sidebar-qq-service" class="left-side-flyelem showed hidden-xs hidden-sm" setactive="true">
</div>
<script type="text/javascript">
onqqServiceMaxClick();

function onqqServiceMinClick() {
    $("#sidebar-qq-service").empty().append($('<div class="minsbar">\
            <span id="qqservice-to-min" class="msbtn" >-</span>在线咨询</div>\
        <ul class="qq_chart_wrap">\
            <a href="http://wpa.qq.com/msgrd?v=3&uin=510974211&site=qq&menu=yes" target="_blank">\
                <li class="qq_chart_el"></li>\
            </a>\
            <a href="http://wpa.qq.com/msgrd?v=3&uin=510974211&site=qq&menu=yes" target="_blank" class="qq_chart_text">QQ在线沟通</a>\
        </ul>\
        <ul class="call_list_wrap">\
            <li class="cl_txt">全国统一</li>\
            <li class="cl_txt">咨询服务电话</li>\
            <li class="cl_tel"><?php echo Core::loadAction("Setting/getSetting",['column'=>"toll_free"]); ?></li>\
        </ul>'));

    //setTimeout(onqqServiceMaxClick,10000);

    $("#qqservice-to-min").click(onqqServiceMaxClick);
}

function onqqServiceMaxClick() {
    $("#sidebar-qq-service").empty().append($('<div class="left-side-flyelem-min"></div>'));

    $(".left-side-flyelem-min").click(onqqServiceMinClick);
}
</script>
</body>

</html>
