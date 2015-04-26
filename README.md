# NewWorld 4.0 For DirectAdmin 1.47
===

**这个主题是由tension制作,使用在DirectAdmin的主题!**

#### 低价转让 DirectAdmin 授权 10 个，有需求请加群！

##### QQ 群 : 286348

演示地址: [http://www.elinkhost.com/webhostdemo.html](http://www.elinkhost.com/webhostdemo.html)


### 如何安装
---


#### 主题安装
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

https://github.com/tension/NewWorld-For-DirectAdmin-Login-Page


## 自定义页面
---

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

用户界面联系我们信息 内容在 inc/config.html 设置


## 使用开源框架
---

```html
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.11.4/semantic.min.css">
```

使用 [semantic-ui](http://semantic-ui.com/) CSS 框架

```html
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
```

使用 [jQuery](http://jquery.com/) JS 框架 由 [CDNJS](http://www.cdnjs.com/) 提供CDN加速

## 支持我
---

如果你觉得这个东西确实不错，可以通过支付宝支付我

我的二维码

![我的收款](http://ww1.sinaimg.cn/large/6211b300gw1efs74kpta6j205y05y74x.jpg)
