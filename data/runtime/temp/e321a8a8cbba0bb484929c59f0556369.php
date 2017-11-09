<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:41:"./theme/frontend/default/posts\index.html";i:1506652464;s:36:"./theme/frontend/default/layout.html";i:1501150982;s:43:"./theme/frontend/default/layout\header.html";i:1501150982;s:43:"./theme/frontend/default/layout\footer.html";i:1505802386;}*/ ?>
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

<div class="blogcontent bgwhite clearfix p20 pB40">
    <div class="clearfix">
        <h1 class="rowonetitle">博客</h1>
        <p class="text-center gray">关于TPFrame 系统一些有帮助的东西</p>
        <div class="blogc-left">
            <div class="blog-post">
                <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "没有数据" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <article>
                    <figure>
                        <a target="_blank" href="<?php echo url('Posts/show',['id'=>$vo['id']]); ?>">
                            <img class="img-responsive" src="<?php echo $vo['thumb']; ?>" title="<?php echo $vo['title']; ?>" />
                        </a>
                    </figure>
                    <div class="main">
                        <h5>
						<a target="_blank" href="<?php echo url('Posts/show',['id'=>$vo['id']]); ?>"><?php echo $vo['title']; ?></a>
					</h5>
                        <div class="date"><?php echo date("Y-m-d",$vo['datetime']); ?></div>
                        <div class="content"><?php echo StringHelper::msubstr($vo['content'],0,100); ?></div>
                        <a target="_blank" href="<?php echo url('Posts/show',['id'=>$vo['id']]); ?>" class="btn-blog">阅读详细</a>
                    </div>
                </article>
                <?php endforeach; endif; else: echo "没有数据" ;endif; ?>
            </div>
            <div class="text-center mT20">
                <nav>
                    <div><?php echo $list->render(); ?></div>
                </nav>
            </div>
        </div>
        <div class="blogc-right">
            <div><i class="fa fa-list"></i> 资讯分类</div>
            <ul class="blogmenu">
                <li><a class="active" href="<?php echo url('Posts/index',['cid'=>1]); ?>">全部 (<?php echo Core::loadAction("Posts/countPost",["id"=>1]); ?>)</a></li>
                <?php if(is_array($listChild) || $listChild instanceof \think\Collection || $listChild instanceof \think\Paginator): $i = 0; $__LIST__ = $listChild;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <li><a href="<?php echo url('Posts/index',['cid'=>$vo['id']]); ?>"><?php echo $vo['title']; ?></a><span>(<?php echo $vo['num']; ?>)</span></li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div>
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
