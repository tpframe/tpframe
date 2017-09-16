<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:27:".\theme\install\\index.html";i:1499996719;s:32:".\theme\install\Public\head.html";i:1498188729;s:34:".\theme\install\Public\header.html";i:1498187247;s:34:".\theme\install\Public\footer.html";i:1498187342;}*/ ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>TPFrame安装</title>
<link rel="stylesheet" href="__THEMES__/css/theme.min.css" />
<link rel="stylesheet" href="__THEMES__/css/install.css" />
<link rel="stylesheet" href="__THEMES__/font-awesome/4.4.0/css/font-awesome.min.css" />

</head>
<body>
	<div class="wrap">
		<div class="header">
	<h1 class="logo">TPFrame 安装向导</h1>
	<div class="version"><?php echo TPFRAME_VERSION; ?></div>
</div>
		<div class="section">
			<div class="main">
				<pre class="agreement">TPFrame软件使用协议

版权所有 ©2017-<?php echo date("Y")+6; ?>,TPFrame工作室

感谢您选择TPFrame内容管理框架, 希望我们的产品能够帮您把网站发展的更快、更好、更强！

TPFrame遵循Apache2开源协议发布，并提供免费使用。

TPFrame爱的系统由TPFrame工作室(官网http://www.tpframe.com)发起并开源发布。

Apache Licence是著名的非盈利开源组织Apache采用的协议。
该协议鼓励代码共享和尊重原作者的著作权，允许代码修改，再作为开源或商业软件发布。需要满足的条件： 
1． 需要给代码的用户一份Apache Licence ；
2． 如果你修改了代码，需要在被修改的文件中说明；
3． 在延伸的代码中（修改和有源代码衍生的代码中）需要带有原来代码中的协议，商标，专利声明和其他原来作者规定需要包含的说明；
4． 如果再发布的产品中包含一个Notice文件，则在Notice文件中需要带有本协议内容。你可以在Notice中增加自己的许可，但不可以表现为对Apache Licence构成更改。 

具体的协议参考：http://www.apache.org/licenses/LICENSE-2.0

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
"AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
POSSIBILITY OF SUCH DAMAGE.

TPFrame免责声明
  1、使用TPFrame构建的网站的任何信息内容以及导致的任何版权纠纷和法律争议及后果，TPFrame官方不承担任何责任。
  2、您一旦安装使用TPFrame，即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权力的同时，受到相关的约束和限制。</pre>
			</div>
			<div class="bottom text-center">
				<a href="/install/index/step2" class="btn btn-primary">同意</a>
			</div>
		</div>
	</div>
	<div class="footer">
	&copy; 2017-<?php echo date('Y'); ?> <a href="http://www.tpframe.com" target="_blank">TPFrame</a>工作室
</div>
</body>
</html>