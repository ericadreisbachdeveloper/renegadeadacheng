# Theme Setup

These instructions assume
- Git is already installed
- local MAMP server running

## This Theme is a Child of HTML5 Blank
Parent theme, if needed: http://html5blank.com/


## Create a Basic Wordpress Build
1. Download and unzip the latest version of Wordpress to `~\Library\WebServer\Documents\root`
2. Create a new database in phpMyAdmin http://localhost/phpMyAdmin/
3. Visit http://localhost/root and run database setup
4. Delete all Wordpress themes in `wp-content\themes\` except for `wp-content\themes\twentynineteen`

## Set up Server Environment
In the remote web host:
1. Create a secure FTP account

    - Upload Wordpress files to remote via FTP
    - Delete all themes in remote `root/wp-content/themes/` except for `twentynineteen`
2. Create an SSH account

    - update local `~\.ssh\config` with SSH credentials
    - confirm access to host
    - note results of `$ pwd`
3. Create a MySQL instance

    - create a database user if needed
    - create a database
    - give database user all priviletes to database
    - make a note of database user, database user's password, and database

4. Set up Wordpress on remote with database credentials



## Set up Git to Manage Website
1. Copy `THEME\.gitignore` to `root`

  - only non-Wordpress themes in the `wp-content\themes` folder will be tracked
  - uploads and plugins should be moved, if needed, via FTP

2. Run `$ git init` in `root`
3. Run an initial commit and push to confirm theme files properly load to remote

### A Typical Siteground git remote
`greenapple:www/greenapplestemedu.com/greenapple.git`

i.e. `$ pwd` value implied in `greenapple`

### A Typical hooks/post-receive
`GIT_WORK_TREE=/home/u93-7w72ysv9se26/www/greenapplestem.co/public_html git checkout -f`

i.e. explicit `$ pwd` string

###### src: http://toroid.org/ams/git-website-howto


<span style="font-size: 3rem; line-height: 3;">Ok time to ACTUALLY set up Wordpress ...</span>

## Plugins
- **ACF Better Search** https://wordpress.org/plugins/acf-better-search <br />
  Allows custom field content to appear in native Wordpress search&nbsp;results

- **Advanced Custom Fields PRO** https://www.advancedcustomfields.com/pro/ <br />
   Powers most custom templates

- **Async Javascript** https://wordpress.org/plugins/async-javascript/ <br />
Adds the <span style="font-family: monospace; font-style: normal; font-weight: bold;">async</span> and/or <span style="font-family: monospace; font-style: normal; font-weight: bold;">defer</span> tags to Javascript files, improving page&nbsp;speed and Google search&nbsp;rank

- **Google Sitemap Generator** https://wordpress.org/plugins/google-sitemap-generator <br />
Excellent tool for dynamically-generated sitemaps to improve search appearance

- **Gutenberg Blocks** <br />
  Custom plugin that creates wrapper divs around Wordpress-generated content blocks

- **Hide My Site** https://wordpress.org/plugins/hide-my-site/ <br />
  Hides and secures page during <span class="white-space: nowrap;">non-public</span> phase of&nbsp;development

- **Limit Login Attempts Reloaded** https://wordpress.org/plugins/limit-login-attempts-reloaded/ <br />
Prevents brute force attacks to the site page <br />

- **Simple 301 Redirects** https://wordpress.org/plugins/simple-301-redirects/ <br />
  Allows easy 301 redirects from previous generation of the site to the current site

- **SVG Support** https://wordpress.org/plugins/svg-support/ <br />
  Allows vector SVG files uploaded to the Wordpress media library, allowing crystal clear retina display

- **WebP Express**  https://wordpress.org/plugins/webp-express/ <br />
  Allows images to be served in the <span style="white-space: nowrap">next-gen</span> .webp format, improving page&nbsp;speed.

- **WP Migrate DB Pro** https://deliciousbrains.com/wp-migrate-db-pro/ <br />
  Easy database backups and migration

###### current as of Feb 2021


## Create Screenshot
Recommended size: 1200px wide x 900px high

Save as `THEME\screenshot.jpg`

## Create Favicons
Save to `THEME\favicons\` :
- favicon-310x150.png
- favicon-310.png
- favicon-196.png
- favicon-144.png
- favicon-120.png
- favicon-114.png
- favicon-72.png
- favicon-32.png

Save to `root\` :

- touch.png  - 144px x 144px
- favicon.png - 32px x 32px
- favicon.ico - 32px x 32px


###### src: https://github.com/audreyr/favicon-cheat-sheet


## Create Google App Data
Save to `root\icons\` :
- icon-32.png
- icon-72.png
- icon-144.png
- icon-196.png

Save to `root` :
- manifest.json

###### src: https://developer.chrome.com/apps/manifest




## Load Starter Data
Activate WP Migrate DB Pro under **Tools > Migrate DB Pro > Settings**

Import starter data under **Tools > Migrate DB Pro > Import**


## Pages
Change Sample Page to Home

Set Home as Front Page

Change Privacy Policy Order to 900

Create Login page with template Login with Order 800

Add Login page ID to be excluded in native Wordpress search under <br />**Settings > SearchWP > Pages > Rules > Excluded IDs**

Set Kitchen Sink to order 999 and exclude from native Wordpress search

Create the Main Menu and add to location Main Menu





## Social Media / Open Graph
1. In Advanced Custom Fields (**Custom Fields**) create the Field Group **Open Graph**

2. Create the image field `social-img` with the following description:
>Recommended size: 1200px wide x 1200px high with focal point in the center.
>Image may be cropped to 1200px x 430px by social media platforms.
>This image is the default image that will programmatically appear when the site is shared on social media.
>Featured Image for a given post or page will override this image.

3. Create the textarea field `social-txt` with the following description:
>Recommended: no more than 300 characters.
> This text is the default text that will programmatically appear when the site is shared on social media. Meta description for a given post or page will override this text.


## Meta Description
1. In Advanced Custom Fields (**Custom Fields**) create the Field Group **Search Appearance** and Text Area field **Meta Description**

2. Add the following description:
> Recommended: no more than 160 characters.
> This text usually appears as the snippet in web search results. &lt;br /&gt; &lt;br /&gt;
> NOTE: this snippet may be overridden by Google &lt;br /&gt; &lt;br /&gt;
> ALSO NOTE: Google does not use meta description keywords in search ranking &lt;a href=&quot;https://webmasters.googleblog.com/2007/12/answering-more-popular-picks-meta-tags.html&quot; target=&quot;_blank&quot; rel=&quot;noopener&quot;&gt;[citation]&lt;/a&gt;



## Compression + Security
All the stuff in MOVE-TO-ROOT.txt

`root`
- expire headers
- cache-control headers
- turn etags off
- gZIP compression

`root/dev`
- secure wp-config.php
- block xmprpc.php requests
- limit upload file types


## Prevent WP Admin File Editing
In `wp-config.php` :

`define( 'DISALLOW_FILE_EDIT', true);`

## Auto-update Plugins
In `wp-config.php` :

`add_filter( 'auto_update_plugin', '__return_true' );`
