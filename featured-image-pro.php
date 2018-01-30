<?php
/*
   Plugin Name: Featured Image Pro Post Grid
   Plugin URI: http://plugins.protoframework.com/featured-image-pro/
   Description: Flexible, Free Featured Image Masonry Widget & Shortcode by Shoofly Solutions
   Version: 3.14
   Author: A. R. Jones
   Author URI: http://shooflysolutions.com
 */
/*
   Copyright (C)  2016 Nomad Coder, Shoofly Solutions
   Contact me at http://www.shooflysolutions.com
   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
   GNU General Public License for more details.
   You should have received a copy of the GNU General Public License
   along with this program. If not, see <http://www.gnu.org/licenses/>.
   To Do: drop down options are not saving
   Need version of all/none for the customizer
 */
defined('ABSPATH') or die('No script kiddies please!');
define('FEATURED_IMAGE_PRO', TRUE);

add_action('plugins_loaded', 'featured_image_pro_widget_init');
function featured_image_pro_widget_init() {
	include_once(ABSPATH.'wp-admin/includes/plugin.php');
	if (!is_plugin_active('featured-image-pro-premium/featured-image-pro-premium.php') && (!is_plugin_active_for_network('featured-image-pro-premium/featured-image-pro-premium.php')))
	{
		$plugindir = plugin_dir_path( __FILE__ );
		$coredir = $plugindir . 'core/';
		require_once $coredir . 'featured-image-pro-exec.php';
		require_once $coredir . 'featured-image-pro-widget.php';
		require_once $coredir . 'functions/proto-global.php';
		require_once 'core-menu.php';

		add_action('admin_notices', 'featured_image_pro_free_admin_notice');

		function featured_image_pro_free_admin_notice() {
			global $current_user ;
		        $user_id = $current_user->ID;
		        /* Check that the user hasn't already clicked to ignore the message */
			if ( ! get_user_meta($user_id, 'featured_image_pro_free_admin_notice') ) {
		        echo '<div class="updated"><p>';
		        printf(__('Thanks for installing Featured Image Pro. There are some changes in version 3.0. Ready to go premium? Visit our <a href="http://plugins.protoframework.com/featured-image-pro/" target="_blank">website</a> for examples more information and a 15 percent discount!  | <a href="%1$s">Hide Notice</a>'), '?featured_image_pro_free_nag_ignore=0');
		        echo "</p></div>";
			}
		}

		add_action('admin_init', 'featured_image_pro_free_nag_ignore');

		function featured_image_pro_free_nag_ignore() {
			global $current_user;
		        $user_id = $current_user->ID;
		        /* If user clicks to ignore the notice, add that to their user meta */
		        if ( isset($_GET['featured_image_pro_free_nag_ignore']) && '0' == $_GET['featured_image_pro_free_nag_ignore'] ) {
		             add_user_meta($user_id, 'featured_image_pro_free_admin_notice', 'true', true);
			}
		}
	}


}
