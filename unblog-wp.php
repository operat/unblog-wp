<?php
/*
Plugin Name: Unblog WP
Plugin URI: https://github.com/operat/unblog-wp
GitHub Plugin URI: https://github.com/operat/unblog-wp
Description: Remove blog specific functionality like posts and comments from WordPress.
Version: 1.0
Author: Operat
Author URI: https://www.operat.de
License: GNU GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

if (!defined('WPINC')) { die; }

define('UNBLOG_WP_NAME', 'Unblog WP');
define('UNBLOG_WP_DESCRIPTION', 'Remove blog specific functionality like posts and comments from WordPress.');
define('UNBLOG_WP_URL', 'https://github.com/operat/unblog-wp');

require_once 'UnblogWP.UnblogComments.php';
require_once 'UnblogWP.UnblogPosts.php';
require_once 'UnblogWP.PluginManager.php';

add_action('init', array('UnblogWP_PluginManager', 'init'));
register_activation_hook(__FILE__, array('UnblogWP_PluginManager', 'setDefaultOptions'));

if (is_admin()) {
   require_once 'UnblogWP.SettingsPage.php';
   $settingsPage = new UnblogWP_SettingsPage();
}
