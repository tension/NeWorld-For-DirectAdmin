# NewWorld For DirectAdmin #

*这个主题是由tension制作,使用在DirectAdmin的主题!*


#### QQ 群 : 286348



演示地址: [http://www.elinkhost.com/webhostdemo.html](http://www.elinkhost.com/webhostdemo.html)

## 截图欣赏 ##

![用户层首页](http://ww3.sinaimg.cn/large/6211b300gw1ef4uuckqigj20w90u4wiy.jpg)

![密码修改](http://ww2.sinaimg.cn/large/6211b300gw1ef4uv9hly8j20w90rgju7.jpg)

![文件管理](http://ww2.sinaimg.cn/large/6211b300gw1ef4uvl1r5cj20w90rgdjb.jpg)

![数据库管理](http://ww2.sinaimg.cn/large/6211b300gw1ef4uvtmdzuj20w90rgwhw.jpg)

![下拉菜单](http://ww1.sinaimg.cn/large/6211b300gw1ef4uw3ba85j209m051t8u.jpg)

![登录页](http://ww1.sinaimg.cn/large/6211b300gw1ef4uwd32n7j20e00a80sy.jpg)



## 如何安装 ##


#### 主题安装 ####
```sh
cd /usr/local/directadmin/data/skins/ #进入主题所在目录
wget https://github.com/tension/NewWorld/archive/master.zip #下载NewWorld主题模版压缩包
unzip master #解压缩主题压缩包
mv NewWorld-master NewWorld #修改主题文件夹名称
chown -R diradmin:diradmin NewWorld/ #设置主题所有权
rm -f master #删除主题模版压缩包
exit #退出
```

##### 安装完成 登陆后台 选择皮肤管理 选择主题应用所有用户

#### 登陆界面安装 ####
```sh
cd /usr/local/directadmin/data/templates #进入主题所在目录
wget http://www.elinkhost.com/download/Login-Page-2014-4-9.tar.gz #下载Login Page主题模版压缩包
tar xvzf Login-Page-2014-4-9.tar.gz #解压缩
chown -R diradmin:diradmin * #设置主题所有权
rm -f Login-Page-2014-4-9.tar.gz #删除主题模版压缩包
```


## 自定义页面 ##

```html
/data/templates/custom/login.html
```
注销后跳转页面修改
登录页模版位置

```html
<input type="hidden" value="http://www.elinkhost.com" name="LOGOUT_URL"/>
```
网址改为您的网址


```html
custom.html
```
用户界面联系我们信息

```html
notice.html
```
为用户界面新闻调用,如不需要可直接删除内容即可.

```html
images/logo.png
```
为左上角 LOGO, 尺寸 390x62

## 使用开源框架 ##

```html
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
```

使用 [font-awesome](http://fortawesome.github.io/Font-Awesome/) 开源图标系列

```html
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.4.2/pure-min.css">
```

使用 [Pure](http://purecss.io/) CSS 框架

```html
<script type="text/javascript" src="//libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
```

使用 [jQuery](http://jquery.com/) JS 框架 由 [百度开放云](http://libs.baidu.com/) 提供CDN加速

## 支持我 ##

如果你觉得这个东西确实不错，可以通过支付宝支付我

我的二维码

![我的收款](http://ww1.sinaimg.cn/large/6211b300gw1efs74kpta6j205y05y74x.jpg)
