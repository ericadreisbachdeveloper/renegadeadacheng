## wp-config.php

1. For security, the main configuration file wp-config.php is located one directory higher than the Wordpress install directory

2. File editing from the Wordpress back end is disabled:

  `define( 'DISALLOW_FILE_EDIT', true);`

3. Plugins are set to updated automatically:

  `add_filter( 'auto_update_plugin', '__return_true' );`
