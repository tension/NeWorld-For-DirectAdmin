#!/bin/bash
cd /etc/directadmin/data/files
chown root *; chgrp root *; chmod 644 *;
chown root admin/*; chgrp root admin/*; chmod 644 admin/*;
chown root images/*; chgrp root images/*; chmod 644 images/*;
chown root reseller/*; chgrp root reseller/*; chmod 644 reseller/*;
chown root user/*; chgrp root user/*; chmod 644 user/*;
chown root user/db/*; chgrp root user/db/*; chmod 644 user/db/*;
chown root user/email/*; chgrp root user/email/*; chmod 644 user/email/*;
chown root user/filemanager/*; chgrp root user/filemanager/*; chmod 644 user/filemanager/*;
chown root user/ftp/*; chgrp root user/ftp/*; chmod 644 user/ftp/*;
chown root user/ticket/*; chgrp root user/ticket/*; chmod 644 user/ticket/*;

chmod 755 admin
chmod 755 images
chmod 755 reseller
chmod 755 user
chmod 755 user/db
chmod 755 user/email
chmod 755 user/filemanager
chmod 755 user/ftp
chmod 755 user/ticket

chmod 700 set_permissions.sh

