<?php
include("/auth.php");
#  update accounts on fw
//`echo "*/12 *	* * *	root	/bin/php /opt/bin/autoupdate/check_new_accounts_update.php" > /var/www/iam/loaddata/update_cron_acc`;
`echo 1 > /var/www/iam/loaddata/update_cron_acc`;

?>

