<?php if ( ! defined( 'ABSPATH' ) ) {  exit; } global $metadescription, $title, $page_url, $page_title, $site_url, $socialimg, $socialimg_id, $gmt_published, $gmt_modified, $global_socialimg, $socialimg, $socialimg_h, $socialimg_w, $socialimg_alt, $current_page_parent_menu_id, $parent_title, $parent_url, $cat_title, $cat_url; ?>
<script type='application/ld+json'>
{
  "@context": "http://www.schema.org",
  "@graph": [
    {
        "@type": "WebSite",
        "@id": "<?php _e($site_url); ?>#website",
        "url": "<?php _e($site_url); ?>",
        "name": "<?php _e(get_bloginfo('name')); ?>",
        "description": "<?php _e(get_bloginfo('description')); ?>",
        "potentialAction": [
            {
                "@type": "SearchAction",
                "target": "<?php _e($site_url); ?>/?s={search_term_string}",
                "query-input": "required name=search_term_string"
            }
        ],
        "inLanguage": "en-US"
    },
    {
        "@type": "WebPage",
        "@id": "<?php _e($site_url); ?>#webpage",
        "url": "<?php _e($page_url); ?>",
        "name": "<?php _e($title); ?>",
        "isPartOf": {
            "@id": "<?php _e($site_url); ?>/#website"
        },
        "primaryImageOfPage": {
            "@type": "ImageObject",
            "contentUrl": "<?php _e($socialimg); ?>",
            "description": "<?php _e($socialimg_alt); ?>",
            "width": "<?php _e($socialimg_w); ?>",
            "height": "<?php _e($socialimg_h); ?>"
        },
        "datePublished": "<?php _e($gmt_published); ?>",
        "dateModified": "<?php _e($gmt_modified); ?>",
        "inLanguage": "en-US",
        "potentialAction": [
            {
                "@type": "ReadAction",
                "target": [
                    "<?php _e($page_url); ?>"
                ]
            }
        ]
    },
    {
      "@type": "Person",
      "@id": "<?php _e($site_url); ?>#person",
      "name": "Ada Cheng",
      "jobTitle": "Speaker",
      "gender": "female",
      "url": "<?php _e($site_url); ?>",
      "sameAs": [
         "https://www.facebook.com/dr.adacheng/",
         "https://www.instagram.com/sjadacheng/",
         "https://www.youtube.com/user/renegadeadacheng/",
         "https://www.linkedin.com/in/ada-cheng-ph-d-622b4216/"
      ],
      "image": "<?php _e($global_socialimg); ?>",
      "address": {
         "@type": "PostalAddress",
         "addressLocality": "Chicago",
         "addressRegion": "Illinois"
      }
    },
    {
      "@type": "BreadcrumbList",
      "@id": "<?php _e($site_url); ?>#breadcrumb",
      "itemListElement":
       [
        {
         "@type": "ListItem",
         "position": 1,
         "item":
         {
          "@type": "WebPage",
            "@id": "<?php _e($site_url); ?>",
            "url": "<?php _e($site_url); ?>",
           "name": "<?php _e(get_bloginfo('name')); ?> | Home"
          }
        }
        <?php if( is_single()) : ?>
        ,{
         "@type": "ListItem",
         "position": 2,
         "item":
         {
           "@type": "WebPage",
             "@id": "<?php _e($parent_url); ?>",
             "url": "<?php _e($parent_url); ?>",
            "name": "<?php _e($parent_title); ?>"
         }
         ,{
          "@type": "ListItem",
          "position": 3,
          "item":
          {
            "@type": "WebPage",
              "@id": "<?php _e($cat_url); ?>",
              "url": "<?php _e($cat_url); ?>",
             "name": "<?php _e($cat_title); ?>"
          }
         ,{
          "@type": "ListItem",
          "position": 4,
          "item":
          {
            "@type": "WebPage",
              "@id": "<?php _e($page_url); ?>",
              "url": "<?php _e($page_url); ?>",
             "name": "<?php _e($page_title); ?>"
          }
        }
        <?php elseif( is_archive()) : ?>
        ,{
         "@type": "ListItem",
         "position": 2,
         "item":
         {
           "@type": "WebPage",
             "@id": "<?php _e($parent_url); ?>",
             "url": "<?php _e($parent_url); ?>",
            "name": "<?php _e($parent_title); ?>"
         }
         ,{
           "@type": "ListItem",
           "position": 3,
           "item":
           {
             "@type": "WebPage",
               "@id": "<?php _e($cat_url); ?>",
               "url": "<?php _e($cat_url); ?>",
              "name": "<?php _e($cat_title); ?>"
         }
        <?php elseif( !is_front_page() && (is_search() || $current_page_parent_menu_id == '0' || $current_page_parent_menu_id == '79') ) : ?>
        ,{
         "@type": "ListItem",
         "position": 2,
         "item":
         {
           "@type": "WebPage",
             "@id": "<?php _e($page_url); ?>",
             "url": "<?php _e($page_url); ?>",
            "name": "<?php _e($page_title); ?>"
         }
        }
        <?php elseif($current_page_parent_menu_id !== '0') : ?>
        ,{
          "@type": "ListItem",
          "position": 2,
          "item":
          {
            "@type": "WebPage",
              "@id": "<?php _e($parent_url); ?>",
              "url": "<?php _e($parent_url); ?>",
             "name": "<?php _e($parent_title); ?>"
          }
        },
        {
          "@type": "ListItem",
          "position": 3,
          "item":
          {
            "@type": "WebPage",
              "@id": "<?php _e($page_url); ?>",
              "url": "<?php _e($page_url); ?>",
             "name": "<?php _e($page_title); ?>"
          }
        }
        <?php endif; ?>
      ]
    }
  ]
}
</script>
