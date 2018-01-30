<?php
/*
 * SettingsPage
 */

class UnblogWP_SettingsPage {

   public function __construct() {
      add_action('admin_menu', array($this, 'addPage'));
      add_action('admin_init', array( $this, 'initPage'));
   }

   public function addPage() {
      add_options_page(
         UNBLOG_WP_NAME,
         UNBLOG_WP_NAME,
         'manage_options',
         'unblog-wp',
         array($this, 'createPage')
      );
   }

   public function createPage() {
      $this->options = get_option('unblog_wp_options');

      ?>
         <div class="wrap">
            <h1><?php echo UNBLOG_WP_NAME; ?></h1>
            <p>
               <b><?php echo UNBLOG_WP_DESCRIPTION; ?></b><br>
               Find information, report issues and make contributions on <a href="<?php echo UNBLOG_WP_URL; ?>" title="<?php echo UNBLOG_WP_NAME; ?>" target="_blank">GitHub</a>.
            </p>
            <form method="post" action="options.php">
            <?php
               settings_fields('unblog_wp');
               do_settings_sections('unblog-wp');
               submit_button();
            ?>
            </form>
         </div>
      <?php
   }

   public function initPage() {
      register_setting(
         'unblog_wp',
         'unblog_wp_options'
      );

      add_settings_section(
         'general-settings',
         'General Settings',
         array(
            $this,
            'printGeneralInfo'
         ),
         'unblog-wp'
      );

      add_settings_field(
         'disable-posts',
         'Disable posts',
         array(
            $this,
            'printCheckbox'
         ),
         'unblog-wp',
         'general-settings',
         array(
            $this,
            'field' => 'disable-posts',
            'description' => 'Disable post type “post” generally'
         )
      );

      add_settings_field(
         'disable-comments',
         'Disable comments',
         array(
            $this,
            'printCheckbox'
         ),
         'unblog-wp',
         'general-settings',
         array(
            $this,
            'field' => 'disable-comments',
            'description' => 'Disable comments generally'
         )
      );

   }

   public function printGeneralInfo() {
      // print '';
   }

   public function printCheckbox($args) {
      $field = $args['field'];
      $checked = isset($this->options[$field]) ? ' checked' : '';

      echo '<input type="checkbox" id="' . $field . '" name="unblog_wp_options[' . $field . ']"' . $checked . '><label for="' . $field . '">' . $args['description'] . '</label>';
   }

}
