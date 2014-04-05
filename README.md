# NewWorld For DirectAdmin #

#### 这个主题是由tension制作,使用在DirectAdmin的主题!

演示地址: [http://www.elinkhost.com/webhostdemo.html](http://www.elinkhost.com/webhostdemo.html)

## 如何安装 ##

```sh
cd /usr/local/directadmin/data/skins/ #进入主题所在目录
wget https://github.com/tension/NewWorld/archive/master.zip #下载NewWorld主题模版压缩包
unzip master #解压缩主题压缩包
mv NewWorld-master NewWorld #修改主题文件夹名称
chown -R diradmin:diradmin NewWorld/ #设置主题所有权
rm -f master #删除主题模版压缩包
exit #退出
```


## 自定义页面 ##

```html
custom.html
```
用户界面联系我们信息

```html
images/logo.png
```
为左上角 LOGO

```html
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
```
## 使用开源框架 ##

使用 [font-awesome](http://fortawesome.github.io/Font-Awesome/) 开源图标系列

```html
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.4.2/pure-min.css">
```

使用 [Pure](http://purecss.io/) CSS 框架

```html
<script type="text/javascript" src="//libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
```

使用 [jQuery](http://jquery.com/) JS 框架 由 [百度开放云](http://libs.baidu.com/) 提供CDN加速