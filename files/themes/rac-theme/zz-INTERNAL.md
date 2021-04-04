# Theme Setup
###### current as of Feb 2021

## This Theme is a Child of HTML5 Blank
Parent theme, if needed: http://html5blank.com/


## Create a Basic Wordpress Build
1. Download and unzip the latest version of Wordpress to `~\Library\WebServer\Documents\[ROOT]`
2. Create a new database in phpMyAdmin http://localhost/phpMyAdmin/
3. Visit http://localhost/[ROOT] and run database setup
4. Delete all Wordpress themes in `wp-content\themes\` except for latest Wordpress theme

## Set up Server Environment
In the remote web host:
1. Create a secure FTP account

    - Upload Wordpress files to remote via FTP
    - Delete all themes in remote `[ROOT]/wp-content/themes/` except for `twentynineteen`
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



## Set up Local Git
1. Copy `[THEME]\zz-gitignore.txt` to `[ROOT]` and rename `.gitignore`
    - only non-Wordpress themes in the `wp-content\themes` folder will be tracked
    - uploads and plugins must be transferred via FTP

2. Run `$ git init` in `[ROOT]`
3. Run an initial commit and push to confirm theme files properly load to remote

### Typical hooks/post-receive
`GIT_WORK_TREE=/home/u93-7w72ysv9se26/www/[SITE NAME]/public_html git checkout -f`

i.e. include the full server directory path; to get path: <br />
`$ ssh [SSH NAME]` <br />
`$ pwd`

###### src: http://toroid.org/ams/git-website-howto



### Typical Siteground git remote

`[SSH NAME]:www/[SITE NAME].git`

and `HOME` directory is implied

<br />
# Set Up Wordpress



## Plugins
See `README.md`


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

Save to `[ROOT]\` :

- touch.png  - 144px x 144px
- favicon.png - 32px x 32px
- favicon.ico - 32px x 32px


###### src: https://github.com/audreyr/favicon-cheat-sheet


## Create Google App Data
Save to `[ROOT]\icons\` :
- icon-32.png
- icon-72.png
- icon-144.png
- icon-196.png

Save to `[ROOT]` :
- manifest.json

###### src: https://developer.chrome.com/apps/manifest



## Load Starter Data
Activate WP Migrate DB Pro under **Tools > Migrate DB Pro > Settings**

Import starter data under **Tools > Migrate DB Pro > Import**



## Pages
1. Add

2. Change Sample Page to Home

3. Set Home as Front Page

4. Change Privacy Policy Order to 900

5. Create Login page with template Login with Order 900 and permalink `admin-login`

6. Set Kitchen Sink to order 999 and exclude from native Wordpress search

7. Create pages to populate the sitemap

8. Create the Main Menu and add to location Main Menu





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


## ImageMagick Command Line
More at https://imagemagick.org/

`convert SAMPLE.jpg -sampling-factor 4:2:0 -quality 85 -interlace JPEG -colorspace RGB compressed/SAMPLE.jpg`



## Compression + Security
All the stuff in MOVE-TO-ROOT.txt

`[ROOT]` or `wp-config.php` location
- expire headers
- cache-control headers
- turn etags off
- gZIP compression

`[ROOT]/dev` or Wordpress location
- secure wp-config.php
- block xmprpc.php requests
- limit upload file types


## Prevent WP Admin File Editing
In `wp-config.php` :

`define( 'DISALLOW_FILE_EDIT', true);`

## Auto-update Plugins
In `wp-config.php` :

`add_filter( 'auto_update_plugin', '__return_true' );`



## Scripts

### External scripts - `preconnect` vs `dns-prefetch`
> The practical difference is hence, **if you know that a server fetch will happen for sure, preconnect is good**. If it will happen only sometimes, and you expect huge traffic, preconnect might trigger a lot of useless TCP and TLS work, and dns-prefetch might be a better fit.

#### src: https://stackoverflow.com/questions/47273743/preconnect-vs-dns-prefetch-resource-hints#:~:text=The%20practical%20difference%20is%20hence,might%20be%20a%20better%20fit.


###
> Just tell me the best way <br />
> The best thing to do to speed up your page loading when using scripts is to **put them in the head, and add a defer attribute** to your script tag

#### src: https://flaviocopes.com/javascript-async-defer/#just-tell-me-the-best-way



###
> Async scripts are great when we integrate an independent third-party script into the page: counters, ads and so on, as they don’t depend on our scripts, and our scripts shouldn’t wait for them

#### src: https://javascript.info/script-async-defer 
