# RenegadeAdaCheng.com

###### as of  Feb 2021 - erica dreisbach - erica@ericadreisbach.com


## Underlying Tech
PHP vsn 7.4.15
MySQL vsn 5.7.32-35



## Version Control
This site is under Git version control targeting the directories:
* `wp-content/themes/`
* `wp-content/mu-plugins/`

... and almost no other directories or files. See `.gitignore` in this directory for full details.

Version control is maintained over a limited scope to avoid discrepancies and overwrites to core Wordpress files, plugin, and media files. Wordpress and plugins be kept <span style="white-space: nowrap;">up-to-date</span> separately. Periodic S/FTP transfer of media files is recommended.

Connect to the Git repository by first confirming you can connection to the server via SSH without requiring a password. This process varies from host to host. Instructions for sites hosted on SiteGround here: https://www.siteground.com/kb/how_to_log_in_to_my_shared_account_via_ssh_in_linux/

The remote Git hook is located in `/home/u299-bgsbpjxst6zm/www/adac1.sg-host.com/dev.git/hooks/post-receive`

Detailed instructions: https://toroid.org/git-website-howto


**NOTE: the /wp-content/ directory is renamed /files/ &mdash; local site clones must match this directory structure for successful version control**



# Hardened Wordpress
Wordpress is a notoriously vulnerable web platform. This site uses many of the following security techniques for a hardened Wordpress build. More here: https://wordpress.org/support/article/hardening-wordpress/



## Security Through Obscurity - Wordpress wp-content Directory
The `/wp-content/` directory is renamed `/files/` to prevent some automated attacks. The lines below in `wp-config.php` point plugin, media, theme, and other content to  `/files/`

`if ( ! defined( 'ABSPATH' ) ) { define( 'ABSPATH', __DIR__ . '/' ); }`<br />
`define ('WP_CONTENT_FOLDERNAME', 'files');` <br />
`define( 'WP_CONTENT_DIR', ABSPATH . '/files' );` <br />
`define( 'WP_SITEURL', 'https://' . $_SERVER['HTTP_HOST'] . '/');` <br />
`define( 'WP_CONTENT_URL', WP_SITEURL . WP_CONTENT_FOLDERNAME);`

More information here: https://wordpress.org/support/article/editing-wp-config-php/#moving-wp-content-folder



## Configuration File
The `wp-config.php` file, which includes the database password in plaintext (!), is one directory higher than the root Wordpress installation folder.



## File Permissions
All directories are set to permission `755`

All files are set to user permission `644`



## Restricted Database Privileges
After installing Wordpress, the database user associated with the site database was restricted to the privileges `SELECT, INSERT, UPDATE, DELETE`



## Back End File Editing Disabled
The following line in `wp-config.php` disables default editing theme files directly from the Wordpress back end:

`define( 'DISALLOW_FILE_EDIT', true);`



## Adding Plugins from Back End Interface Disabled
Every plugin adds security vulnerabilities. Most also include large and unnecessary scripts and style files that slow down sites. Many add significant database bloat, even when uninstalled. For this reason, plugin installation from the GUI back end is disabled, thus gatekeeping plugin installation to users with command line or direct server access.

The following line in `wp-config.php` disables back end **Add New Plugins** functionality:

`define('DISALLOW_FILE_MODS', true);`



## Plugins Auto-Update
The following line in `wp-config.php` keeps most plugins updated as soon as new versions are available:

`add_filter( 'auto_update_plugin', '__return_true' );`




# Speed

## Compression
`.htaccess` files in the directories below include commented sections that do the following:

`[root]/.htaccess`
- disable directory browsing
- deny access to `wp-config.php`

`[root]/[WORDPRESS LOCATION]/.htaccess`
- add expire headers
- add cache-control headers
- turn off etags - https://web.dev/http-cache/#validating_cached_responses_with_etags
- add gZIP compression
- block xmprpc.php requests

`[root]/[WORDPRESS LOCATION]/wp-content/uploads`
- secure uploads from malicious file types
- whitelist jpg, gif, png, tif, pdf, svg, htaccess, webp



## ImageMagick
Imagick enabled in `public_html/php.ini`
`extension=imagick.so`

and called from `public_html/.htaccess`
`SetEnv PHPRC /home/customer/www/domain.com/public_html/php.ini`
