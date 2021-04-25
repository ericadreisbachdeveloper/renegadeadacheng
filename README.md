# RenegadeAdaCheng.com

###### as of April 2021 - erica dreisbach - erica@ericadreisbach.com



## Underlying Tech
PHP vsn 7.4.15

MySQL vsn 5.7.32-35



## Version Control
This site is under Git version control tracking:
* `.gitignore`
* `.README.md`
* `icons/`
* `files/themes/`
* `files/mu-plugins/`

... and almost no other directories or files. See `.gitignore` in this directory for full details.

Version control is maintained over a limited scope to avoid discrepancies and overwrites to core Wordpress files, plugin, and media files. Wordpress and plugins be kept <span style="white-space: nowrap;">up-to-date</span> separately. Periodic S/FTP transfer of media files is recommended.



## Connect to the Repository
First create or confirm your connection to the server via SSH without requiring a password. This process varies from host to host. Instructions for sites hosted on SiteGround here: https://www.siteground.com/kb/how_to_log_in_to_my_shared_account_via_ssh_in_linux/

The remote Git repo is `ada`<br />
The remote Git hook is in `dev.git/hooks/post-receive`

After establishing an SSH connection and local alias in `~/.ssh/config` a typical connection from the command line would be:

`$ git remote add ada ada:www/adac1.sg-host.com/dev.git`

where `ada` is a local alias to connect to the server, a la

`$ ssh ada`

More information on SSH here: https://www.ssh.com/academy/ssh/command#ssh-command-in-linux

Detailed instructions on the technique used here: https://toroid.org/git-website-howto


**NOTE: the /wp-content/ directory is renamed /files/** <br />
Local site clones must match this directory structure for successful version control. <br />



## Wordpress /wp-content/ Directory - Security Through Obscurity
The `/wp-content/` directory is renamed `/files/` to limit automated attacks. The lines below in `wp-config.php` point plugin, media, theme, and other content to  `/files/`

`if ( ! defined( 'ABSPATH' ) ) { define( 'ABSPATH', __DIR__ . '/' ); }`<br />
`define ('WP_CONTENT_FOLDERNAME', 'files');` <br />
`define( 'WP_CONTENT_DIR', ABSPATH . '/files' );` <br />
`define( 'WP_SITEURL', 'https://' . $_SERVER['HTTP_HOST'] . '/');` <br />
`define( 'WP_CONTENT_URL', WP_SITEURL . WP_CONTENT_FOLDERNAME);`

More information here: https://wordpress.org/support/article/editing-wp-config-php/#moving-wp-content-folder



# Security + Hardened Wordpress
Wordpress is a notoriously vulnerable web platform. This site uses many of the following security techniques: https://wordpress.org/support/article/hardening-wordpress/



## Wordpress Install Directory - Security Through Obscurity
The Wordpress installation directory is `public_html/jrdkfgjs` and not the root directory. This allows for a cleaner root installation and a simpler site migration process down the line.

Rules pointing the site are in `public_html/.htaccess`



## wp-config.php Location - Security Through Obscurity
The `wp-config.php` file, which includes the database password in plaintext (!), is in `public_html/`, one directory higher than the Wordpress installation folder.



## wp-config.php - Adding Plugins from Back End Interface Disabled
Every plugin adds security vulnerabilities. Most plugins also include large and unnecessary scripts and style files that slow down sites. Many add significant database bloat, even when uninstalled.

For this reason, plugin installation from the GUI back end is disabled, thus gatekeeping plugin installation to users with command line or direct server access.

The following line in `wp-config.php` disables back end **Add New Plugins** functionality:

`define('DISALLOW_FILE_MODS', true);`



## wp-config.php - Back End File Editing Disabled
The following line in `wp-config.php` disables default editing theme files directly from the Wordpress back end:

`define( 'DISALLOW_FILE_EDIT', true);`



## File Permissions
All directories are set to permission `755`

All files are set to user permission `644`



## Restricted Database Privileges
After installing Wordpress, the database user associated with the site database was restricted to the privileges `SELECT, INSERT, UPDATE, DELETE`



## Plugin Auto-Updates Enabled
The following line in `files/themes/rac-theme/functions.php` keeps most plugins updated as soon as new versions are available:

`add_filter( 'auto_update_plugin', '__return_true' );`



## XML-RPC Disabled
XML-RPC is a protocol that allows non-Wordpress applications to access Wordpress. However it is rarely used in modern builds and is a common vector for malicious attacks.

The lines below in `public_html/jrdkfgjs/.htaccess` block XML-RPC requests:

`# BEGIN Block WordPress xmlrpc.php requests` <br />
`<Files xmlrpc.php>` <br />
`order deny,allow` <br />
`deny from all` <br />
`# allow from 123.123.123.123` <br />
`</Files>`

More on why XML-RPC should be disabled: https://kinsta.com/blog/xmlrpc-php/



# Speed + Additional Security



## Compression
`.htaccess` files in the directories below include commented sections that do the following:

`public_html/.htaccess`
- disable directory browsing
- deny access to `wp-config.php`

`public_html/jrdkfgjs/.htaccess`
- add expire headers
- add cache-control headers
- turn off etags - https://web.dev/http-cache/#validating_cached_responses_with_etags
- block xmprpc.php requests (see below)

`public_html/jrdkfgjs/files/uploads`
- secure uploads from malicious file types
- whitelist jpg, jpeg, gif, png, tif, tiff, pdf, svg, htaccess, webp



## ImageMagick
Imagick runs via the line
`extension=imagick.so`
in
`public_html/php.ini`


## Flush Cache
Flush object cache from within the CLI by SSH'ing into the Wordpress install directory `www/adac1.sghost.com/public_html/jrdkfjgs/` and running

`$ wp cache flush`
