## wp-config.php

As of 17 Feb 2021
PHP vsn 7.4.15
MySQL vsn 5.7.32-35


1. For security, the main configuration file wp-config.php is located one directory higher than the Wordpress install directory

2. File editing from the Wordpress back end is disabled:

  `define( 'DISALLOW_FILE_EDIT', true);`

3. Plugins are set to updated automatically:

  `add_filter( 'auto_update_plugin', '__return_true' );`


4. Imagick enabled with public_html/php.ini

   `extension=imagick.so`

    and public_html/.htaccess

   `SetEnv PHPRC /home/customer/www/domain.com/public_html/php.ini`
