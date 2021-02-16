<?php if ( ! defined( 'ABSPATH' ) ) {  exit; } ?>



<style type="text/css">
#doc {
  background: white;
  max-width: 55em;
  border: 1px solid #ddd;
  margin: 2em;
  padding: 2em;
}

#doc h1 { font-size: 2.4rem; }
#doc h2 { font-size: 1.8rem;  padding-top: .8em; }
#doc h3 { margin: 0; padding-top: 1em; }

#doc blockquote,
#doc p,
#doc ul,
#doc ol  { font-size: 1.1rem; }

#doc blockquote,
#doc p,
#doc ul,
#doc ol  { line-height: 1.666; }

#doc ul, #doc ol {
  margin-left: 2em;
  padding-left: 1em;
}

#doc ul {
  list-style-type: disc;
}

#doc ul li + li ,
#doc ol li + li {
  padding-top: .2em;
}
</style>

<div id="doc">

<h1>Theme Documentation</h1>


<h2>Basic Wordpress Help </h2>
<p>Answers to many questions are available in the official Wordpress documentation: <a href="https://codex.wordpress.org/" target="_blank" rel="noopener">codex.wordpress.org</a> </p>


<h2>Duplicate Pages </h2>
<p>To clone an existing page, hover over the page name in the list under <strong>Pages&nbsp;&gt;&nbsp;All&nbsp;Pages</strong> and click <strong>Duplicate</strong> </p>

<h2>Backing Up the Database</h2>

<p>Export and save a .sql file of the database via <strong>Tools > Migrate DB Pro > BACK UP</strong></p>



<h2>Email Addresses </h2>

<p>This theme uses <strong>spamspan.js</strong> to prevent spammers and web crawlers from scraping email addresses from this site. To post a clickable email address hidden from spammers, add it in the <strong>Text</strong> view in the form <blockquote><span style="font-family: monospace;">&lt;span class="spamspan"&gt;&lt;span class="u"&gt;user&lt;/span&gt;[at]&lt;span class="d"&gt;website[dot]com&lt;/span&gt;&lt;/span&gt;</span></blockquote> <p>and the address will automatically turn into a clickable link on the front end.</p>



<h2>Wordpress Tips </h2>

<h3>Widows </h3>
<p>Avoid widows (single words at the start of a line) by adding a nonbreaking space between the last and second-to-last words. Switch to the <strong>Text</strong> tab and add the code <span style="font-family: monospace;">&amp;nbsp;</span> like so:</p>

<blockquote><span style="font-family: monospace;">...school&amp;nbsp;today.</span></blockquote>

<p>The nonbreaking space will be invisible from the <strong>Visual</strong> tab and on the front end. </p>




<h2>Plugins </h2>
<p>This theme relies on the following plugin(s):</p>

<ul>
  <li><a href="https://www.advancedcustomfields.com/pro/" target="_blank" rel="noopener">Advanced Custom Fields PRO</a><br />
    <em>Powers most custom templates</em><br />
    <strong>Custom Fields </strong>
  </li>

  <li>Gutenberg Blocks <br />
    <em>Custom plugin that creates wrapper divs around Wordpress-generated content blocks</em>
  </li>
</ul>


<p>Additional plugin(s) installed for security and ease of development: </p>
<ul>

  <li><a href="https://wordpress.org/plugins/acf-better-search/" target="_blank" rel="noopener">ACF Better Search</a><br />
    <em>Allows custom field content to appear in native Wordpress search&nbsp;results </em><br />
    <strong>Settings > ACF Better Search</strong></li>

  <li><a href="https://wordpress.org/plugins/async-javascript/" target="_blank" rel="noopener">Async JavaScript</a><br />
    <em>Adds the <span style="font-family: monospace; font-style: normal; font-weight: bold;">async</span> and/or <span style="font-family: monospace; font-style: normal; font-weight: bold;">defer</span> tags to Javascript files, improving page&nbsp;speed and Google search&nbsp;rank </em><br />
    <strong>Settings > Async Javascript</strong></li>

  <li><a href="https://wordpress.org/plugins/google-sitemap-generator/" target="_blank" rel="noopener">Google XML Sitemaps</a><br />
    <em>Excellent tool for dynamically-generated sitemaps to improve search appearance </em> <br />
    <strong>Settings > XML Sitemap </strong>
  </li>

  <li><a href="https://wordpress.org/plugins/hide-my-site/" target="_blank" rel="noopener">Hide My Site</a><br />
    Hides and secures page during <span class="white-space: nowrap;">non-public</span> phase of&nbsp;development.<br />
    <strong>Settings > Hide My Site </strong>
  </li>

  <li><a href="https://wordpress.org/plugins/limit-login-attempts-reloaded/" target="_blank">Limit Login Attempts Reloaded</a> <br />
  <em>Prevents brute force attacks to the site page</em><br />
  <strong>Settings > Limit Login Attempts </strong></li>

  <li><a href="https://wordpress.org/plugins/simple-301-redirects/" target="_blank" rel="noopener">Simple 301 Redirects </a><br />
    <em>Allows easy 301 redirects from previous generation of the site to the current site </em> <br />
    <strong>Settings > 301 Redirects </strong>
  </li>

  <li><a href="https://wordpress.org/plugins/svg-support/" target="_blank" rel="noopener">SVG Support</a><br />
    <em>Allows vector SVG files uploaded to the Wordpress media library, allowing crystal clear retina display</em><br />
    <strong>Settings > SVG Support </strong>
  </li>

  <li><a href="https://wordpress.org/plugins/webp-express/" target="_blank" rel="noopener">WebP Express</a> <br />
    <em>Allows images to be served in the <span style="white-space: nowrap">next-gen</span> .webp format, improving page&nbsp;speed. </em> </li>

  <li><a href="https://deliciousbrains.com/wp-migrate-db-pro/" target="_blank" rel="noopener">WP Migrate DB Pro</a> <br />
  <em>Easy database backups and migration</em><br />
  <strong>Tools > Migrage DB Pro </strong></li>
</ul>



</div>
