<?php
include("/auth.php");
#  update accounts on fw
//`echo "*/10 *	* * *	root	/bin/php /opt/bin/autoupdate/check_new_accesslist_update.php" > /var/www/iam/loaddata/update_cron_acl`;
`echo 1 > /var/www/iam/loaddata/update_cron_acl`;

?>