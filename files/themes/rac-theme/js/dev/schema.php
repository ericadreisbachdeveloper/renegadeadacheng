<!--  https://www.textfixer.com/tools/remove-line-breaks.php  -->
<!--
      $title is more verbose, better for search results title and browser titles
      $page_title is more bare, better for breadcrumbs

      potentialAction - Google as of April 2021 seems to only recognize
      SEARCH — allows user search of this site from within a Google page

      Breadcrumb types:
      1. Home
      2. Home > Storytelling Videos > Category > Single
      3. Home > Storytelling Vidoes > Category
      4. Home > Top-level page  -OR-  Search  -OR-  child of About
      5. Home > Parent > Child


      isPartOf @id DOES pull the main /#website id
-->


<?php if ( ! defined( 'ABSPATH' ) ) {  exit; }
      global $post_id, $metadescription, $page_url, $page_title, $site_url, $socialimg, $socialimg_id, $gmt_published, $gmt_modified, $global_socialimg, $socialimg, $socialimg_h, $socialimg_w, $socialimg_alt, $current_page_parent_menu_id, $parent_title, $parent_url, $cat_title, $cat_url; ?>


      <?php $extra_schemae = '';
  		if(have_rows('schema-fields', $post_id)) : ?>
  			<?php $extra_schemae .= ","; $count = '1'; ?>

  			<?php $number_of_schemae = count(get_field('schema-fields')); $count = "1"; while(have_rows('schema-fields', $post_id)) : the_row(); ?>

  			<?php if(get_sub_field('is-parent') && get_sub_field('is-parent') == 'yes') : ?>

  			<?php $extra_schemae .= '"' . get_sub_field('parent-field') . '": {';

  				$number_of_children = "";
  				$number_of_children = count(get_sub_field('children'));
  				if(have_rows('children')) : $children = 1;
  				while(have_rows('children')) : the_row();

  				$extra_schemae .= '"' . get_sub_field('child-name') . '": "' . get_sub_field('child-value') . '"'; if($number_of_children > $children) { $extra_schemae .= ", "; }

  				$children++; endwhile; $extra_schemae .= "} "; endif;
  				// end parents
  				?>
  			<?php elseif(get_sub_field('is-parent') && get_sub_field('is-parent') == 'no') : ?>
  				<?php $extra_schemae .= '"' . get_sub_field('field') . '": "' . get_sub_field('value') . '"'; if($number_of_schemae > $count) { $extra_schemae .= ","; } ?>

  			<?php endif; ?>

  		<?php $count++; endwhile; endif; ?>




<script type='application/ld+json'>{
  "@context": "https://www.schema.org",
  "@graph": [


    {
      "@type": "WebSite",
      "@id": "<?php _e($site_url); ?>#website",
      "name": "<?php _e(get_bloginfo('name')); ?> | Official Site",
      "url": "<?php _e($site_url); ?>",
      "description": "<?php _e(get_bloginfo('description')); ?>",
      "potentialAction": [
        {
          "@type": "SearchAction",
          "@id": "<?php _e($site_url); ?>#search",
          "name": "Renegade Ada Cheng | Search",
          "target": "<?php _e($site_url); ?>/?s={search_term_string}",
          "query-input": "required name=search_term_string"
        }
      ],
      "inLanguage": "en-US"
    },


    {
      "@type": "BreadcrumbList",
      "@id": "<?php _e($site_url); ?>#breadcrumb",
      "name": "<?php _e(get_bloginfo('name')); ?> breadcrumbs",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "item": {
            "@type": "WebPage",
            "@id": "<?php _e($site_url); ?>",
            "url": "<?php _e($site_url); ?>",
            "name": "<?php _e(get_bloginfo('name')); ?> | Home",
            "primaryImageOfPage": {
              "@type": "ImageObject",
              "@id": "<?php _e($site_url); ?>#featuredimage",
              "contentUrl": "<?php _e($global_socialimg); ?>"
            },
            "creator": {
              "@type": "Person",
              "@id": "<?php _e($site_url); ?>#adacheng",
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
              }<?php _e($extra_schemae); ?>
            }
          }
        }

        <?php if( is_single()) : ?>,
        {
          "@type": "ListItem",
          "position": 2,
          "item": {
            "@type": "WebPage",
            "@id": "<?php _e($parent_url); ?>",
            "url": "<?php _e($parent_url); ?>",
            "name": "<?php _e($parent_title); ?>"
          }
        },
        {
          "@type": "ListItem",
          "position": 3,
          "item": {
            "@type": "WebPage",
            "@id": "<?php _e($cat_url); ?>",
            "url": "<?php _e($cat_url); ?>",
            "name": "<?php _e($cat_title); ?>"
          }
        },
        {
          "@type": "ListItem",
          "position": 4,
          "item": {
            "@type": "WebPage",
            "@id": "<?php _e($page_url); ?>",
            "url": "<?php _e($page_url); ?>",
            "name": "<?php _e($page_title); ?>"<?php _e($extra_schemae); ?>
          }
        }

        <?php elseif( is_archive()) : ?>,
        {
          "@type": "ListItem",
          "position": 2,
          "item": {
            "@type": "WebPage",
            "@id": "<?php _e($parent_url); ?>",
            "url": "<?php _e($parent_url); ?>",
            "name": "<?php _e($parent_title); ?>"
          }
        },
        {
          "@type": "ListItem",
          "position": 3,
          "item": {
            "@type": "WebPage",
            "@id": "<?php _e($page_url); ?>",
            "url": "<?php _e($page_url); ?>",
            "name": "<?php _e($page_title); ?>",
            "description": "<?php _e($metadescription); ?>",
            "isPartOf": {
              "@id": "<?php _e($site_url); ?>/#website"
            },
            "primaryImageOfPage": {
              "@type": "ImageObject",
              "@id": "<?php _e($page_url); ?>#featuredimage",
              "contentUrl": "<?php _e($socialimg); ?>",
              "description": "<?php _e($socialimg_alt); ?>",
              "width": "<?php _e($socialimg_w); ?>",
              "height": "<?php _e($socialimg_h); ?>"
            },
            "datePublished": "<?php _e($gmt_published); ?>",
            "dateModified": "<?php _e($gmt_modified); ?>",
            "inLanguage": "en-US"
          }
        }

        <?php elseif( !is_front_page() && (is_search() || $current_page_parent_menu_id == '0' || $current_page_parent_menu_id == '79') ) : ?>,
        {
          "@type": "ListItem",
          "position": 2,
          "item": {
            "@type": "WebPage",
            "@id": "<?php _e($page_url); ?>",
            "url": "<?php _e($page_url); ?>",
            "name": "<?php _e($page_title); ?>",
            "description": "<?php _e($metadescription); ?>",
            "isPartOf": {
              "@id": "<?php _e($site_url); ?>/#website"
            },
            "primaryImageOfPage": {
              "@type": "ImageObject",
              "@id": "<?php _e($page_url); ?>#featuredimage",
              "contentUrl": "<?php _e($socialimg); ?>",
              "description": "<?php _e($socialimg_alt); ?>",
              "width": "<?php _e($socialimg_w); ?>",
              "height": "<?php _e($socialimg_h); ?>"
            },
            "datePublished": "<?php _e($gmt_published); ?>",
            "dateModified": "<?php _e($gmt_modified); ?>",
            "inLanguage": "en-US"<?php _e($extra_schemae); ?>
          }
        }

        <?php elseif($current_page_parent_menu_id !== '0') : ?>,
        {
          "@type": "ListItem",
          "position": 2,
          "item": {
            "@type": "WebPage",
            "@id": "<?php _e($parent_url); ?>",
            "url": "<?php _e($parent_url); ?>",
            "name": "<?php _e($parent_title); ?>"
          }
        },
        {
          "@type": "ListItem",
          "position": 3,
          "item": {
            "@type": "WebPage",
            "@id": "<?php _e($page_url); ?>",
            "url": "<?php _e($page_url); ?>",
            "name": "<?php _e($page_title); ?>",
            "description": "<?php _e($metadescription); ?>",
            "isPartOf": {
              "@id": "<?php _e($site_url); ?>/#website"
            },
            "primaryImageOfPage": {
              "@type": "ImageObject",
              "@id": "<?php _e($page_url); ?>#featuredimage",
              "contentUrl": "<?php _e($socialimg); ?>",
              "description": "<?php _e($socialimg_alt); ?>",
              "width": "<?php _e($socialimg_w); ?>",
              "height": "<?php _e($socialimg_h); ?>"
            },
            "datePublished": "<?php _e($gmt_published); ?>",
            "dateModified": "<?php _e($gmt_modified); ?>",
            "inLanguage": "en-US"<?php _e($extra_schemae); ?>
          }
        }<?php endif; ?>
      ]
    }
  ]
}</script>
