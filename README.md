![](http://www.tpframe.com/data/assets/images/mark_logo.jpg) 
TPFrame
===============
TPFrame保持了ThinkPHP5原有的所有特性，在ThinkPHP动力驱动模式下做了进一步的开发，对CBD模式做了更深的强化，优化核心，减少依赖，为个人或企业建站提供高效、快速解决的方案，是你快速做在线成品、是你建设各种系统的首选利器，TPFrame的主要特性：

 + 网站目录结构清晰、合理
 + 保留ThinkPHP5所有模式，你可以运用任何ThinkPHP5可用的操作
 + 系统可完全采用CBD模式进行随意扩展
 + 系统采用多层（控制层、模型层、验证层、逻辑层、视图层）设计模式来更低的减少各个模块之间的耦合度，让你的代码在开发不同系统时可更好的重复利用
 + 系统可插件式开发功能模块，丰富的免费插件可直接下载使用
 + 基于命名空间和众多PHP新特性
 + 核心功能组件化
 + 强化路由功能
 + 更灵活的控制器
 + 重构的模型和数据库类
 + 配置文件可分离
 + 重写的自动验证和完成
 + 简化扩展机制
 + API强化支持，几句代码搞定接口、接口文档问题
 + 命令行访问支持
 + REST支持
 + 引导文件支持
 + 方便的自动生成定义
 + 真正惰性加载
 + 分布式环境支持
 + 更多的社交类库

> TPFrame的运行环境要求PHP5.6以上。

## TPFrame 6.x 版本
tpframe 6.x (https://gitee.com/37duman/tpframe6)

# 扫码在线部分体验
|TPFrame 微信小程序|TPFrame 微信公众号|TPFrame 百度小程序|
|:--:|:--:|:--:|
|<img src="https://www.tpframe.com/data/assets/images/mini_program_ercode.jpg" width=256 height=256 />|<img src="https://www.tpframe.com/data/assets/images/wechat.jpg" width=256 height=256 />|<img src="https://www.tpframe.com/data/assets/images/bd_tcms_ercode.png" width=256 height=256 />|
|微信扫一扫|微信扫一扫|百度app扫一扫|

## 标准目录结构

初始的目录结构如下：

~~~
www  WEB部署目录（或者子目录）
├─addon           		插件目录
│  └─...        		可扩展模块目录
├─application           应用程序目录
│  ├─common             公共模块目录（可以更改）
│  ├─backend            后台模块目录（可以更改）
│  ├─frontend           前台模块目录（可以更改）
│  ├─extra           	配置文件目录
│  ├─install            安装模块目录（安装后建议删除）
│  ├─module_name        模块目录（可以更改）
│  │  ├─config.php      模块配置文件
│  │  ├─controller      控制器目录
│  │  ├─logic      		逻辑层目录
│  │  ├─model           模型目录
│  │  ├─service      	服务层目录
│  │  ├─validate      	数据验证层目录
│  │  └─ ...            更多类库目录
│  ├─command.php        命令行工具配置文件
│  ├─common.php         公共函数文件
│  ├─config.php         公共配置文件
│  ├─route.php          路由配置文件
│  ├─tags.php           应用行为扩展定义文件
│  └─database.php       数据库配置文件
├─coreframe           	核心代码目录
│  ├─source        		tpframe源码目录
│  ├─thinkphp        	thinkphp源码目录
│  ├─vendor        		第三方类库目录（Composer依赖库）
│  └─...        		更多可扩展模块目录
├─data                	数据资源目录（对外访问目录）
│  ├─assets          	静态资源目录
│  ├─conf(<2.0)        	配置文件目录(2.0版本已移动到application的extra目录)
│  ├─runtime         	运行时目录
│  ├─uploads        	上传文件目录
│  ├─install.lock       安装标识文件
│  └─...		        其它文件
│─extend                扩展类库目录
├─theme              	模板目录
│  ├─backend            后台模板文件目录
│  ├─frontend           前台模板文件目录
│  └─install            安装模板文件目录
│
├─build.php             自动生成定义文件（参考）
├─composer.json         composer 定义文件
├─LICENSE.txt           授权说明文件
├─README.md             README 文件
├─think                 命令行入口文件
├─index.php             入口文件
├─...            		其它文件
~~~

## 自动安装
系统运行后会自动安装
重新安装的用户,请手动删除`data/install.lock`文件和'application/extra/database.php'文件

## 命名规范

`TPFrame`遵循PSR-2命名规范和PSR-4自动加载规范，并且注意如下规范：

### 目录和文件

*   目录不强制规范，驼峰和小写+下划线模式均支持；
*   类库、函数文件统一以`.php`为后缀；
*   类的文件名均以命名空间定义，并且命名空间的路径和类库文件所在路径一致；
*   类名和类文件名保持一致，统一采用驼峰法命名（首字母大写）；

### 函数和类、属性命名
*   类的命名采用驼峰法，并且首字母大写，例如 `User`、`UserType`，默认不需要添加后缀，例如`UserController`应该直接命名为`User`；
*   函数的命名使用小写字母和下划线（小写字母开头）的方式，例如 `get_client_ip`；
*   方法的命名使用驼峰法，并且首字母小写，例如 `getUserName`；
*   属性的命名使用驼峰法，并且首字母小写，例如 `tableName`、`instance`；
*   以双下划线“__”打头的函数或方法作为魔法方法，例如 `__call` 和 `__autoload`；

### 常量和配置
*   常量以大写字母和下划线命名，例如 `APP_PATH`和 `THINK_PATH`；
*   配置参数以小写字母和下划线命名，例如 `url_route_on` 和`url_convert`；

### 数据表和字段
*   数据表和字段采用小写加下划线方式命名，并注意字段名不要以下划线开头，例如 `think_user` 表和 `user_name`字段，不建议使用驼峰和中文作为数据表字段命名。

### 网站指示:

[tpframe官网](https://www.tpframe.com)

[tpframe演示网站](http://demo3.tpframe.com/backend)

### QQ群:
`TPFrame 官方交流群`:129822766  

### 特别感谢如下项目的支持
ThinkPHP：(http://www.thinkphp.cn)

Font Awesome：(http://fontawesome.dashgame.com/)

LayUi：(http://layer.layui.com/)

Bootstrap：(http://www.bootcss.com/)

jQuery：(http://jquery.com/)

jsTree：(http://www.jstree.com/)

## 版权信息

TPFrame遵循Apache2开源协议发布，并提供免费使用。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

版权所有Copyright © 2018-2020 by TPFrame (https://www.tpframe.com)

All rights reserved。
