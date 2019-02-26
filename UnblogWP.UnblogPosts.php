<?php
/*
 * UnblogPosts
 */

class UnblogWP_UnblogPosts {

   /*
    * Constructor
    */

   public function __construct() {
      global $pagenow;

      $this->disable_support();
      $this->disable_admin_entries();

      if (!is_admin() && ($pagenow != 'wp-login.php')) {
         $this->remove_from_search();
         $this->redirect_to_error_page();
      }
   }

   /*
    * Methods
    */

   public function disable_admin_entries() {
      /* Remove from main admin navigation */
      add_action('admin_menu', function () {
         remove_menu_page('edit.php');
      });

      /* Remove from admin bar */
      add_action('wp_before_admin_bar_render', function () {
         global $wp_admin_bar;
         $wp_admin_bar->remove_node('new-post');
      }, 999);

      /* Remove metabox from dashboard */
      add_action('wp_dashboard_setup', function () {
         global $wp_meta_boxes;
         unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
         unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
      });

      /* Redirect when trying to access edit page */
      add_action('admin_init', function () {
         global $pagenow;
         switch ($pagenow) {
            case 'edit.php':
            case 'edit-tags.php':
            case 'post-new.php':
               /* Redirect taxonomy edit pages for posts, keep for other post types */
               if (!array_key_exists('post_type', $_GET) && !array_key_exists('taxonomy', $_GET) && !$_POST) {
                  wp_safe_redirect(get_admin_url(), 301);
                  exit;
               }
               break;
         }
      });
   }

   public function disable_support() {
      /* Unregister taxonomies */
      unregister_taxonomy_for_object_type('category', 'post');
      unregister_taxonomy_for_object_type('post_tag', 'post');

      /* Disable archive pages */
      add_action('template_redirect', function () {
         if (is_category() || is_tag() || is_date() || is_author()) {
            global $wp_query;
            $wp_query->set_404();
            status_header(404);
         }
      });
   }

   public function redirect_to_error_page() {
      add_action( 'template_redirect', function () {
         if (get_post_type() === 'post' && is_single()) {
            global $wp_query;
            $wp_query->set_404();
            status_header(404);
          }
      } );
   }

   public function remove_from_search() {
      add_filter('pre_get_posts', function ($query) {
         if (!is_search()) { return $query; }
         $post_types = get_post_types();
         /* Exclude posts from query results */
         foreach (array('post') as $value) {
            if (array_key_exists($value, $post_types) ) { unset($post_types[$value]); }
         }
         $query->set('post_type', array_values($post_types));
         return $query;
      });
   }

}
