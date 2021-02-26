# Theme Setup
###### current as of Feb 2021

## This Theme is a Child of HTML5 Blank
Parent theme: http://html5blank.com/

## Plugins
The plugins below have been carefully seleted for optimal page speed and security. All plugins have been vetted in the <a href="https://wpscan.com/" target="_blank" rel="noopener">Wordpress Vulnerability Database</a> for any unaddressed security holes.

- **ACF Better Search** https://wordpress.org/plugins/acf-better-search <br />
  Allows custom field content to appear in native Wordpress search&nbsp;results

- **Advanced Custom Fields PRO** https://www.advancedcustomfields.com/pro/ <br />
   Powers most custom templates

- **Async Javascript** https://wordpress.org/plugins/async-javascript/ <br />
Adds the <span style="font-family: monospace; font-style: normal; font-weight: bold;">async</span> and/or <span style="font-family: monospace; font-style: normal; font-weight: bold;">defer</span> tags to Javascript files, improving page&nbsp;speed and Google search&nbsp;rank

  **What is async? What is defer?** <br />
  More here: https://flaviocopes.com/javascript-async-defer/ <br />
  Short vsn: async blocks the parsing of the page while defer does not.
  > The best thing to do to speed up your page loading when using scripts is to put them in the head, and add a defer attribute to your script tag

- **Google Sitemap Generator** https://wordpress.org/plugins/google-sitemap-generator <br />
Excellent tool for dynamically-generated sitemaps to improve search appearance

- **Gutenberg Blocks** <br />
  Custom plugin that creates wrapper divs around Wordpress-generated content blocks

- **Hide My Site** https://wordpress.org/plugins/hide-my-site/ <br />
  Hides and secures page during <span class="white-space: nowrap;">non-public</span> phase of&nbsp;development

- **Limit Login Attempts Reloaded** https://wordpress.org/plugins/limit-login-attempts-reloaded/ <br />
Prevents brute force attacks to the site page <br />

- **Quick Page/Post Redirect Plugin** https://wordpress.org/plugins/quick-pagepost-redirect-plugin/ <br />
  Allows easy 301 redirects from previous generation of the site to the current site

- **SVG Support** https://wordpress.org/plugins/svg-support/ <br />
  Allows vector SVG files uploaded to the Wordpress media library, allowing crystal clear retina display

- **WebP Express**  https://wordpress.org/plugins/webp-express/ <br />
  Allows images to be served in the <span style="white-space: nowrap">next-gen</span> .webp format, improving page&nbsp;speed.

- **WP Migrate DB Pro** https://deliciousbrains.com/wp-migrate-db-pro/ <br />
  Easy database backups and migration


## Social Media / Open Graph
The default image and text shown when sharing a link to the website on social media is updated from the Wordpress admin section under  **Open Graph**

1. Images: `social-img`
>Recommended size: 1200px wide x 1200px high with focal point in the center.
>Image may be cropped to 1200px x 430px by social media platforms.
>This image is the default image that will programmatically appear when the site is shared on social media.
>Featured Image for a given post or page will override this image.

3. Text: `social-txt`
>Recommended: no more than 300 characters.
> This text is the default text that will programmatically appear when the site is shared on social media. Meta description for a given post or page will override this text.





## Meta Description
The **meta description**, i.e. the text snippet that usually appears in search results, is available from the custom field on each page and post under **Meta Description**

Recommended: no more than 160 characters. This text usually appears as the snippet in web search results.

NOTE: this snippet may be overridden by Google.

ALSO NOTE: Google does not use meta description keywords in search ranking <a href="https://webmasters.googleblog.com/2007/12/answering-more-popular-picks-meta-tags.html" target="_blank" rel="noopener">[citation]</a>



## Best Practices

Use `font-display: swap` in `@font-face` declarations



## Tools

1. Minify Javascript: https://javascript-minifier.com/

2. Minify CSS: https://cssminifier.com/

3. Compress SVGs: https://jakearchibald.github.io/svgomg/

4. Convert SVGs to CSS: https://websemantics.uk/tools/svg-to-background-image-conversion/
