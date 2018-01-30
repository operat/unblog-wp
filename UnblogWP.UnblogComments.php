<?php
/*
 * UnblogComments
 */

class UnblogWP_UnblogComments {

   /*
    * Constructor
    */

   public function __construct() {
      global $pagenow;

      $this->disable_admin_entries();
      $this->disable_support();
   }

   /*
    * Methods
    */

   public function disable_admin_entries() {
      // Remove from main admin navigation
      add_action('admin_menu', function () {
         remove_menu_page('edit-comments.php');
         remove_submenu_page('options-general.php', 'options-discussion.php');
      });

      // Remove from admin bar
      add_action('wp_before_admin_bar_render', function () {
         global $wp_admin_bar;
         $wp_admin_bar->remove_menu('comments');
      });

      // Remove metabox from dashboard
      add_action('wp_dashboard_setup', function () {
         global $wp_meta_boxes;
         unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_comments']);
      });

      // Redirect when trying to access edit page
      add_action('admin_init', function () {
         global $pagenow;
         switch ($pagenow) {
            case 'edit-comments.php':
            case 'options-discussion.php':
               wp_safe_redirect(get_admin_url(), 301);
               exit;
               break;
         }
      });
   }

   public function disable_support() {
      // Disable post type support
      add_action('admin_init', function () {
         $post_types = get_post_types();
         foreach ($post_types as $post_type) {
            if(post_type_supports($post_type, 'comments')) {
               remove_post_type_support($post_type, 'comments');
               remove_post_type_support($post_type, 'trackbacks');
            }
         }
      });

      // Close comments on the front-end
      add_filter('comments_open', function () { return false; }, 20, 2);
      add_filter('pings_open', function () { return false; }, 20, 2);

      // Hide existing comments
      add_filter('comments_array', function ($comments) {
         $comments = array();
         return $comments;
      }, 10, 2);
   }

}
