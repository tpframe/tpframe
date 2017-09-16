<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:41:"./theme/frontend/default/index\index.html";i:1500441095;s:36:"./theme/frontend/default/layout.html";i:1497931165;s:43:"./theme/frontend/default/layout\header.html";i:1499332920;s:43:"./theme/frontend/default/layout\footer.html";i:1498641721;}*/ ?>
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

    <!-- Swiper -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php $_result=Core::loadAction("Slide/getSlide");if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <div class="swiper-slide">
                <!-- Required swiper-lazy class and image source specified in data-src attribute -->
                <img data-src="<?php echo $vo['slide_pic']; ?>" class="swiper-lazy">
                <!-- Preloader image -->
                <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
            </div>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination swiper-pagination-white"></div>
        <!-- Navigation -->
        <div class="swiper-button-next swiper-button-white"></div>
        <div class="swiper-button-prev swiper-button-white"></div>
    </div>
    <!-- Swiper JS -->
    <script src="__THEMES__/js/swiper.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
    var swiper = new Swiper('.swiper-container', {
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        pagination: '.swiper-pagination',
        paginationClickable: true,
        // Disable preloading of all images
        preloadImages: false,
        // Enable lazy loading
        lazyLoading: true
    });
    var ratio=0;
    window.onload=function(imgObj){
        var width=$(".swiper-slide img:first").css("width");
        var height=$(".swiper-slide img:first").css("height");
        //console.log(width+":"+height);
        ratio=parseInt(width)/parseInt(height);
        $(".swiper-container").css({"height":$(".swiper-slide img:first").css("height")});
    }
    $(function(){
        $(window).resize(function(){
            var width=$(".swiper-slide img:first").css("width");
            var height=parseInt(width)/ratio;
            $(".swiper-container").css({"height":height});
        });
    });
    </script>
    <style type="text/css">
    html, body {
        position: relative;
        height: 100%;
    }
    </style>
    <!-- banner结束 -->
    <!-- 设计流程 -->
    <div class="container bgwhite clearfix p20 pB40">
        <div class="con_rank_title">
            <h2>项目开发流程</h2>
            <h4>APP/PHP程序设计</h4>
        </div>
        <ul class="pslist">
            <li>
                <div>
                    <i class="fa tus fa-user xh-flipInX"></i>
                </div>
                <p class="text-center text">需求沟通,草图绘制</p>
            </li>
            <li>
                <div>
                    <i class="fa fa-laptop tus xh-flipInX"></i>
                </div>
                <p class="text-center text">用户交互,高保真原型</p>
            </li>
            <li>
                <div>
                    <i class="fa tus fa-eye xh-flipInX"></i>
                </div>
                <p class="text-center text">视觉和UI设计</p>
            </li>
            <li>
                <div>
                    <i class="fa fa-apple tus xh-flipInX"></i>
                </div>
                <p class="text-center text">前端开发,后端开发</p>
            </li>
        </ul>
    </div>
    <!-- 案例 -->
    <div class="mycontainer bgwhite clearfix p20 pB40" style="margin-top: 20px;">
        <div class="con_rank_title">
            <h2>案例展示</h2>
            <h4>TPFrame经典案例</h4>
        </div>
        <section class="home-case">
            <ul class="list" id="home-showbox">
                <?php $_result=Core::loadAction("Posts/getPosts",["limit"=>3,"where"=>"cateid=7"]);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <li class="xh-bounce">
                    <img src="<?php if(empty($vo['thumb']) || (($vo['thumb'] instanceof \think\Collection || $vo['thumb'] instanceof \think\Paginator ) && $vo['thumb']->isEmpty())): ?>/data/assets/images/case_thumb.jpg<?php else: ?><?php echo $vo['thumb']; endif; ?>" alt="<?php echo StringHelper::msubstr($vo['title'],0,10); ?>">
                    <div class="showbox ">
                        <div class="overlay"></div>
                        <div class="content xh-flipInY">
                            <h3><?php echo StringHelper::msubstr($vo['title'],0,10); ?></h3>
                            <p>系统设计，系统开发，二次开发</p>
                        </div>
                    </div>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <div class="p20 text-center">
                <a href="/frontend/index/cases/cid/7/" class="more2 xh-zoomIn">全部案例</a>
            </div>
        </section>
    </div>
    <!-- about -->
    <div class="homeabout">
        <h4 class="title">TPFrame简介</h4>
        <p class="text">TPFrame 是一款新起的为项目快速速成的PHP框架，基于thinkphp5.0开发，程序完全开源，可进行任何的二次开发，废弃thinkphp3.2函数编程模式，数据模式全部采用对象封装，四层框架模

式，让你的程序更加解耦合，写少量的代码，做更多的事情，真正提升企业价值的开源框架。</p>
        <p class="text-center">
            <a href="//shang.qq.com/wpa/qunwpa?idkey=2902b09cc5514af8485c492180d2d6a8c0c602977a33ee6a51bc311a7429a42a" class="bts" target="_blank">加入QQ群交流</a>
        </p>
    </div>
    <!-- blog -->
    <div class="mycontainer bgwhite clearfix p20 pB40" style="margin-top: 20px;">
        <div class="con_rank_title">
            <h2>博客</h2>
            <h4>PHP行业资讯</h4>
        </div>
        <div class="bloghome mT20">
            <?php $_result=Core::loadAction("Posts/getPosts",["limit"=>3,"where"=>"cateid=2 or cateid=3 or cateid=4 or cateid=5 or cateid=6"]);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <div class="thumbnail">
                <a target="_blank" href="/frontend/posts/show/id/<?php echo $vo['id']; ?>">
                    <img class="img-responsive" title="<?php echo StringHelper::msubstr($vo['title'],0,10); ?>" alt="<?php echo StringHelper::msubstr($vo['title'],0,10); ?>" src="<?php echo $vo['thumb']; ?>">
                </a>
                <div class="blog-time">
                    <span><?php echo date('d',$vo['datetime']); ?></span>
                    <p><?php echo date('m',$vo['datetime']); ?>月</p>
                </div>
                <div class="caption">
                    <h4>
					<a target="_blank" href="/frontend/posts/show/id/<?php echo $vo['id']; ?>"><?php echo StringHelper::msubstr($vo['title'],0,10); ?></a>
				</h4>
                    <p class="text-left"><?php echo StringHelper::msubstr($vo['content'],0,50); ?></p>
                </div>
            </div>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <div class="p20 text-center">
            <a href="/frontend/posts/index/cid/1" class="more2 xh-zoomIn" target="_blank">全部博客</a>
        </div>
    </div>

<footer class="footer mycontainer">
    <a href="mailto:service@xunhuweb.com"><?php echo Core::loadAction("Setting/getSetting",['column'=>"site_icp"]); ?></a> | Powered By <a target="_blank" href="http://www.tpframe.com">TPFrame team</a>
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
