<?php
/*
 * PluginManager
 */

class UnblogWP_PluginManager {

   public static function init() {
      $options = get_option('unblog_wp_options');

      if ($options) {
         foreach ($options as $key => $value) {
            if ($key === 'disable-posts' && $value === 'on') {
               new UnblogWP_UnblogPosts();
            }
            if ($key === 'disable-comments' && $value === 'on') {
               new UnblogWP_UnblogComments();
            }
         }
      }
   }

   public static function setDefaultOptions() {
      $defaults = array(
         'disable-posts' => true,
         'disable-comments' => true
      );

      if (get_option('unblog_wp_options') === FALSE) {
         update_option('unblog_wp_options', $defaults);
      }

      return;
   }

}
