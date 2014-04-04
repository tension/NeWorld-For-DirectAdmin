#!/bin/bash

if [ $(id -u) != "0" ]; then
    printf "错误: 必须使用root权限运行本脚本!\n"
    exit 1
fi
clear
printf "
####################################################
#                                                  #
# NewWorld For DirectAdmin                         #
# Version: 1.1                                     #
# Author: tension                                  #
# Website: http://tension.name                     #
# For DirectAdmin                                  #
#                                                  #
####################################################
"

cd /usr/local/directadmin/data/skins/ #进入主题所在目录
wget https://github.com/tension/NewWorld/archive/master.zip #下载NewWorld主题模版压缩包
unzip master #解压缩主题压缩包
mv NewWorld-master/ NewWorld/ #修改主题文件夹名称
chown -R diradmin:diradmin NewWorld/ #设置主题所有权
rm -f master #删除主题模版压缩包
exit #退出