cd /usr/local/directadmin/data/skins/ #进入主题所在目录
tar -cf enhanced.tar.gz enhanced/ #备份主题目录
cd enhanced/ 进入主题所在目录
rm -rf * #删除文件夹内文件
wget http://www.elinkhost.com/download/enhanced-2014-4-8.tar.gz #下载NewWorld主题模版压缩包
tar xvzf enhanced-2014-4-8.tar.gz #解压缩
chown -R diradmin:diradmin * #设置主题所有权
rm -f enhanced-2014-4-8.tar.gz #删除主题模版压缩包
exit #退出

